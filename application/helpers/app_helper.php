<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('static_file')) {

    function static_file() {
        $CI = & get_instance();

        return $CI->config->item('static_file');
    }

}

if (!function_exists('to_mysql_date')) {

    function to_mysql_date($tanggal) {
        return date_format(date_create($tanggal),'Y-m-d');
    }

}

if (!function_exists('to_human_date')) {

    function to_human_date($tanggal) {
        return date_format(date_create($tanggal),'m/d/Y');
    }

}

if (!function_exists('c_link')) {

    function c_link($nama, $id, $link) {
        return "<a href='".base_url().$link."/view/".$id."'>$nama</a>";
    }

}

if (!function_exists('int_to_rupiah')) {

    function int_to_rupiah($nilai) {
        return "Rp. ".number_format($nilai,0,',','.');
    }

}

if(!function_exists('rupiah_to_int'))
{
  function rupiah_to_int($number)
    {
        $int = $number;
        if($number != ""){
          $data = explode(',',$number);
          $int  = str_replace('.','',$data[0]);
        }

        return $int;
    }
}

if (!function_exists('status_paket')) {

    function status_paket($status) {
      if($status){
        $label = '<span class="label label-success">Aktif</span>';
      }else{
        $label = '<span class="label label-danger">Tidak Aktif</span>';
      }
        return $label;
    }

}

if (!function_exists('status_trx')) {

    function status_trx($status) {
      if($status=="daftar"){
        $label = '<span class="label label-info">'.$status.'</span>';
	  }elseif($status=="batal"){
        $label = '<span class="label label-danger">'.$status.'</span>';
      }else{
        $label = '<span class="label label-success">'.$status.'</span>';
      }
        return $label;
    }

}

if (!function_exists('status_user')) {

    function status_user($status) {
      if($status=="pending"){
        $label = '<span class="label label-danger">'.$status.'</span>';
    }elseif($status=="aktif"){
        $label = '<span class="label label-success">'.$status.'</span>';
      }else{
        $label = '<span class="label label-warning">'.$status.'</span>';
      }
        return $label;
    }

}

if (!function_exists('aksi')) {
    function aksi($id, $link, $view = "false", $edit = "false", $hapus="false") {

	  $format = "";

  if($view=="true"):
	  $format .= "".
          "<a title='Lihat' class='btn btn-white btn-sm' href='".base_url().$link."/view/".$id."'>
              <i class='material-icons'>assignment</i>
          </a>";
	endif;

	if($edit=="true"):
      $format .= "".
          "<a title='Edit' class='btn btn-white btn-sm' href='".base_url().$link."/edit/".$id."'>
              <i class='material-icons'>assignment_turned_in</i>
          </a>";
	endif;

	if($hapus=="true"):
      $format .= "".
          "<a title='Hapus' class='btn btn-white btn-sm' href='#' onclick='delConf(\"".base_url().$link."/delete/".$id."\")'>
              <i class='material-icons'>delete</i>
          </a>";
	endif;

      return "<center>".$format."</center>";

    }
}

if (!function_exists('aktifasi_marketing')) {
  function aktifasi_marketing($id,$id_trx,$link,$status){
    if($status == 'aktif'){
      $format = "<a title='Lihat' class='btn btn-white btn-sm' href='".base_url().$link."/view/".$id."'>
                  <i class='material-icons'>assignment</i>
                </a>";
    }else{
      $format = "<a title='Aktifasi' class='btn btn-white btn-sm' onclick='show_modal_pembayaran(\"".$id_trx."\",1)'>
                  <i class='material-icons'>lock_open</i>
                </a>";
    }
    return "<center>".$format."</center>";
  }
}

if (!function_exists('aksi_jamaah')) {
  function aksi_jamaah($id,$id_trx,$link,$status){
    $format = "";

    if($status=="daftar"):
      $format = "<a title='Aktifasi' class='btn btn-white btn-sm' onclick='show_modal_pembayaran(".$id_trx.",1)'>
                  <i class='material-icons'>payment</i>
                </a>";
    endif;

    $format .= "".
          "<a title='Edit' class='btn btn-white btn-sm' href='".base_url().$link."/edit/".$id."'>
              <i class='material-icons'>assignment_turned_in</i>
          </a>";
    $format .= "".
        "<a title='Hapus' class='btn btn-white btn-sm' href='#' onclick='delConf(\"".base_url().$link."/delete/".$id."\")'>
            <i class='material-icons'>delete</i>
        </a>";
    return "<center>".$format."</center>";
  }
}

