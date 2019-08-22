<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';

use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Lokasi extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mlokasi');
    }

    public function provinsi_get()
    {
        $id = $this->get('id');
              
        if($id <> null)
            $where['a.id'] = $id;
            
        $this->db->order_by('name', 'asc');
        $provinsi = $this->Mlokasi->getProvinsi();
        
        if($provinsi)
        {
            $status = parent::HTTP_OK;
            $this->response(['status' => $status,'data' => $provinsi], $status);
        }else{
            $this->response(['message' => 'Provinsi not found'], parent::HTTP_NOT_FOUND);
        }
    }

    public function kota_get()
    {
        $id = $this->get('id');
        $province_id = $this->get('province_id');
        if($id <> null)
            $where['a.id'] = $id;
        
        if ($province_id <> null)
            $where['a.province_id'] = $province_id;

		$this->Mlokasi->set_where($where);
              
        $this->db->order_by('name', 'asc');
        $kota = $this->Mlokasi->getKota();

        if($kota)
        {
            $status = parent::HTTP_OK;
            $this->response(['status' => $status,'data' => $kota], $status);
        }else{
            $this->response(['message' => 'Kota not found'], parent::HTTP_NOT_FOUND);
        }
    }
}