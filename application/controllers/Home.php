<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$_SESSION['is_login']):
			redirect('auth');
		endif;

		if($_SESSION['role']=="staff"):
			redirect('marketing');
		elseif($_SESSION['role']=="cabang"):
			redirect('jamaah');
		endif;
	}

	public function index()
	{
		$profile = $this->Mgeneral->getWhere(array('user_id'=>$_SESSION['id']),'customer');
		if(empty($profile[0]->id_card) || empty($profile[0]->tgl_lahir) || empty($profile[0]->alamat) || empty($profile[0]->foto_ktp)){
			$setting['profile'] = true;
		}
		$sql = "select a.id_cust,a.nama_lengkap,b.harga,b.status from customer a
				LEFT JOIN trx_umroh b ON a.id_cust = b.id_cust
				LEFT JOIN paket_umroh c ON b.id_paket = c.id_paket
				WHERE b.id_marketing ='".$_SESSION['id']."' AND b.status != 'lunas' limit 20";
		$data = $this->Mgeneral->post_query_sql($sql);
		$data2 = $this->Mgeneral->post_query_sql("SELECT count(*) as total,(select count(*) from trx_umroh where id_marketing = '".$_SESSION['id']."' and status='lunas') as lunas FROM trx_umroh WHERE `id_marketing` = '".$_SESSION['id']."'");
		$sql2 = "SELECT a.*,(select sum(nominal) from pembayaran_trx b where b.id_trx = a.id_trx) as dibayar FROM trx_umroh a WHERE a.id_cust = '".$profile[0]->id_cust."'";
		$data3 = $this->Mgeneral->post_query_sql($sql2);

		$setting['jamaah'] = $data;
		$setting['stat'] = $data2;
		$setting['bayar'] = $data3;
		$setting['sidebar']=array('home'=>"active");
		$this->template->print_layout('home',$setting);
	}
}