if (!function_exists('bonus_sponsor')) {
  function bonus_sponsor($id_trx){
    $ci = & get_instance();
    $BonusReferal = 700000;
    $BonusPresenter = 300000;

    $dataTrx = $ci->Mgeneral->getWhere(array('id_trx'=>$id_trx),'trx_umroh');
    #print_r($dataTrx);
    if(isset($dataTrx)):
      $namaCust= $ci->Mgeneral->getValue("nama_lengkap",array('id_cust'=>$dataTrx[0]->id_cust),'customer');
      $jaringanUser = $ci->Mgeneral->getWhere(array('id'=>$dataTrx[0]->id_marketing),'daftar_jaringan');
      #print_r($jaringanUser);

      #implementasi Bonus Referal
      if($dataTrx[0]->id_marketing != "" && $dataTrx[0]->id_marketing != "0"):
        $ket = "Bonus Sponsor dari transaksi jamaah ".$namaCust." sebesar ".$BonusReferal.". #".$id_trx;
        pay_bonus($dataTrx[0]->id_marketing,$id_trx,$BonusReferal,$ket,"komisi","Sponsor");
      else:
        $ket = "Bonus Sponsor Perusahaan dari transaksi jamaah ".$namaCust." sebesar ".$BonusReferal.". #".$id_trx;
        pay_bonus('1',$id_trx,$BonusReferal,$ket,"komisi","Sponsor");
      endif;
      #echo $ket."<br>";

      #implementasi Bonus Presenter
      if($dataTrx[0]->id_presenter != "" && $dataTrx[0]->id_presenter != "0"):
        $ket = "Bonus Closing dari transaksi jamaah ".$namaCust." sebesar ".$BonusPresenter.". #".$id_trx;
        pay_bonus($dataTrx[0]->id_presenter,$id_trx,$BonusPresenter,$ket,"komisi","closing");
      else:
        $ket = "Bonus Closing Perusahaan dari transaksi jamaah ".$namaCust." sebesar ".$BonusPresenter.". #".$id_trx;
        pay_bonus('1',$id_trx,$BonusPresenter,$ket,"komisi","closing");
      endif;
      #echo $ket."<br>";

      #implementasi Bonus Jaringan
      for($n=1;$n<=10;$n++):
        $arr = "level".$n;
        if(isset($jaringanUser[0])):
          if($jaringanUser[0]->$arr!="" && $jaringanUser[0]->$arr!="0"):
            $ket = "Sales Poin dari transaksi jamaah ".$namaCust.". #".$id_trx;
            pay_bonus($jaringanUser[0]->$arr,$id_trx,"1",$ket,"jaringan",'Group '.$n);
          else:
            $ket = "Sales Poin Perusahaan dari transaksi jamaah ".$namaCust.". #".$id_trx;
            pay_bonus("1",$id_trx,"1",$ket,"jaringan",'Group '.$n);
          endif;
        else:
            $ket = "Sales Poin Perusahaan dari transaksi jamaah ".$namaCust.". #".$id_trx;
            pay_bonus("1",$id_trx,"1",$ket,"jaringan",'Group '.$n);
        endif;
        #echo $ket."<br>";
      endfor;

    endif;

  }
}

if (!function_exists('pay_bonus')) {
  function pay_bonus($id_user,$id_trx,$nilai,$ket,$jenis,$tipeBonus){
    $ci = & get_instance();

    switch($jenis):
      case "komisi":    $tipe = "komisi"; break;
      case "jaringan":  $tipe = "poin_sponsor"; break;
      case "pelunasan": $tipe = "poin_pelunasan"; break;
    endswitch;

    #cek apakah sudah di distribusikan bonus nya
    $cekBonus = $ci->Mgeneral->getWhere(array('id_trx'=>$id_trx,'tipe'=>strtolower($tipeBonus)),'bonus_history');
    if(count($cekBonus)==0):
      #cek last nilai
      $cekNilai = $ci->Mgeneral->getValue($tipe,array('user_id'=>$id_user),"customer");
      $lastNilai = $cekNilai+$nilai;

      #simpan ke history distribusi bonus
      $varHistory = array('user_id'     => $id_user,
                          'id_trx'      => $id_trx,
                          'nilai'       => $nilai,
                          'nilai_akhir' => $lastNilai,
                          'jenis'       => $jenis,
                          'tipe'        => strtolower($tipeBonus),
                          'keterangan'  => $ket);
      $ci->Mgeneral->save($varHistory,"bonus_history");

      #masukan bonus ke user
      $sql = "UPDATE customer SET $tipe = $tipe+".$nilai." WHERE user_id = '".$id_user."'";
      $ci->db->query($sql);

      if($jenis == "jaringan"):
        $level = str_replace("Group ", "", $tipeBonus);
        $field = "poin_group".$level;

        #masukan bonus ke user
        $sql = "UPDATE bonus_breakdown SET $field = $field+".$nilai." WHERE user_id = '".$id_user."'";
        $ci->db->query($sql);
      endif;

    endif;

  }
}
