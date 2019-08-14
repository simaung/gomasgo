<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';

use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('PHPMailerAutoload');

        $this->load->model('Muser');
    }

    public function login_post()
    {
        $credential = $this->post('credential');
        $password   = $this->post('password');

        $user_id = $this->Muser->check_user($credential);
        if($user_id < 1){
            $this->response(['msg' => 'user tidak ditemukan'], parent::HTTP_NOT_FOUND);
        }else{
            $user_data = $this->Muser->login($user_id,$password);
            if(is_array($user_data)){
				if ($user_data['status'] == 'aktif') {
                    // Create a token from the user data and send it as reponse
                    $token = AUTHORIZATION::generateToken(['id' => $user_data['id']]);
                    // Prepare the response
                    $status = parent::HTTP_OK;
                    $response = ['status' => $status, 'token' => $token];
                    $this->response($response, $status);
                }else{
                    $this->response(['msg' => 'akun anda belum aktif, silahkan kontak admin'], parent::HTTP_NOT_FOUND);
                }
            }else{
                $this->response(['msg' => 'username dan password tidak valid'], parent::HTTP_NOT_FOUND);
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
			$this->response(['msg' => 'Email telah digunakan'], parent::HTTP_BAD_REQUEST);
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
                $email_send = $this->send_email($data['user']->email,$body_message);

                $status = parent::HTTP_OK;
                $response = ['status' => $status, 'msg' => 'Pendaftaran Member Selesai, Silahkan Cek Email Untuk Aktivasi Akun'];
                $this->response($response, $status);
			}else{
                $this->response(['msg' => 'Terjadi Kesalahan, Silahkan Hubungi Admin'], parent::HTTP_BAD_REQUEST);
			}
		}
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
            
            $status = parent::HTTP_OK;
            $response = ['status' => $status, 'msg' => 'Link reset password telah dikirim ke email anda.'];
            $this->response($response, $status);
		}else{
            $this->response(['message' => 'Email tidak terdaftar di system.'], parent::HTTP_BAD_REQUEST);
		}
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

}