<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$_SESSION['is_login']):
			redirect('auth');
		endif;
	}

	public function index()
	{
		$setting['sidebar']=array('transaksi'=>"active");
		$setting['js_file']=array('assets/vendor/jquery.dataTables.min.js','assets/vendor/datatables-bootstrap3.min.js','assets/js/datatables.js');

		$this->template->print_layout('transaksi/data',$setting);
	}

	public function view($id_trx)
  {
    $sql="SELECT a.*,b.*,c.*,d.nama as marketing,d.kode_user as kode_marketing,g.nama as presenter,g.kode_user as kode_presenter,e.name as provinsi,f.name as kota
			FROM `trx_umroh` a
			LEFT JOIN customer b ON a.id_cust = b.id_cust
			LEFT JOIN paket_umroh c ON a.id_paket = c.id_paket
			LEFT JOIN user d ON a.id_marketing = d.id
			LEFT JOIN user g ON a.id_presenter = g.id
			LEFT JOIN provinsi e ON b.id_provinsi = e.id
			LEFT JOIN kota f ON b.id_kota = f.id
			WHERE `id_trx` = '".$id_trx."'";
		$trx = $this->Mgeneral->post_query_sql($sql);
		if(!empty($trx)){
    		$setting['trx'] = $trx;
			$setting['pembayaran']=$this->Mgeneral->getWhere(array('id_trx'=>$id_trx),'pembayaran_trx','id_trx','asc');
			$setting['bonus']=$this->Mgeneral->getWhere(array('id_trx'=>$id_trx),'bonus_history','id_bonus','asc');
		}else{
			$setting['error'] = true;
		}
		$setting['sidebar'] = array('transaksi' =>"active");
		$setting['js_file'] = array('script/transaksi.js');
		$this->template->print_layout('transaksi/view',$setting);
  }

	public function pembayaran($id_trx)
	{
		$data['id_trx']           = $id_trx;
		$data['nominal']          = rupiah_to_int($this->input->post('jumlah'));
		$data['jenis_trx']        = $this->input->post('jenis');
		$data['jenis_pembayaran'] = $this->input->post('via');

		$pembayaran_id = $this->Mgeneral->save($data,'pembayaran_trx');
		if($pembayaran_id > 0){
			# berhasil

			# update status transaksi
			$sql = "SELECT SUM(nominal) AS total FROM pembayaran_trx WHERE id_trx = ".$id_trx;
			$result = $this->Mgeneral->post_query_sql($sql);
			$total_transaksi = $this->Mgeneral->getValue('harga',array('id_trx'=>$id_trx),'trx_umroh');
			if($result[0]->total >= $total_transaksi){
				$field['status'] = 'lunas';
			}else{
				$field['status'] = $this->input->post('jenis');
			}
			$this->Mgeneral->update(array('id_trx'=>$id_trx),$field,'trx_umroh');

			# aktivasi user
			$customer_id = $this->Mgeneral->getValue('id_cust',array('id_trx'=>$id_trx),'trx_umroh');
			$user_id = $this->Mgeneral->getValue('user_id',array('id_cust'=>$customer_id),'customer');
			$this->Mgeneral->update(array('id'=>$user_id),array('status'=>'aktif'),'user');

			#eksekusi bonus jaringan disini
			if($this->input->post('jenis')=="dp"):
				bonus_sponsor($id_trx);
			endif;

			echo json_encode(['status'=>true]);
		}else{
			# gargal
			echo json_encode(['status'=>false]);
		}
	}

	public function sales_poin()
	{
		$setting['sidebar']=array('transaksi'=>"active");
		$trx = $this->Mgeneral->getWhere(array('user_id'=>$_SESSION['id']),'bonus_breakdown');
		$set = $this->Mgeneral->getWhere(array('setting_group'=>"sales poin"),'setting');
    	$setting['bonus'] = $trx;
    	$setting['set'] = $set;
		$this->template->print_layout('transaksi/sales_poin',$setting);
	}
	/*public function tes($idtrx)
	{
		echo "<pre>";
		bonus_sponsor($idtrx);
	}*/
}
