<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mmarketing extends CI_Model
{
  private $table = "user";

  function __construct()
	{
		parent::__construct();
    }

    public function getMarketing($id_marketing=null)
    {
        $data_user_login = data_user_login();

        if($id_marketing === null){
            $this->db->select('a.id,t.id_trx,a.reg_date,a.kode_user,a.nama,a.email,a.hp,b.total_agent,a.status');
            $this->db->join('customer c', 'a.id = c.user_id');
            $this->db->join('trx_umroh t', 'c.id_cust = t.id_cust', 'left');
            $this->db->join('referal_agent b', 'a.id = b.id', 'left');
            $this->db->where('role','user');
            if($data_user_login->role == 'user'){
                $this->db->where('referal',$data_user_login->kode_user);
            }
            return $this->db->get('user a')->result_array();
        }else{
            $sql="select * from user a LEFT JOIN customer b ON a.id = b.user_id where a.id ='".$id_marketing."'";
           return $this->Mgeneral->post_query_sql($sql);
        }
    }

    public function listMarketing($kode_user)
    {
        $this->db->select('a.reg_date,a.kode_user,a.nama,b.total_agent');
        $this->db->join('referal_agent b', 'a.id = b.id', 'left');
        $this->db->where('role','user');
        $this->db->where('referal',$kode_user);
        return $this->db->get('user a')->result_array();
    }

    function listJamaah($id)
    {
        $this->db->select('b.trx_date,a.nama_lengkap,c.nama_paket,b.status');
        $this->db->join('trx_umroh b', 'a.id_cust = b.id_cust', 'left');
        $this->db->join('paket_umroh c', 'b.id_paket = c.id_paket', 'left');
        $this->db->where('cust_type','jamaah');
        $this->db->where('b.id_marketing',$id);
        return $this->db->get('customer a')->result_array();
    }
    
}