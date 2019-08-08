<?php

class Load extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('datatables');
    }

    function data_marketing() {
        $this->datatables->select('a.id,t.id_trx,a.reg_date,a.kode_user,a.nama,a.email,a.hp,b.total_agent,a.status');
        $this->datatables->from('user a');
        $this->datatables->join('customer c', 'a.id = c.user_id');
        $this->datatables->join('trx_umroh t', 'c.id_cust = t.id_cust', 'left');
	      $this->datatables->join('referal_agent b', 'a.id = b.id', 'left');
        $this->datatables->where('role','user');
    	if($_SESSION['role']=="user"):
    			$this->datatables->where('referal',$_SESSION['kode_user']);
      			$this->datatables->add_column('action','$1',"aksi('id','marketing','true','false','false')");
        else:
      		$this->datatables->add_column('action','$1',"aktifasi_marketing(id,id_trx,'marketing','status')");
        endif;
    	$this->datatables->edit_column('status','$1',"status_user('status')");
        $this->datatables->unset_column('id');
        $this->datatables->unset_column('id_trx');
        echo $this->datatables->generate();
        exit;
    }

    function data_marketing2($id) {
        $this->datatables->select('a.reg_date,a.kode_user,a.nama,b.total_agent');
        $this->datatables->from('user a');
        $this->datatables->join('referal_agent b', 'a.id = b.id', 'left');
        $this->datatables->where('role','user');
        $this->datatables->where('referal',$id);
        echo $this->datatables->generate();
        exit;
    }

	function data_jamaah()
	{
		$this->datatables->select('a.id_cust,b.id_trx,a.nama_lengkap,a.hp,b.trx_date,c.nama_paket,b.status');
		$this->datatables->from('customer a');
		$this->datatables->join('trx_umroh b', 'a.id_cust = b.id_cust', 'left');
		$this->datatables->join('paket_umroh c', 'b.id_paket = c.id_paket', 'left');
		if($_SESSION['role']=="staff"):
			$this->datatables->add_column('action','$1',"aksi_jamaah('id_cust','id_trx','jamaah','status')");
		else:
            $this->datatables->where('b.id_marketing',$_SESSION['id']);
			$this->datatables->add_column('action','$1',"aksi('id_cust','jamaah','true','false','false')");
		endif;
		$this->datatables->edit_column('nama_lengkap', '$1', "c_link('nama_lengkap','id_cust','jamaah')");
		$this->datatables->edit_column('status','$1',"status_trx('status')");
		$this->datatables->unset_column('id_cust');
        $this->datatables->unset_column('b.id_trx');
		echo $this->datatables->generate();
		exit;
	}

    function data_jamaah2($id)
    {
        $this->datatables->select('b.trx_date,a.nama_lengkap,c.nama_paket,b.status');
        $this->datatables->from('customer a');
        $this->datatables->join('trx_umroh b', 'a.id_cust = b.id_cust', 'left');
        $this->datatables->join('paket_umroh c', 'b.id_paket = c.id_paket', 'left');
        $this->datatables->where('cust_type','jamaah');
        $this->datatables->where('b.id_marketing',$id);
        echo $this->datatables->generate();
        exit;
    }

	function trx_jamaah()
	{
		$this->datatables->select('a.id_trx,a.trx_date,b.nama_lengkap,c.nama_paket,a.harga,(select sum(nominal) as dibayar from pembayaran_trx d where a.id_trx = d.id_trx) as total,a.status');
		$this->datatables->from('trx_umroh a');
		$this->datatables->join('customer b', 'a.id_cust = b.id_cust', 'left');
		$this->datatables->join('paket_umroh c', 'a.id_paket = c.id_paket', 'left');
		$this->datatables->where('id_marketing',$_SESSION['id']);
		//$this->datatables->add_column('action','$1',"aksi('id_cust','jamaah','true','false','false')");
		$this->datatables->edit_column('status','$1',"status_trx('status')");
	    $this->datatables->edit_column('harga','$1',"int_to_rupiah('harga')");
    	$this->datatables->edit_column('total','$1',"int_to_rupiah('total')");
		$this->datatables->unset_column('a.id');
		echo $this->datatables->generate();
		exit;
	}

  public function data_staff()
  {
    $this->datatables->select('id,nama,email,hp');
    $this->datatables->from('user');
    $this->datatables->unset_column('id');
    $this->datatables->add_column('action','$1',"aksi('id','staff','false','true','true')");
    $this->datatables->where('role','staff');
    echo $this->datatables->generate();
    exit;
  }

  public function data_cabang()
  {
    $this->datatables->select('id,nama,email,hp');
    $this->datatables->from('user');
    $this->datatables->unset_column('id');
    $this->datatables->add_column('action','$1',"aksi('id','staff','false','true','true')");
    $this->datatables->where('role','cabang');
    echo $this->datatables->generate();
    exit;
  }

  public function data_paket()
  {
    $this->datatables->select('id_paket,nama_paket,harga,harga_cabang,status');
    $this->datatables->from('paket_umroh');
    $this->datatables->unset_column('id_paket');
    $this->datatables->add_column('action','$1',"aksi('id_paket','paket','false','true','true')");
    $this->datatables->edit_column('harga','$1',"int_to_rupiah('harga')");
    $this->datatables->edit_column('harga_cabang','$1',"int_to_rupiah('harga_cabang')");
    $this->datatables->edit_column('status','$1',"status_paket('status')");
    echo $this->datatables->generate();
    exit;
  }

  public function data_transaksi()
  {
    $this->datatables->select('id_trx,trx_date,nama_lengkap,nama_paket,trx_umroh.harga,trx_umroh.status');
    $this->datatables->from('trx_umroh');
    $this->datatables->join('customer','trx_umroh.id_cust = customer.id_cust');
    $this->datatables->join('paket_umroh','trx_umroh.id_paket = paket_umroh.id_paket');
    //$this->datatables->join('user','trx_umroh.id_marketing = user.id');
    $this->datatables->unset_column('id_trx');
	$this->datatables->add_column('action','$1',"aksi('id_trx','transaksi','true','false','false')");
    $this->datatables->edit_column('status','$1',"status_trx('status')");
	$this->datatables->edit_column('harga','$1','int_to_rupiah("harga")');
    echo $this->datatables->generate();
    exit;
  }

  public function data_bonus_sponsor()
  {
    $this->datatables->select('id,kode_user,nama_lengkap,komisi');
    $this->datatables->from('user');
    $this->datatables->join('customer','user.id = customer.user_id');
    $this->datatables->where('komisi >','10000');
    $this->datatables->unset_column('id');
    $this->datatables->edit_column('komisi','$1','int_to_rupiah("komisi")');
    echo $this->datatables->generate();
    exit;
  }

  public function data_bonus_sales()
  {
    $this->datatables->select('id,kode_user,nama_lengkap,poin_sponsor');
    $this->datatables->from('user');
    $this->datatables->join('customer','user.id = customer.user_id');
    $this->datatables->where('poin_sponsor >','0');
    $this->datatables->unset_column('id');
    echo $this->datatables->generate();
    exit;
  }

  public function data_bonus_pelunasan()
  {
    $this->datatables->select('id,kode_user,nama_lengkap,poin_pelunasan');
    $this->datatables->from('user');
    $this->datatables->join('customer','user.id = customer.user_id');
    $this->datatables->where('poin_pelunasan >','0');
    $this->datatables->unset_column('id');
    echo $this->datatables->generate();
    exit;
  }

  public function data_setting()
  {
    $this->datatables->select('setting_id,setting_group,setting_name,setting_value');
    $this->datatables->from('setting');
    $this->datatables->unset_column('setting_id');
    $this->datatables->add_column('action','$1',"aksi('setting_id','setting','false','true','true')");
    echo $this->datatables->generate();
    exit;
  }


}

/* End of file load.php */
/* Location: ./application/controller/load.php */
