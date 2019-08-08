<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
		if (!$_SESSION['is_login']):
			redirect('auth');
		endif;
  }

  public function index()
  {
    $setting['sidebar']=array('setting'=>"active");
		$setting['js_file']=array('assets/vendor/jquery.dataTables.min.js','assets/vendor/datatables-bootstrap3.min.js','assets/js/datatables.js');

		$this->template->print_layout('setting/data',$setting);
  }

  public function edit($setting_id)
  {
    $setting['sidebar']=array('setting'=>"active");
    $setting['js_file']=array('script/setting.js');
    $setting['setting'] = $this->Mgeneral->getDetailId($setting_id,'setting_id','setting');
    $this->template->print_layout('setting/edit',$setting);
  }

  public function update($setting_id)
  {
    $data['setting_group'] = $this->input->post('group');
    $data['setting_name']  = $this->input->post('nama');
    $data['setting_value'] = $this->input->post('nilai');

    $this->Mgeneral->update(array('setting_id'=>$setting_id),$data,'setting');
    $this->session->set_flashdata('success','Data Telah Di Update');
    redirect('setting/edit/'.$setting_id);
  }

  public function delete($setting_id)
  {
    $this->Mgeneral->delete(array('setting_id'=>$setting_id),'setting');
    echo json_encode(['status'=>1,'msg'=>'Data Berhasil Dihapus']);
  }

}
