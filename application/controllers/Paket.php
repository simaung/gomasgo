<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if (!$_SESSION['is_login']):
			redirect('auth');
		endif;
  }

  public function index()
  {
    $setting['sidebar']=array('paket'=>"active");
		$setting['js_file']=array('assets/vendor/jquery.dataTables.min.js','assets/vendor/datatables-bootstrap3.min.js','assets/js/datatables.js');

		$this->template->print_layout('paket/data',$setting);
  }

  public function tambah()
  {
    $setting['sidebar']=array('paket'=>"active");
    $setting['js_file']=array('script/paket.js');
		$this->template->print_layout('paket/tambah',$setting);
  }

  public function save($paket_id = 0)
  {
    $paket['nama_paket'] = $this->input->post('nama');
    $paket['harga']      = rupiah_to_int($this->input->post('harga'));
    $paket['harga_cabang']     = rupiah_to_int($this->input->post('harga_cabang'));
    $paket['status']     = $this->input->post('status');

    if($paket_id == 0){
      $paket_id = $this->Mgeneral->save($paket,'paket_umroh');
    }else{
      $this->Mgeneral->update(array('id_paket'=>$paket_id),$paket,'paket_umroh');
    }
    $this->session->set_flashdata('success','Paket Berhasil Disimpan');
    redirect('paket/tambah');
  }

  public function edit($paket_id)
  {
    $setting['paket'] = $this->Mgeneral->getDetailId($paket_id,'id_paket','paket_umroh');
    $setting['sidebar']=array('paket'=>"active");
    $setting['js_file']=array('script/paket.js');
		$this->template->print_layout('paket/tambah',$setting);
  }

  public function delete($id_paket)
  {
    $paket = $this->Mgeneral->getWhere(array('id_paket'=>$id_paket),'paket_umroh',"","","","");
    if(!empty($paket)){
      $id_paket = $paket[0]->id_paket;
      $this->Mgeneral->delete(array('id_paket'=>$id_paket),'paket_umroh');
      $data = array(
        'status' => true,
        'msg' => "Data Paket Berhasil Dihapus"
      );
    }else{
      $data = array(
        'status' => false,
        'msg' => "Data Paket Gagal Dihapus"
      );
    }

    echo json_encode($data);
  }
}
