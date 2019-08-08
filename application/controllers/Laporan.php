<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Load plugin PHPExcel nya
include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php';
include APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';

class Laporan extends CI_Controller {

	public $style_col = array(
		'font' => array('bold' => true), // Set font nya jadi bold
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);
	public $style_row = array(
		'alignment' => array(
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);

	function __construct()
	{
		parent::__construct();
		if (!$_SESSION['is_login']):
			redirect('auth');
		endif;
	}

	public function komisi()
	{
		$setting['sidebar']=array('laporan'=>"active");
		$setting['js_file']=array('assets/vendor/jquery.dataTables.min.js','assets/vendor/datatables-bootstrap3.min.js','assets/js/datatables.js','script/laporan.js');

		$this->template->print_layout('laporan/komisi',$setting);
	}

	public function sales()
	{
		$setting['sidebar']=array('laporan'=>"active");
		$setting['js_file']=array('assets/vendor/jquery.dataTables.min.js','assets/vendor/datatables-bootstrap3.min.js','assets/js/datatables.js');

		$this->template->print_layout('laporan/sales',$setting);
	}

	public function pelunasan()
	{
		$setting['sidebar']=array('laporan'=>"active");
		$setting['js_file']=array('assets/vendor/jquery.dataTables.min.js','assets/vendor/datatables-bootstrap3.min.js','assets/js/datatables.js');

		$this->template->print_layout('laporan/pelunasan',$setting);
	}

	public function export_closing()
	{
		$excel = new PHPExcel();
    // Settingan awal fil excel
    $excel->getProperties()->setCreator('GOMASGO')
                 ->setTitle("Data Laporan Bonus Closing")
                 ->setDescription("Laporan Bonus Sponsor/Closing");

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "KODE USER");
    $excel->setActiveSheetIndex(0)->setCellValue('B1', "NAMA LENGKAP");
    $excel->setActiveSheetIndex(0)->setCellValue('C1', "HP");
		$excel->setActiveSheetIndex(0)->setCellValue('D1', "EMAIL");
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "ALAMAT");
		$excel->setActiveSheetIndex(0)->setCellValue('F1', "NAMA REKENING");
		$excel->setActiveSheetIndex(0)->setCellValue('G1', "NO REKENING");
		$excel->setActiveSheetIndex(0)->setCellValue('H1', "BANK");
		$excel->setActiveSheetIndex(0)->setCellValue('I1', "KOMISI");

		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('C1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('D1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('E1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('F1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('G1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('H1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('I1')->applyFromArray($this->style_row);

		$sql = "select kode_user, nama_lengkap, customer.email, customer.hp, alamat, nama_pemilik, no_rekening, nama_bank, komisi from user join customer on user.id = customer.user_id left join cust_bank on cust_bank.id_cust = customer.id_cust where komisi > 1000";
		$bonus = $this->Mgeneral->post_query_sql($sql);
		$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 2
    foreach($bonus as $data){ // Lakukan looping pada variabel siswa
      $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data->kode_user);
      $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nama_lengkap);
      $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->hp);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->email);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->alamat);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->nama_pemilik);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->no_rekening);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data->nama_bank);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data->komisi);

      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
      $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
      $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
      $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
      $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($this->style_row);

      $numrow++; // Tambah 1 setiap kali looping
    }

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    // Set judul file excel nya
    $excel->getActiveSheet(0)->setTitle("Laporan Bonus Closing");
    $excel->setActiveSheetIndex(0);
    // Proses file excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Laporan Bonus Closing.xls"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');
    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $write->save('php://output');
	}

	public function export_poin()
	{
		$excel = new PHPExcel();
    // Settingan awal fil excel
    $excel->getProperties()->setCreator('GOMASGO')
                 ->setTitle("Data Laporan Bonus Sales Poin")
                 ->setDescription("Laporan Bonus Sales Poin");

	  $excel->setActiveSheetIndex(0)->setCellValue('A1', "KODE USER");
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "NAMA LENGKAP");
		$excel->setActiveSheetIndex(0)->setCellValue('C1', "HP");
		$excel->setActiveSheetIndex(0)->setCellValue('D1', "EMAIL");
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "ALAMAT");
		$excel->setActiveSheetIndex(0)->setCellValue('F1', "POIN");

		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('C1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('D1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('E1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('F1')->applyFromArray($this->style_row);

		$sql = "select kode_user, nama_lengkap, customer.email, customer.hp, alamat, poin_sponsor from user join customer on user.id = customer.user_id where poin_sponsor > 0";
		$poin = $this->Mgeneral->post_query_sql($sql);

		$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 2
    foreach($poin as $data){ // Lakukan looping pada variabel siswa
      $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data->kode_user);
      $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nama_lengkap);
      $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->hp);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->email);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->alamat);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->poin_sponsor);

      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
      $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
      $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
      $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
      $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);

      $numrow++; // Tambah 1 setiap kali looping
    }

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    // Set judul file excel nya
    $excel->getActiveSheet(0)->setTitle("Laporan Bonus Sales Poin");
    $excel->setActiveSheetIndex(0);
    // Proses file excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Laporan Bonus Sales Poin.xls"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');
    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $write->save('php://output');
	}

	public function export_pelunasan()
	{
		$excel = new PHPExcel();
		// Settingan awal fil excel
		$excel->getProperties()->setCreator('GOMASGO')
								 ->setTitle("Data Laporan Bonus Poin Pelunasan")
								 ->setDescription("Laporan Bonus Poin Pelunasan");

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "KODE USER");
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "NAMA LENGKAP");
		$excel->setActiveSheetIndex(0)->setCellValue('C1', "HP");
		$excel->setActiveSheetIndex(0)->setCellValue('D1', "EMAIL");
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "ALAMAT");
		$excel->setActiveSheetIndex(0)->setCellValue('F1', "POIN");

		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('C1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('D1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('E1')->applyFromArray($this->style_row);
		$excel->getActiveSheet()->getStyle('F1')->applyFromArray($this->style_row);

		$sql = "select kode_user, nama_lengkap, customer.email, customer.hp, alamat, poin_pelunasan from user join customer on user.id = customer.user_id where poin_pelunasan > 0";
		$poin = $this->Mgeneral->post_query_sql($sql);

		$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 2
		foreach($poin as $data){ // Lakukan looping pada variabel siswa
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data->kode_user);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nama_lengkap);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->hp);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->email);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->alamat);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->poin_sponsor);

			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);

			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Laporan Bonus Poin Pelunasan");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="Laporan Bonus Poin Pelunasan.xls"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		$write->save('php://output');
	}

	public function pencairan_komisi()
	{
		# kembaliakn nilai komisi ke 0 di tabel customer
		$customer = $this->Mgeneral->getWhere(array('komisi >'=>0),'customer');
		foreach ($customer as $key) {
			$this->Mgeneral->update(array('id_cust'=>$key->id_cust),array('komisi'=>0),'customer');
			# get last record bonus history komisi
			$sql = "select * from bonus_history where jenis = 'komisi' and tipe = 'sponsor' and user_id = ".$key->user_id." order by tgl desc limit 1";
			$dataHistory = $this->Mgeneral->post_query_sql($sql);
			if(isset($dataHistory)){
				$this->Mgeneral->save(array(
					'user_id'     => $key->user_id,
					'nilai'       => $customer[0]->komisi,
					'nilai_akhir' => $dataHistory[0]->nilai_akhir - $key->komisi,
					'jenis'       => 'komisi',
					'tipe'        => 'pencairan',
					'keterangan'	=> $this->input->post('keterangan')
				),'bonus_history');
			}
		}
		echo json_encode(['status'=>1,'message'=>'Pencairan Telah Diproses']);
	}

	public function pencairan_sales_poin()
	{
		# kembaliakn nilai poin sponsor ke 0 di tabel customer
		$customer = $this->Mgeneral->getWhere(array('poin_sponsor >'=>0),'customer');
		foreach ($customer as $key) {
			$this->Mgeneral->update(array('id_cust'=>$key->id_cust),array('poin_sponsor'=>0),'customer');
			$this->Mgeneral->update(array('user_id'=>$key->user_id),array(
				'poin_group1' => 0,
				'poin_group2' => 0,
				'poin_group3' => 0,
				'poin_group4' => 0,
				'poin_group5' => 0,
				'poin_group6' => 0,
				'poin_group7' => 0,
				'poin_group8' => 0,
				'poin_group9' => 0,
				'poin_group10' => 0,
			),'bonus_breakdown');
		}

		redirect('laporan/sales');
	}


}
