<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$_SESSION['is_login']):
			redirect('auth');
		endif;
    $this->load->model('Muser');
    $this->load->library('upload');
	}

	public function index()
	{
    $data['sidebar']  = array('profile'=>'active');
    $data['user']     = $this->Muser->get_profile($_SESSION['id']);
		$data['bank']     = $this->Mgeneral->getWhere(array('id_cust'=>$data['user']->id_cust),'cust_bank',"","","","");
    $data['provinsi'] = $this->Mgeneral->getAll('provinsi','name','asc','','');
    $data['kota']     = $this->Mgeneral->getWhere(array('province_id'=>$data['user']->id_provinsi),'kota','name','asc','','');
    $data['js_file']  = array('script/profile_page.js');
		$this->template->print_layout('profile',$data);
	}

  public function update()
  {
		$section = $this->input->post('section');
		switch ($section) {
			case 'profile':
				$user['nama']  = $this->input->post('nama');
				$user['email'] = $this->input->post('email');
				$user['hp']    = $this->input->post('hp');
				$this->Mgeneral->update(array('id'=>$_SESSION['id']),$user,'user');

				$customer['nama_lengkap'] = $this->input->post('nama');
				$customer['email']        = $this->input->post('email');
				$customer['hp']           = $this->input->post('hp');
				$customer['id_card']      = $this->input->post('id_card');
				$customer['tgl_lahir']    = to_mysql_date($this->input->post('tgl_lahir'));
				$customer['alamat']       = $this->input->post('alamat');
				$customer['id_kota']      = $this->input->post('kota');
				$customer['id_provinsi']  = $this->input->post('provinsi');
				$customer['kode_pos']     = $this->input->post('kode_pos');
				$this->Mgeneral->update(array('user_id'=>$_SESSION['id']),$customer,'customer');
				break;

			case 'persyaratan':
				$config['upload_path']   = './static/uploads/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['overwrite']     = true;

				# upload foto profile
				if(!empty($_FILES["foto_profile"]["tmp_name"])){
					$path_parts = pathinfo($_FILES["foto_profile"]["name"]);
					$extension = $path_parts['extension'];
					$config['file_name'] = "Profile_".$_SESSION['id'];
					$this->upload->initialize($config);
					$this->upload->do_upload('foto_profile');
					$this->Mgeneral->update(array('id'=>$_SESSION['id']),array('foto'=>$config['file_name'].".".$extension),'user');
					$this->session->set_userdata(array('foto'=>$config['file_name'].".".$extension));
				}

				# upload foto kk
				if(!empty($_FILES["foto_kk"]["tmp_name"])){
					$path_parts = pathinfo($_FILES["foto_kk"]["name"]);
					$extension = $path_parts['extension'];
					$config['file_name'] = "Kartu_Keluarga_".$_SESSION['id'];
					$this->upload->initialize($config);
					$this->upload->do_upload('foto_kk');
					$this->Mgeneral->update(array('user_id'=>$_SESSION['id']),array('foto_kk'=>$config['file_name'].".".$extension),'customer');
				}

				# upload foto ktp
				if(!empty($_FILES["foto_ktp"]["tmp_name"])){
					$path_parts = pathinfo($_FILES["foto_ktp"]["name"]);
					$extension = $path_parts['extension'];
					$config['file_name'] = "KTP_".$_SESSION['id'];
					$this->upload->initialize($config);
					$this->upload->do_upload('foto_ktp');
					$this->Mgeneral->update(array('user_id'=>$_SESSION['id']),array('foto_ktp'=>$config['file_name'].".".$extension),'customer');
				}

				# upload foto paspor
				if(!empty($_FILES["foto_paspor"]["tmp_name"])){
					$path_parts = pathinfo($_FILES["foto_paspor"]["name"]);
					$extension = $path_parts['extension'];
					$config['file_name'] = "PASPOR_".$_SESSION['id'];
					$this->upload->initialize($config);
					$this->upload->do_upload('foto_paspor');
					$this->Mgeneral->update(array('user_id'=>$_SESSION['id']),array('foto_paspor'=>$config['file_name'].".".$extension),'customer');
				}
				break;

			case 'password':
				$user['password'] = md5($this->input->post('password'));
				$this->Mgeneral->update(array('id'=>$_SESSION['id']),$user,'user');
				break;

			default:
				$id_cust = $this->Mgeneral->getValue('id_cust',array('user_id'=>$_SESSION['id']),'customer');
				$check = $this->Mgeneral->getWhere(array('id_cust'=>$id_cust),'cust_bank',"","","","");
				$akun_bank['nama_bank']    = $this->input->post('nama_bank');
				$akun_bank['nama_pemilik'] = $this->input->post('nama_pemilik');
				$akun_bank['no_rekening']  = $this->input->post('no_rekening');
				$akun_bank['cabang']       = $this->input->post('cabang');
				if(!empty($check)){
					# update akun bank
					$this->Mgeneral->update(array('id_cust'=>$id_cust),$akun_bank,'cust_bank');
				}else{
					# insert new
					$akun_bank['id_cust'] = $id_cust;
					$this->Mgeneral->save($akun_bank,'cust_bank');
				}
				break;
		}

		$this->session->set_flashdata('success','Profile Berhasil Disimpan');
		redirect('profile');
  }
}
