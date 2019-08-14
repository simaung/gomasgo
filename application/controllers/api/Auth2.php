<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Auth2 extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Muser');
		$this->load->library('PHPMailerAutoload');
    }

    public function login_post()
    {
        $credential = $this->input->post('credential');
        $password = $this->input->post('password');
        
        $user_id = $this->Muser->check_user($credential);
		if($user_id < 1){
            $this->response([
                'status'    => FALSE,
                'message'   => 'user tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }else{
            $user_data = $this->Muser->login($user_id,$password);
            if(is_array($user_data)){
				if ($user_data['status'] == 'aktif') {
					if($user_data['role']=="user"):
						$cust_data = $this->Mgeneral->getDetailId($user_id,'user_id','customer');

						$this->session->set_userdata(array_merge($user_data,['is_login'=>true,'komisi'=>$cust_data->komisi,'poin_sponsor'=>$cust_data->poin_sponsor,'poin_pelunasan'=>$cust_data->poin_pelunasan,'cust_type'=>$cust_data->cust_type]));
					else:
						$this->session->set_userdata(array_merge($user_data,['is_login'=>true,'cust_type'=>"staff"]));
					endif;

					$this->response([
                        'status'    => TRUE,
                        'data'      => $user_data
                    ], REST_Controller::HTTP_OK);
				}else{
                    $this->response([
                        'status'    => FALSE,
                        'message'   => 'akun anda belum aktif, silahkan kontak admin'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }else{
                $this->response([
                    'status'    => FALSE,
                    'message'   => 'username dan password tidak valid'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function register_post()
    {
        $var = array(
            'nama'      => $this->input->post('nama'),
            'email'     => $this->input->post('email'),
            'hp'        => $this->input->post('hp'),
            'kode_user' => $this->Muser->generate_member_id(),
            'referal'   => $this->input->post('referal'),
            'role'      => 'user',
            'status'    => 'pending'
        );        
        
		if($this->Muser->check_email($var['email'])){
			$this->response([
                'status'    => FALSE,
                'message'   => 'Email telah digunakan'
            ], REST_Controller::HTTP_BAD_REQUEST);
		}else{

			if($var['referal']!=""):
				$cekReferal = $this->Mgeneral->getWhere(array('kode_user'=>$var['referal']),"user");
				if(count($cekReferal)==0):
					$var['referal'] = "";
				endif;
			endif;

			$user = $this->Mgeneral->save($var,'user');
			if($user > 0){
				$data['user'] = $this->Mgeneral->getDetailId($user,'id','user');
				$body_message = $this->load->view('emails/account_activation', $data, true);
				$response = $this->send_email($data['user']->email,$body_message);
                $this->response([
                    'status'    => TRUE,
                    'message'   => 'Pendaftaran Member Selesai, Silahkan Cek Email Untuk Aktivasi Akun'
                ], REST_Controller::HTTP_OK);
			}else{
                $this->response([
                    'status'    => FALSE,
                    'message'   => 'Terjadi Kesalahan, Silahkan Hubungi Admin'
                ], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
    }

    public function password_post()
    {
        $user_id 	= $this->input->post('user_id');
		$password = $this->input->post('password');
		$presenter= $this->input->post('presenter');
		$jenis	= $this->input->post('jenis');

		$user_data=$this->Mgeneral->getDetailId($user_id,'id','user');
		if($presenter != ""){
			# check kode presenter apakah valid
			$check_presenter = $this->Muser->get_user_by_kode($presenter);
			if(count($check_presenter) < 1){
                $this->response([
                    'status'    => FALSE,
                    'message'   => 'Kode Presenter tidak valid'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        $this->Mgeneral->update(array('id'=>$user_id),array('password'=>md5($password)),'user');

        #tambah default cust data
        $var = array(
            'user_id'       => $user_id,
            'cust_type'     => $jenis,
            'nama_lengkap'  => $user_data->nama,
            'email'         => $user_data->email,
            'hp'            => $user_data->hp
        );
        
		$customer_id = $this->Mgeneral->save($var,'customer');
		$this->Mgeneral->save(array('user_id'=>$user_id),'bonus_breakdown');

		#tambah proses transaksi umroh
        $idpaket=$this->input->post('paket');
        $harga=$this->Mgeneral->getValue('harga',array('id_paket'=>$idpaket),'paket_umroh');

        if($harga):
            $cekReferal = $this->Mgeneral->getValue('referal',array('id'=>$user_id,),'user');
            if($cekReferal!=""):
                $idMarketing = $this->Mgeneral->getValue('id',array('kode_user'=>$cekReferal),'user');
            else:
                $idMarketing = "";
            endif;

            if($presenter != ""):
                $idPresenter = $check_presenter->id;
            else:
                $idPresenter = $idMarketing;
            endif;

            $varTrx = array(
                'id_cust'       => $customer_id,
                'id_marketing'  => $idMarketing,
                'id_presenter'  => $idPresenter,
                'id_paket'      => $idpaket,
                'harga'         => $harga,
                'status'        => "daftar"
            );
            $this->Mgeneral->save($varTrx,'trx_umroh');
        endif;

		#kirim email
		$body_message = $this->load->view('emails/instruksi_pembayaran', array('user_data' => $user_data), true);
		$response = $this->send_email($user_data->email,$body_message);

		$this->response([
            'status'    => TRUE
        ], REST_Controller::HTTP_OK);
    }

    private function send_email($receiver,$body_message)
	{
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        $mail->SMTPSecure = $this->config->item('smtp_secure');
        $mail->Host       = $this->config->item('smtp_host'); // setting host as our SMTP server
        $mail->Port       = $this->config->item('smtp_port'); // SMTP port to connect
        $mail->Username   = $this->config->item('smtp_user');  // user smtp account
        $mail->Password   = $this->config->item('smtp_pass');  // password smtp account
        $mail->AddReplyTo($this->config->item('reply_to'), $this->config->item('from_name'));
        $mail->SetFrom($this->config->item('from_email'), $this->config->item('from_name'));   //Who is sending the email
        $mail->Subject    = "Account Activation GOMASGO";
        $mail->Body       = $body_message;
        $mail->isHTML(true); // Set email format to HTML
        $mail->AddAddress($receiver);
        if(!$mail->Send()) {
            $data["status"]  = false;
            $data["message"] = "Error: " . $mail->ErrorInfo;
        } else {
            $data["message"] = "Message sent correctly!";
            $data["status"] = true;
        }
        return $data;
    }
    

    public function request_forgot_post()
    {
        $email = $this->input->post('email');

		$user_id = $this->Muser->check_user($email);
		if($user_id > 0){
			$token = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 25);
			$this->Mgeneral->update(array('id'=>$user_id),array('token_forgot_password'=>$token),'user');
			$body_message = $this->load->view('emails/reset_password', array('token_forgot_password'=>$token), true);
			$response = $this->send_email($email,$body_message);
            $this->response([
                'status'    => TRUE,
                'message'   => 'Link reset password telah dikirim ke email anda.'
            ], REST_Controller::HTTP_OK);
		}else{
            $this->response([
                'status'    => FALSE,
                'message'   => 'Email tidak terdaftar di system.'
            ], REST_Controller::HTTP_BAD_REQUEST);
		}
    }

    public function reset($token)
    {
        
    }

}
