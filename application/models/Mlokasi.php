<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mlokasi extends Base_Model
{

  function __construct()
	{
        parent::__construct();
        $this->set_table('user');
    }

    public function getProvinsi()
    {
        $this->db->select('a.*');

        $this->db->where($this->where);
        
        $query = $this->db->get('provinsi a');
        
		if($query->num_rows()>0)
		{
			return $query->result_array();
        
		}else
		{
			$query->free_result();
            return $query;
        }
    }

    public function getKota()
    {
        $this->db->select('a.*, b.name as province');

        $this->db->where($this->where);
        $this->db->join('provinsi b', 'a.province_id = b.id');
        
        $query = $this->db->get('kota a');
        
		if($query->num_rows()>0)
		{
			return $query->result_array();
        
		}else
		{
			$query->free_result();
            return $query;
        }
    }
    
}