<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';

use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Paket extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mpaket');
    }

    public function index_get()
    {
        $id = $this->get('id');
              
        if($id <> null)
            $where['id_paket'] = $id;
            
        $this->Mpaket->set_where($where);
        $paket = $this->Mpaket->getPaket();
        
        if($paket)
        {
            $status = parent::HTTP_OK;
            $this->response(['status' => $status,'data' => $paket], $status);
        }else{
            $this->response(['message' => 'Paket not found'], parent::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        $this->data_token = verify_request();

        $paket = [
            'nama_paket'    => $this->post('nama'),
            'harga'         => rupiah_to_int($this->post('harga')),
            'harga_cabang'  => rupiah_to_int($this->post('harga_cabang')),
            'status'        => $this->post('status')
        ];

        $paket_id = $this->Mgeneral->save($paket,'paket_umroh');
        if($paket_id)
        {
            $this->response([
                'status'    => TRUE,
                'message'   => 'Paket Umroh Berhasil Disimpan'
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status'    => False,
                'message'   => 'Paket Umroh Gagal Disimpan'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $this->data_token = verify_request();

        $id_paket = $this->put('id');

        $paket = [
            'nama_paket'    => $this->put('nama'),
            'harga'         => rupiah_to_int($this->put('harga')),
            'harga_cabang'  => rupiah_to_int($this->put('harga_cabang')),
            'status'        => $this->put('status')
        ];

        $paket_id = $this->Mgeneral->update(array('id_paket'=>$id_paket),$paket,'paket_umroh');
        if($paket_id)
        {
            $this->response([
                'status'    => TRUE,
                'message'   => 'Paket Umroh Berhasil Disimpan'
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status'    => False,
                'message'   => 'Paket Umroh Gagal Disimpan'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $this->data_token = verify_request();
        
        $id_paket = $this->delete('id');
        
        $paket = $this->Mgeneral->getWhere(array('id_paket'=>$id_paket),'paket_umroh');

        if(!empty($paket)){
            $id_paket = $paket[0]->id_paket;
            $this->Mgeneral->delete(array('id_paket'=>$id_paket),'paket_umroh');
            $this->response([
                'status'    => TRUE,
                'id'        => $id_paket,
                'message'   => 'Data Paket Berhasil Dihapus'
            ], REST_Controller::HTTP_NO_CONTENT);
        }else{
            $this->response([
                'status'    => FALSE,
                'message'   => 'Data Paket Gagal Dihapus'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}