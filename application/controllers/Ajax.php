<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Muser');
	}

	public function get_kota_by_provinsi($id_provinsi)
	{
    $kota = $this->Mgeneral->getWhere(array('province_id'=>$id_provinsi),'kota','name','asc','','');
    $option = "<option value=''>-- Pilih Kota --</option>";

    foreach ($kota as $key) {
      $option .= "<option value='".$key->id."'>".$key->name."</option>";
    }

    echo $option;
	}

	public function get_presenter()
	{
		$search = $this->input->get('term');

		$sql = "SELECT kode_user FROM user WHERE role = 'user' AND kode_user LIKE '".$search."%' ORDER BY kode_user";
		$data = $this->Mgeneral->post_query_sql($sql);

		$list = array();
		foreach ($data as $key) {
			array_push($list,$key->kode_user);
		}

		echo json_encode($list);
	}

	public function check_presenter()
	{
		$presenter = $this->input->get('presenter');
		# check kode presenter apakah valid
		$check_presenter = $this->Muser->get_user_by_kode($presenter);
		if(count($check_presenter) < 1){
			echo json_encode(['status'=>0,'msg'=>'Kode Presenter tidak valid']); exit;
		}
		# check kode presenter tidak boleh sama dengan referal
		if($_SESSION['role'] == 'user'){
			if ($check_presenter->id == $_SESSION['id']) {
				echo json_encode(['status'=>0,'msg'=>'Kode Presenter tidak boleh sama dengan referal']); exit;
			}
		}
		echo json_encode(['status'=>1]);
	}
}
