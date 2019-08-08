<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Muser');
		$this->load->library('PHPMailerAutoload');
	}

	public function index()
	{
    if(isset($_GET['r'])):
			setcookie('partner_code', $_GET['r'], time() + (86400 * 90), "/");
			$data['partner_code'] = $_GET['r'];
		else:
			if(!isset($_COOKIE['partner_code'])):
				$data['partner_code'] = "";
			else:
				$data['partner_code'] = $_COOKIE['partner_code'];
			endif;
		endif;
		$this->load->view('auth',$data);
	}

  public function login()
  {
		$credential = $this->input->post('credential');
		$password = $this->input->post('password');

		$user_id = $this->Muser->check_user($credential);
		if($user_id < 1){
			# login gagal user tidak ditemukan
			echo json_encode(['status'=>0,'msg'=>'user tidak ditemukan']);
		}else{
			$user_data = $this->Muser->login($user_id,$password);
			if(is_array($user_data)){
				if ($user_data['status'] == 'aktif') {
					# login Berhasil

					# get poin user
					if($user_data['role']=="user"):
						$cust_data = $this->Mgeneral->getDetailId($user_id,'user_id','customer');

						$this->session->set_userdata(array_merge($user_data,['is_login'=>true,'komisi'=>$cust_data->komisi,'poin_sponsor'=>$cust_data->poin_sponsor,'poin_pelunasan'=>$cust_data->poin_pelunasan,'cust_type'=>$cust_data->cust_type]));
					else:
						$this->session->set_userdata(array_merge($user_data,['is_login'=>true,'cust_type'=>"staff"]));
					endif;

					echo json_encode(['status'=>1]);
				}else{
					# password tidak cocok
					echo json_encode(['status'=>0,'msg'=>'akun anda belum aktif, silahkan kontak admin']);
				}
			}else{
				# password tidak cocok
				echo json_encode(['status'=>0,'msg'=>'password tidak valid']);
			}
		}
  }

  public function register()
  {
    $var['nama']      = $this->input->post('nama');
		$var['email']     = $this->input->post('email');
		$var['hp']        = $this->input->post('hp');
		$var['kode_user'] = $this->Muser->generate_member_id();
		$var['referal']   = $this->input->post('referal');
		$var['role']      = 'user';
		$var['status']		= 'pending';

		if($this->Muser->check_email($var['email'])){
			$res['status'] = 0;
			$res['msg'] = "Email Telah Digunakan";
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
				$res['status'] = 1;
				$res['msg'] = "Pendaftaran Member Selesai, Silahkan Cek Email Untuk Aktivasi Akun";
			}else{
				$res['status'] = 0;
				$res['msg'] = "Terjadi Kesalahan, Silahkan Hubungi Admin";
			}
		}

		echo json_encode($res);
  }

	public function logout()
	{
		$this->session->sess_destroy();
		redirect ('/');
	}

	public function set_password($kode_user)
	{
		$user = $this->Muser->get_user_by_kode($kode_user);
		if($user != ""){
			$data['status'] = true;
			if($user->password != "" && $user->status == 'aktif'){
				# password telah di set sebelumnya, redirect ke login page
				redirect('auth');
			}else{
				$data['user'] = $user;
				$data['paket_umroh'] = $this->Mgeneral->getWhere(array('status'=>"1"),'paket_umroh');
				if ($user->referal != "") {
					$data['referal'] = $this->Mgeneral->getWhere(array('kode_user'=>$user->referal),'user');
				}
			}
		}else{
			# kode user tidak valid
			$data['status'] = false;
		}

		$this->load->view('set_password',$data);
	}

	public function save_password()
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
				echo json_encode(['status'=>0,'msg'=>'Kode Presenter tidak valid']); exit;
			}
			# check kode presenter tidak boleh sama dengan referal
			#$referal = $this->Muser->get_user_by_kode($user_data->referal);
			#if ($check_presenter->id == $referal->id) {
				#echo json_encode(['status'=>0,'msg'=>'Kode Presenter tidak boleh sama dengan referal']); exit;
			#}
			# check kode presenter tidak boleh sama dengan kode user
			#if($check_presenter->id == $user_data->id){
				#echo json_encode(['status'=>0,'msg'=>'Kode Presenter tidak boleh sama dengan kode user']); exit;
			#}
		}

		# update password user
		$this->Mgeneral->update(array('id'=>$user_id),array('password'=>md5($password)),'user');

		#tambah default cust data
		$var['user_id']      =$user_id;
		$var['cust_type']    =$jenis;
		$var['nama_lengkap'] =$user_data->nama;
		$var['email']        =$user_data->email;
		$var['hp']           =$user_data->hp;
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

		  $varTrx['id_cust']       =$customer_id;
		  $varTrx['id_marketing	'] =$idMarketing;
			$varTrx['id_presenter']  =$idPresenter;
		  $varTrx['id_paket']      =$idpaket;
		  $varTrx['harga']         =$harga;
		  $varTrx['status']        ="daftar";
		  $this->Mgeneral->save($varTrx,'trx_umroh');
	  endif;

		#kirim email
		$body_message = $this->load->view('emails/instruksi_pembayaran', array('user_data' => $user_data), true);
		$response = $this->send_email($user_data->email,$body_message);

		echo json_encode(['status'=>1]);
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

	public function forgot()
	{
		$this->load->view('forgot_password');
	}

	public function request_forgot()
	{
		$email = $this->input->post('email');

		$user_id = $this->Muser->check_user($email);
		if($user_id > 0){
			$token = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 25);
			$this->Mgeneral->update(array('id'=>$user_id),array('token_forgot_password'=>$token),'user');
			$body_message = $this->load->view('emails/reset_password', array('token_forgot_password'=>$token), true);
			$response = $this->send_email($email,$body_message);
			$data["msg"] = "Link reset password telah dikirim ke email anda.";
			$data["status"] = true;
		}else{
			$data["msg"] = "Email tidak terdaftar di system.";
			$data["status"] = false;
		}

		echo json_encode($data);
	}

	public function reset($token)
	{
		$user = $this->Mgeneral->getWhere(array('token_forgot_password'=>$token),'user');

		if(!empty($user)){
			$data['status'] = true;
			$data['user'] = $user[0];
		}else{
			$data['status'] = true;
		}

		$this->load->view('reset_password',$data);
	}

	public function update_password()
	{
		$user_id 	= $this->input->post('user_id');
		$password = $this->input->post('password');

		$this->Mgeneral->update(array('id'=>$user_id),array('password'=>md5($password),'token_forgot_password'=>null),'user');
		echo json_encode(['status'=>true]);
	}
}
