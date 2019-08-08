<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$_SESSION['is_login']):
			redirect('auth');
		endif;
		$this->load->model('Muser');
	}

	public function index()
	{
		$setting['sidebar']=array('marketing'=>"active");
		$setting['js_file']=array('assets/vendor/jquery.dataTables.min.js','assets/vendor/datatables-bootstrap3.min.js','assets/js/datatables.js','script/transaksi.js');

		$this->template->print_layout('marketing/data',$setting);
	}

	public function view($id_marketing)
  	{
    	$sql="select * from user a LEFT JOIN customer b ON a.id = b.user_id where a.id ='".$id_marketing."'";
		$dat = $this->Mgeneral->post_query_sql($sql);
		if(!empty($dat)){
    		$setting['marketing'] = $dat;
		}else{
			$setting['error'] = true;
		}
		$setting['sidebar']  = array('marketing' =>"active");
		$setting['meta']= array('kode'=>$dat[0]->kode_user,'id'=>$id_marketing);
		$setting['js_file']=array('assets/vendor/jquery.dataTables.min.js','assets/vendor/datatables-bootstrap3.min.js','assets/js/datatables.js');
		$this->template->print_layout('marketing/view',$setting);
  	}

	public function tambah()
	{
		$setting['sidebar']  = array('marketing' =>"active");
		$setting['provinsi'] = $this->Mgeneral->getAll('provinsi','name','asc','','');
		$setting['paket'] = $this->Mgeneral->getWhere(array('status'=>"1"),'paket_umroh','harga','asc','','');
		$setting['js_file']=array('script/marketing.js');
		$this->template->print_layout('marketing/tambah',$setting);
	}

	public function save()
	{
		# validasi kode presenter
		if($this->input->post('presenter') != ""){
			# check kode presenter apakah valid
			$check_presenter = $this->Muser->get_user_by_kode($this->input->post('presenter'));
			if(count($check_presenter) < 1){
				echo json_encode(['status'=>0,'msg'=>'Kode Presenter tidak valid']); exit;
			}
			/*
			if($_SESSION['role'] == 'user'){
				# check kode presenter tidak boleh sama dengan referal
				if ($check_presenter->id == $_SESSION['id']) {
					echo json_encode(['status'=>0,'msg'=>'Kode Presenter tidak boleh sama dengan referal']); exit;
				}
			}
			*/
		}

		$user_data['nama']     = $this->input->post('nama');
		$user_data['kode_user']= $this->Muser->generate_member_id();
    $user_data['email']    = $this->input->post('email');
    $user_data['hp']       = $this->input->post('hp');
		$user_data['referal']  = $this->input->post('referal');
		$user_data['password'] = md5($this->input->post('password'));
		$user_data['role']     = 'user';
		$user_data['status']   = 'pending';
		# save data
		$user_id = $this->Mgeneral->save($user_data,'user');
		$this->Mgeneral->save(array('user_id'=>$user_id),'bonus_breakdown');

		$customer['user_id']			= $user_id;
		$customer['nama_lengkap'] = $this->input->post('nama');
    $customer['email']        = $this->input->post('email');
    $customer['hp']           = $this->input->post('hp');
    $customer['id_card']      = $this->input->post('id_card');
    $customer['tgl_lahir']    = to_mysql_date($this->input->post('tgl_lahir'));
    $customer['alamat']       = $this->input->post('alamat');
    $customer['id_kota']      = $this->input->post('kota');
    $customer['id_provinsi']  = $this->input->post('provinsi');
    $customer['kode_pos']     = $this->input->post('kode_pos');
    $customer['cust_type']    = "marketing";

		$customer_id = $this->Mgeneral->save($customer,'customer');

		#tambah proses transaksi umroh
		$idpaket=$this->input->post('paket');
		$harga=$this->Mgeneral->getValue('harga',array('id_paket'=>$idpaket),'paket_umroh');

		if($harga):
			if($this->input->post('presenter') != ""):
				$idPresenter = $_SESSION['id']; // jika kode presenter kosong makan isi default dengan kode user markering
			else:
				$idPresenter = "";
			endif;

			$varTrx['id_cust']       =$customer_id;
			$varTrx['id_marketing	'] =$_SESSION['id'];
			$varTrx['id_presenter']  =$idPresenter;
			$varTrx['id_paket']      =$idpaket;
			$varTrx['harga']         =$harga;
			$varTrx['status']        ="daftar";
			$this->Mgeneral->save($varTrx,'trx_umroh');
		endif;

		echo json_encode(['status'=>1,'msg'=>'Data Marketing Berhasil Disimpan']);
	}
}
