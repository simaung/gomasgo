<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';

use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Jamaah extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mjamaah');
        $this->data_token = verify_request();
    }

    public function index_get()
    {
        $id         = $this->get('id');
        $sort_by    = $this->get('sort_by');
        $limit      = $this->get('per_page');
        $offset     = $limit * ($this->get('page') - 1);
              
        if($limit)
            $this->Mjamaah->set_limit($limit);

        if($offset)
        $this->Mjamaah->set_offset($offset);

        if($id === null)
        {
            $jamaah = $this->Mjamaah->getJamaah();
        }else{
            $jamaah = $this->Mjamaah->getJamaah($id);
            if($jamaah['id_cust'])
            {
                $jamaah[0]['foto_ktp']      = ($jamaah[0]['foto_ktp'] != null)?base_url().'static/uploads/'.$jamaah[0]['foto_ktp']:null;
                $jamaah[0]['foto_kk']       = ($jamaah[0]['foto_kk'] != null)?base_url().'static/uploads/'.$jamaah[0]['foto_kk']:null;
                $jamaah[0]['foto_paspor']   = ($jamaah[0]['foto_paspor'] != null)?base_url().'static/uploads/'.$jamaah[0]['foto_paspor']:null;
                $jamaah[0]['transaksi']     = $this->Mjamaah->getTrxJamaah($id);
            }
        }

        if($jamaah)
        {
            $status = parent::HTTP_OK;
            $this->response(['status' => $status,'data' => $jamaah], $status);
        }else{
            $this->response(['message' => 'Jamaah not found'], parent::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        $this->load->model('Muser');
        $data_user_login = data_user_login();

        $customer = [
            'nama_lengkap'  => $this->post('nama'),
            'email'         => $this->post('email'),
            'hp'            => $this->post('hp'),
            'id_card'       => $this->post('id_card'),
            'alamat'        => $this->post('alamat'),
            'id_kota'       => $this->post('kota'),
            'id_provinsi'   => $this->post('provinsi'),
            'kode_pos'      => $this->post('kode_pos'),
            'cust_type'     => 'jamaah',
            'tgl_lahir'     => to_mysql_date($this->post('tgl_lahir'))
        ];

        if($this->post('presenter') != ""){
            $check_presenter = $this->Muser->get_user_by_kode($this->post('presenter'));
            if($check_presenter){
                $idPresenter = $check_presenter->id;
            }else{
                $this->response([
                    'status'    => FALSE,
                    'message'   => 'Kode Presenter tidak valid'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }

            if($data_user_login->role == 'user'){
                if ($check_presenter->id == $data_user_login->id) {
                    $this->response([
                        'status'    => FALSE,
                        'message'   => 'Kode Presenter tidak boleh sama dengan referal'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        }else{
            $idPresenter = "";
        }
        
        $customer_id    = $this->Mgeneral->save($customer,'customer');
        $idpaket        = $this->post('paket');
        $harga          = $this->Mgeneral->getValue('harga',array('id_paket'=>$idpaket),'paket_umroh');
        
        if($harga)
        {
            $dataTrx = array(
                'id_cust'       => $customer_id,
                'id_marketing'  => $data_user_login->id,
                'id_presenter'  => $idPresenter,
                'id_paket'      => $idpaket,
                'harga'         => $harga,
                'status'        => 'daftar',
            );
            
            $this->Mgeneral->save($dataTrx,'trx_umroh');
        }

        if($customer_id)
        {
            $this->response([
                'status'    => TRUE,
                'message'   => 'Data Jamaah Berhasil Disimpan'
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status'    => FALSE,
                'message'   => 'Data Jamaah Gagal Disimpan'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');

        $customer = [
            'nama_lengkap'  => $this->put('nama'),
            'email'         => $this->put('email'),
            'hp'            => $this->put('hp'),
            'id_card'       => $this->put('id_card'),
            'alamat'        => $this->put('alamat'),
            'id_kota'       => $this->put('kota'),
            'id_provinsi'   => $this->put('provinsi'),
            'kode_pos'      => $this->put('kode_pos'),
            'tgl_lahir'     => to_mysql_date($this->put('tgl_lahir'))
        ];
        
        $customer_id = $this->Mgeneral->update(array('id_cust'=>$id),$customer,'customer');
        if($customer_id)
        {
            $this->response([
                'status'    => TRUE,
                'message'   => 'Data Jamaah Berhasil Disimpan'
            ], REST_Controller::HTTP_NO_CONTENT);
        }else{
            $this->response([
                'status'    => FALSE,
                'message'   => 'Data Jamaah Gagal Disimpan'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        
        $customer = $this->Mgeneral->getWhere(array('id_cust'=>$id,'cust_type'=>'jamaah'),'customer');

        if(!empty($customer)){
            $customer_id = $customer[0]->id_cust;
            $this->Mgeneral->delete(array('id_cust'=>$customer_id),'customer');
            $this->response([
                'status'    => TRUE,
                'id'        => $id,
                'message'   => 'Data Jamaah Berhasil Dihapus'
            ], REST_Controller::HTTP_NO_CONTENT);
        }else{
            $this->response([
                'status'    => FALSE,
                'message'   => 'Data Jamaah Gagal Dihapus'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function upload_post()
    {
        $customer_id = $this->post('id');
        
        $config['upload_path']      = './static/uploads/';
        $config['allowed_types']    = 'jpg|png|gif';
        $config['overwrite']        = true;
        $config['max_size']         = 1024; // 1MB

        $this->load->library('upload');

        # upload foto kk
  		if(!empty($_FILES["foto_kk"]["tmp_name"])){
            $path_parts = pathinfo($_FILES["foto_kk"]["name"]);
            $extension = $path_parts['extension'];
            $config['file_name'] = "Kartu_Keluarga_".$customer_id;
            $this->upload->initialize($config);
            $this->upload->do_upload('foto_kk');
            $this->Mgeneral->update(array('id_cust'=>$customer_id),array('foto_kk'=>$config['file_name'].".".$extension),'customer');
        }

        # upload foto ktp
        if(!empty($_FILES["foto_ktp"]["tmp_name"])){
            $path_parts = pathinfo($_FILES["foto_ktp"]["name"]);
            $extension = $path_parts['extension'];
            $config['file_name'] = "KTP_".$customer_id;
            $this->upload->initialize($config);
            $this->upload->do_upload('foto_ktp');
            $this->Mgeneral->update(array('id_cust'=>$customer_id),array('foto_ktp'=>$config['file_name'].".".$extension),'customer');
        }

        # upload foto paspor
        if(!empty($_FILES["foto_paspor"]["tmp_name"])){
            $path_parts = pathinfo($_FILES["foto_paspor"]["name"]);
            $extension = $path_parts['extension'];
            $config['file_name'] = "PASPOR_".$customer_id;
            $this->upload->initialize($config);
            $this->upload->do_upload('foto_paspor');
            $this->Mgeneral->update(array('id_cust'=>$customer_id),array('foto_paspor'=>$config['file_name'].".".$extension),'customer');
        }

        $this->response([
            'status'    => TRUE,
            'message'   => 'Foto persyaratan berhasil di simpan'
        ], REST_Controller::HTTP_CREATED);

    }
}