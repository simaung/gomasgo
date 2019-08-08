<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Template
 */
class Template
{
  private $ci;

  function __construct()
  {
    $this->ci =& get_instance();
  }

  public function print_layout($view_kontent = "", $param = [])
  {
    $data['content'] = $this->ci->load->view($view_kontent,$param,TRUE);
    $data['navbar']  = $this->ci->load->view('layout/navbar',$param,TRUE);
    $data['sidebar'] = $this->ci->load->view('layout/sidebar',$param,TRUE);
    $data['footer']  = $this->ci->load->view('layout/footer',$param,TRUE);
    $data['head']    = $this->ci->load->view('layout/head',$param,TRUE);
    $this->ci->load->view('layout/container',$data);
  }
}
