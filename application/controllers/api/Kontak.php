<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Kontak extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('kontak_model'));
    }

    public function index_get()
    {
        $id = $this->get('id');

        if($id === null)
        {
            $kontak = $this->kontak_model->getKontak(); 
        }else{
            $kontak = $this->kontak_model->getKontak($id); 
        }

        if($kontak)
        {
            $this->response([
                'status'    => TRUE,
                'data'      => $kontak
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status'    => FALSE,
                'message'   => 'kontak not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        $data = [
            'nama'  => $this->post('nama'),
            'nomor' => $this->post('nomor')
        ];

        if($this->kontak_model->createKontak($data) > 0)
        {
            $this->response([
                'status'    => TRUE,
                'message'   => 'kontak has success created'
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status'    => FALSE,
                'message'   => 'kontak has failed created'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'nama'  => $this->put('nama'),
            'nomor' => $this->put('nomor')
        ];

        if($this->kontak_model->updateKontak($data, $id) > 0)
        {
            $this->response([
                'status'    => TRUE,
                'message'   => 'kontak has success updated'
            ], REST_Controller::HTTP_NO_CONTENT);
        }else{
            $this->response([
                'status'    => FALSE,
                'message'   => 'kontak has failed updated'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if($id === null)
        {
            $this->response([
                'status'    => FALSE,
                'message'   => 'provide in id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else{
            if($this->kontak_model->deleteKontak($id) > 0)
            {
                $this->response([
                    'status'    => TRUE,
                    'id'        => $id,
                    'message'   => 'id success deleted'
                ], REST_Controller::HTTP_NO_CONTENT);
            }else{
                $this->response([
                    'status'    => FALSE,
                    'message'   => 'kontak not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
