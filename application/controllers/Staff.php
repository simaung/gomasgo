<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller
{

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
    $setting['sidebar']=array('staff'=>"active");
		$setting['js_file']=array('assets/vendor/jquery.dataTables.min.js','assets/vendor/datatables-bootstrap3.min.js','assets/js/datatables.js');

		$this->template->print_layout('staff/data',$setting);
  }

  public function cabang()
  {
    $setting['sidebar']=array('cabang'=>"active");
    $setting['js_file']=array('assets/vendor/jquery.dataTables.min.js','assets/vendor/datatables-bootstrap3.min.js','assets/js/datatables.js');

    $this->template->print_layout('staff/cabang',$setting);
  }

  public function tambah($tipe='staff')
  {
    $setting['sidebar']=array("$tipe"=>"active");
		$setting['js_file']=array('script/staff.js');
    $setting['tipe'] = $tipe;
		$this->template->print_layout('staff/tambah',$setting);
  }

  public function save($user_id = 0)
  {
    $var['nama']      = $this->input->post('nama');
		$var['email']     = $this->input->post('email');
		$var['hp']        = $this->input->post('hp');
    $var['password']  = md5($this->input->post('password'));
		$var['role']      = $this->input->post('tipe');

		if($this->Muser->check_email($var['email'],$user_id)){
			$this->session->set_flashdata('error',"Email Telah Digunakan");
		}else{
      if($user_id == 0){
        $user = $this->Mgeneral->save($var,'user');
      }else{
        $this->Mgeneral->update(array('id'=>$user_id),$var,'user');
        $user = $user_id;
      }

			if($user > 0){
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
        $this->session->set_flashdata('success',"Pendaftaran ".$var['role']." Selesai");
			}else{
        $this->session->set_flashdata('error',"Terjadi Kesalahan, Silahkan Hubungi Admin");
			}
		}

    redirect('staff/tambah/'.$var['role']);
  }

  public function edit($user_id)
  {
    $user = $this->Mgeneral->getDetailId($user_id,'id','user');
    if(!empty($user)){
      $setting['user'] = $user;
    }
    $setting['sidebar']=array("$user->role"=>"active");
		$setting['js_file']=array('script/staff.js');
    $setting['tipe'] = $user->role;
		$this->template->print_layout('staff/tambah',$setting);
  }

  public function delete($user_id)
  {
    $user = $this->Mgeneral->getWhere(array('id'=>$user_id),'user',"","","","");
    if(!empty($user)){
      $user_id = $user[0]->id;
      $tipe=$user[0]->role;
      $this->Mgeneral->delete(array('id'=>$user_id),'user');
      $data = array(
        'status' => true,
        'msg' => "Data ".$tipe." Berhasil Dihapus"
      );
    }else{
      $data = array(
        'status' => true,
        'msg' => "Data ".$tipe." Gagal Dihapus"
      );
    }

    echo json_encode($data);
  }
}
