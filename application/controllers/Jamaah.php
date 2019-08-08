<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jamaah extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$_SESSION['is_login']):
			redirect('auth');
		endif;
    $this->load->library('upload');
	}

	public function index()
	{
		$setting['sidebar']=array('jamaah'=>"active");
		$setting['js_file']=array('assets/vendor/jquery.dataTables.min.js','assets/vendor/datatables-bootstrap3.min.js','assets/js/datatables.js','script/transaksi.js');

		$this->template->print_layout('jamaah/data',$setting);
	}

  public function tambah()
  {
    $setting['sidebar']  = array('jamaah' =>"active");
		$setting['js_file']  = array('script/jamaah.js');
    $setting['provinsi'] = $this->Mgeneral->getAll('provinsi','name','asc','','');
		$setting['paket'] = $this->Mgeneral->getWhere(array('status'=>"1"),'paket_umroh','harga','asc','','');

		$this->template->print_layout('jamaah/tambah',$setting);
  }

  public function save($id_cust = 0)
  {
    $customer['nama_lengkap'] = $this->input->post('nama');
    $customer['email']        = $this->input->post('email');
    $customer['hp']           = $this->input->post('hp');
    $customer['id_card']      = $this->input->post('id_card');
    $customer['tgl_lahir']    = to_mysql_date($this->input->post('tgl_lahir'));
    $customer['alamat']       = $this->input->post('alamat');
    $customer['id_kota']      = $this->input->post('kota');
    $customer['id_provinsi']  = $this->input->post('provinsi');
    $customer['kode_pos']     = $this->input->post('kode_pos');
    $customer['cust_type']    = "jamaah";
    if($id_cust == 0){
      $customer_id = $this->Mgeneral->save($customer,'customer');

		  #tambah proses transaksi umroh
		  $idpaket=$this->input->post('paket');
		  $harga=$this->Mgeneral->getValue('harga',array('id_paket'=>$idpaket),'paket_umroh');

		  if($harga):
				if($this->input->post('presenter') != ""):
					$idPresenter = $check_presenter->id;
				else:
					$idPresenter = "";
				endif;

			  $varTrx['id_cust']=$customer_id;
			  $varTrx['id_marketing	']=$_SESSION['id'];
				$varTrx['id_presenter']  =$idPresenter;
			  $varTrx['id_paket']=$idpaket;
			  $varTrx['harga']=$harga;
			  $varTrx['status']="daftar";
			  $this->Mgeneral->save($varTrx,'trx_umroh');
		  endif;

    }else{
      $customer_id = $id_cust;
      $this->Mgeneral->update(array('id_cust'=>$id_cust),$customer,'customer');
    }

    if($customer_id > 0){
      $config['upload_path']   = './static/uploads/';
      $config['allowed_types'] = 'gif|jpg|png';
  		$config['overwrite']     = true;

      # upload foto kk
  		if(!empty($_FILES["foto_kk"]["tmp_name"])){
  	    $path_parts = pathinfo($_FILES["foto_kk"]["name"]);
  	    $extension = $path_parts['extension'];
  	    $config['file_name'] = "Kartu_Keluarga_".$customer_id;
  	    $this->upload->initialize($config);
  			$this->upload->do_upload('foto_kk');
  			$this->Mgeneral->update(array('id_cust'=>$customer_id),array('foto_kk'=>$config['file_name'].".".$extension),'customer');
  		}

      # upload foto ktp
  		if(!empty($_FILES["foto_ktp"]["tmp_name"])){
  	    $path_parts = pathinfo($_FILES["foto_ktp"]["name"]);
  	    $extension = $path_parts['extension'];
  	    $config['file_name'] = "KTP_".$customer_id;
  	    $this->upload->initialize($config);
  			$this->upload->do_upload('foto_ktp');
  			$this->Mgeneral->update(array('id_cust'=>$customer_id),array('foto_ktp'=>$config['file_name'].".".$extension),'customer');
  		}

  		# upload foto paspor
  		if(!empty($_FILES["foto_paspor"]["tmp_name"])){
  	    $path_parts = pathinfo($_FILES["foto_paspor"]["name"]);
  	    $extension = $path_parts['extension'];
  	    $config['file_name'] = "PASPOR_".$customer_id;
  	    $this->upload->initialize($config);
  			$this->upload->do_upload('foto_paspor');
  			$this->Mgeneral->update(array('id_cust'=>$customer_id),array('foto_paspor'=>$config['file_name'].".".$extension),'customer');
  		}

      $this->session->set_flashdata('success','Data Jamaah Berhasil Disimpan');
    }else{
      $this->session->set_flashdata('error','Data Jamaah Gagal Disimpan');
    }

    if($id_cust == 0){
      redirect('jamaah/tambah');
    }else{
      redirect('jamaah/edit/'.$id_cust);
    }
  }

  public function edit($id_cust)
  {
    $customer = $this->Mgeneral->getWhere(array('id_cust'=>$id_cust),'customer',"","","","");
    if(!empty($customer)){
      $setting['customer'] = $customer[0];
      $setting['provinsi'] = $this->Mgeneral->getAll('provinsi','name','asc','','');
      $setting['kota']     = $this->Mgeneral->getWhere(array('province_id'=>$setting['customer']->id_provinsi),'kota','name','asc','','');
    }else{
      $setting['error'] = true;
    }
    $setting['sidebar']  = array('jamaah' =>"active");
		$setting['js_file']  = array('script/jamaah.js');

		$this->template->print_layout('jamaah/edit',$setting);
  }

  public function view($id_cust)
  {
    $customer = $this->Mgeneral->getDetailId($id_cust,'id_cust','customer');
    if(!empty($customer)){

      $customer->nama_provinsi = ($customer->id_provinsi) ? $this->Mgeneral->getValue('name',array('id'=>$customer->id_provinsi),'provinsi') : ' ';
      $customer->nama_kota = ($customer->id_kota) ? $this->Mgeneral->getValue('name',array('id'=>$customer->id_kota),'kota') : ' ';
      $setting['customer'] = $customer;
    }else{
      $setting['error'] = true;
    }
    $setting['sidebar']  = array('jamaah' =>"active");
	$setting['js_file']=array('assets/vendor/jquery.dataTables.min.js','assets/vendor/datatables-bootstrap3.min.js','assets/js/datatables.js');
		$this->template->print_layout('jamaah/view',$setting);
  }

  public function delete($id_cust)
  {
    $customer = $this->Mgeneral->getWhere(array('id_cust'=>$id_cust,'cust_type'=>'jamaah'),'customer',"","","","");
    if(!empty($customer)){
      $customer_id = $customer[0]->id_cust;
      $this->Mgeneral->delete(array('id_cust'=>$customer_id),'customer');
      $data = array(
        'status' => true,
        'msg' => "Data Jamaah Berhasil Dihapus"
      );
    }else{
      $data = array(
        'status' => true,
        'msg' => "Data Jamaah Gagal Dihapus"
      );
    }

    echo json_encode($data);
  }
}
