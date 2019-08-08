<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muser extends CI_Model
{
  private $table = "user";

  function __construct()
	{
		parent::__construct();
	}

  public function generate_member_id()
  {
    $code = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 6));
    #check
    $this->db->where('kode_user',$code);
    $check = $this->db->get($this->table)->result();

    if(count($check) > 0){
      $this->generate_member_id();
    }else{
      return $code;
    }
  }

  public function check_user($credential)
  {
    # check user by kode user
    $this->db->where('kode_user',$credential);
    $check = $this->db->get($this->table)->row();

    if($check != ""){
      return $check->id;
    }else{
      # check user by email
      $this->db->where('email',$credential);
      $check = $this->db->get($this->table)->row();

      if($check != ""){
        return $check->id;
      }else{
        return 0;
      }
    }
  }

  public function login($id_user, $password)
  {
    $this->db->where('id',$id_user);
    $this->db->where('password',md5($password));
    return $this->db->get($this->table)->row_array();
  }

  public function check_email($email,$exclude_id = 0)
  {
    $this->db->where('email',$email);
    if($exclude_id > 0){
      $this->db->where('id','!=',$exclude_id);
    }
    $result = $this->db->get($this->table)->result();

    if(count($result) > 0){
      return true;
    }else{
      return false;
    }
  }

  public function get_user_by_kode($kode_user)
  {
    $this->db->where('kode_user',$kode_user);
    return $this->db->get($this->table)->row();
  }

  public function get_profile($user_id)
  {
    $this->db->select('*');
    $this->db->from($this->table);
    $this->db->join('customer','user.id = customer.user_id','left');
    $this->db->where('user.id',$user_id);
    return $this->db->get()->row();
  }

}
