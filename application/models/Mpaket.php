<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpaket extends Base_Model
{

  function __construct()
	{
        parent::__construct();
        $this->set_table('paket_umroh');
    }

    public function getPaket()
    {
        $this->db->select('id_paket, nama_paket, harga, harga_cabang,(case when status = "1" then "aktif" else "tidak aktif" end) as status');
        $this->db->where($this->where);
        $query = $this->db->get($this->table);
        
		if($query->num_rows()>0)
		{
			return $query->result_array();
        
		}else
		{
			$query->free_result();
            return false;
        }
    }

    public function getTransaksi()
    {
        $this->db->select('id_trx,trx_date,nama_lengkap,nama_paket,trx_umroh.harga,trx_umroh.status');
        $this->db->select('d.nama as marketing,d.kode_user as kode_marketing');
        $this->db->select('e.nama as presenter,e.kode_user as kode_presenter');
        $this->db->join('customer','trx_umroh.id_cust = customer.id_cust');
        $this->db->join('paket_umroh','trx_umroh.id_paket = paket_umroh.id_paket');
        $this->db->join('user d','d.id = trx_umroh.id_marketing');
        $this->db->join('user e','e.id = trx_umroh.id_presenter');

        $this->db->where($this->where);
        
        $query = $this->db->get('trx_umroh');
        
		if($query->num_rows()>0)
		{
			return $query->result_array();
        
		}else
		{
			$query->free_result();
            return false;
        }
    }

    
}