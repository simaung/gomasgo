<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MJamaah extends Base_Model
{

  function __construct()
	{
        parent::__construct();
        $this->set_table('user');
    }

    public function getJamaah($id_jamaah = null)
    {
        if($id_jamaah === null){
            $data_user_login = data_user_login();

            $this->db->select('a.id_cust,b.id_trx,a.nama_lengkap,a.hp,b.trx_date,c.nama_paket,b.status');
            $this->db->join('trx_umroh b', 'a.id_cust = b.id_cust', 'left');
            $this->db->join('paket_umroh c', 'b.id_paket = c.id_paket', 'left');
            if($data_user_login->role =="user"){
                $this->db->where('b.id_marketing',$data_user_login->id );
            }
            if($this->limit || $this->offset)
            {
                return $this->db->get('customer a', $this->limit, $this->offset)->result_array();
            }else{
                return $this->db->get('customer a')->result_array();
            }
        }else{
            $this->db->select('a.*, b.name as nama_kota, c.name as nama_provinsi');
            $this->db->where('a.id_cust',$id_jamaah);
            $this->db->join('kota b', 'a.id_kota = b.id', 'left');
            $this->db->join('provinsi c', 'a.id_provinsi = c.id', 'left');
            return $this->db->get('customer a')->result_array();
        }
    }

    public function getTrxJamaah($id_jamaah = null)
    {
        $this->db->select('a.id_trx,a.trx_date,b.nama_lengkap,c.nama_paket,a.harga,(select sum(nominal) as dibayar from pembayaran_trx d where a.id_trx = d.id_trx) as total,a.status');
		$this->db->join('customer b', 'a.id_cust = b.id_cust', 'left');
		$this->db->join('paket_umroh c', 'a.id_paket = c.id_paket', 'left');
		$this->db->where('id_marketing',$id_jamaah);
        return $this->db->get('trx_umroh a')->result_array();
    }
}