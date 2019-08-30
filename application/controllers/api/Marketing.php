<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';

use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Marketing extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mmarketing');
        $this->data_token = verify_request();
    }

    public function index_get()
    {
        $id = $this->get('id');
        if($id === null)
        {
            $marketing = $this->Mmarketing->getMarketing();
        }else{
            $marketing = $this->Mmarketing->getMarketing($id);
            if($marketing)
            {
                $marketing[0]->foto         = ($marketing[0]->foto != null)?base_url().'static/uploads/'.$marketing[0]->foto:null;
                $marketing[0]->foto_ktp     = ($marketing[0]->foto_ktp != null)?base_url().'static/uploads/'.$marketing[0]->foto_ktp:null;
                $marketing[0]->foto_paspor  = ($marketing[0]->foto_paspor != null)?base_url().'static/uploads/'.$marketing[0]->foto_paspor:null;
                $marketing[0]->foto_kk      = ($marketing[0]->foto_kk != null)?base_url().'static/uploads/'.$marketing[0]->foto_kk:null;
    
                $marketing[0]->list_marketing = $this->Mmarketing->listMarketing($marketing[0]->kode_user);
                $marketing[0]->list_jamaah = $this->Mmarketing->listJamaah($id);
            }
        }

        if($marketing)
        {
            $this->response(['status' => parent::HTTP_OK,'data' => $marketing], parent::HTTP_OK);
        }else{
            $this->response(['message' => 'marketing not found'], parent::HTTP_NOT_FOUND);
        }
    }
}