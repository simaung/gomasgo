<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#akses ke semua tabel di database
class Mgeneral extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	#querry semua data dalam tabel
	#ex akses : $this->mgeneral->getAll('nama_tabel');
	function getAll($tabel,$order_field="",$order_tipe="",$limit="",$limitend="")
	{
		if($order_field!="" && $order_tipe!=""){ $this->db->order_by($order_field,$order_tipe); }
		if($limit!="" && $limitend==""){ $this->db->limit($limit,0); }
		if($limit!="" && $limitend!=""){ $this->db->limit($limitend,$limit-1); }
		return $this->db->get($tabel)->result();
	}

	#fungsi untuk melakukan query standar
	#ex akses : $this->mgeneral->getWhere(array('field1'=>'data','field2'=>'data'),'nama_tabel');
	function getWhere($where,$tabel,$order_field="",$order_tipe="",$limit="",$limitend="")
	{
		$this->db->where($where);
		if($order_field!="" && $order_tipe!=""){ $this->db->order_by($order_field,$order_tipe); }
		if($limit!="" && $limitend==""){ $this->db->limit($limit,0); }
		if($limit!="" && $limitend!=""){ $this->db->limit($limitend,$limit-1); }
		return $this->db->get($tabel)->result();
	}

	#fungsi untuk melakukan query standar menggunakan like
	#ex akses : $this->mgeneral->getLike(array('field1'=>'data','field2'=>'data'),'nama_tabel');
	function getLike($where,$tabel,$limit,$limitend)
	{
		$this->db->like($where);
		if($limit!="" && $limitend==""){ $this->db->limit($limit,0); }
		if($limit!="" && $limitend!=""){ $this->db->limit($limitend,$limit-1); }
		return $this->db->get($tabel)->result();
	}

	#fungsi join 2 tabel
	function getJoin($db1,$db2,$join_field,$join_tipe,$where,$order_field="",$order_tipe="",$limit,$limitend)
	{
		$this->db->select("*");
		$this->db->from($db1);
    $this->db->join($db2, $join_field, $join_tipe);
    if(count($where)>0){ $this->db->where($where); }
    if($order_field!="" && $order_tipe!=""){ $this->db->order_by($order_field,$order_tipe); }
		if($limit!="" && $limitend==""){ $this->db->limit($limit,0); }
		if($limit!="" && $limitend!=""){ $this->db->limit($limitend,$limit-1); }
    return $this->db->get()->result();
	}

	#fungsi save data
	#ex akses : $this->mgeneral->save(array_data_insert,nama_tabel);
	function save($varData,$tabel){
	  $this->db->insert($tabel, $varData);
	  return $this->db->insert_id();
	}

	#fungsi update data
	#ex akses : $this->mgeneral->update(array('field1'=>'data','field2'=>'data'),array_data_udate,nama_tabel);
	function update($where, $data, $tabel){
	  $this->db->where($where);
	  return $this->db->update($tabel, $data);
	}

	#fungsi hapus data
	#ex akses : $this->mgeneral->delete(array('field1'=>'data','field2'=>'data'),nama_tabel);
	function delete($where,$tabel){
		$this->db->where($where);
		$this->db->delete($tabel);
	}

	#fungsi untuk mendapatkan nilai dari sebuah field
	#ex akses : $this->mgeneral->getValue(field1,array('field2'=>'data'),'nama_tabel');
	function getValue($field,$where,$tabel)
	{
		$this->db->select($field);
		$this->db->where($where);
		$result	= $this->db->get($tabel)->result();

			foreach($result as $r)
			{
				$value	= $r->$field;
			}
		return $value;
	}

	#fungsi untuk melihat uniqe value dari sebuah field
	function distinct($tabel,$field,$asField)
	{
		$q = $this->db->query("SELECT DISTINCT($field) $asField FROM $tabel");
		return $q->result();
	}

	function post_query_sql($query) {
    $query = $this->db->query($query);
    return $query->result();
  }

  function getDetailId($id,$primary_key_field,$table)
  {
    $this->db->where($primary_key_field,$id);
    return $this->db->get($table)->row();
  }
}
