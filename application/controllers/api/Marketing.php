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

    public function index_get($id = null)
    {
        // print_r($this->data_token);die;
        // $id = $this->get('id');

        if($id === null)
        {
            $marketing = $this->Mmarketing->getMarketing(); 
        }else{
            $marketing = $this->Mmarketing->getMarketing($id); 
        }

        if($marketing)
        {
            $this->response([
                'status'    => TRUE,
                'data'      => $marketing
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status'    => FALSE,
                'message'   => 'marketing not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}