$(document).ready(function(){

	/* Set the defaults for DataTables initialisation */
	var DataTable = $.fn.dataTable;
	$.extend( true, DataTable.defaults, {
		dom:
			"<'row'<'col-sm-6'l><'col-sm-6'f>>" +
			"<'table-responsive'tr>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
		renderer: 'bootstrap'
	} );
	if($('#DataMarketing').length) {
       load_ajax_datatable('DataMarketing',$("meta[name=base_url]").attr('content')+'load/data_marketing');
    }

	if($('#DataJamaah').length) {
	  load_ajax_datatable('DataJamaah',$("meta[name=base_url]").attr('content')+'load/data_jamaah');
	}

	if($('#DataTrxJamaah').length) {
	  load_ajax_datatable('DataTrxJamaah',$("meta[name=base_url]").attr('content')+'load/trx_jamaah');
	}

	if($('#DataStaff').length) {
	  load_ajax_datatable('DataStaff',$("meta[name=base_url]").attr('content')+'load/data_staff');
	}

	if($('#DataCabang').length) {
	  load_ajax_datatable('DataCabang',$("meta[name=base_url]").attr('content')+'load/data_cabang');
	}

	if($('#DataPaket').length) {
	  load_ajax_datatable('DataPaket',$("meta[name=base_url]").attr('content')+'load/data_paket');
	}

	if($('#DataTransaksi').length) {
	  load_ajax_datatable('DataTransaksi',$("meta[name=base_url]").attr('content')+'load/data_transaksi');
	}

	if($('#dMarketing').length) {
		load_ajax_datatable('dMarketing',$("meta[name=base_url]").attr('content')+'load/data_marketing2/'+$("meta[name=kode]").attr('content'));
	}

	if($('#dJamaah').length) {
		load_ajax_datatable('dJamaah',$("meta[name=base_url]").attr('content')+'load/data_jamaah2/'+$("meta[name=id]").attr('content'));
	}

	if($('#DataBonusSponsor').length) {
		load_ajax_datatable('DataBonusSponsor',$("meta[name=base_url]").attr('content')+'load/data_bonus_sponsor');
	}

	if($('#DataBonusSales').length) {
		load_ajax_datatable('DataBonusSales',$("meta[name=base_url]").attr('content')+'load/data_bonus_sales');
	}

	if($('#DataBonusPelunasan').length) {
		load_ajax_datatable('DataBonusPelunasan',$("meta[name=base_url]").attr('content')+'load/data_bonus_pelunasan');
	}

	if($('#DataSetting').length) {
		load_ajax_datatable('DataSetting',$("meta[name=base_url]").attr('content')+'load/data_setting');
	}
});

function load_ajax_datatable(idTable, Url, sortColumn, sortType, idPage)
{
	sortColumn = typeof sortColumn !== 'undefined' ? sortColumn : 0;
	sortType = typeof sortType !== 'undefined' ? sortType : 'desc';

	table = $('#' + idTable).dataTable
		({
			"pageLength": 10, //jumlah default data yang ditampilkan
			"lengthMenu": [5, 10, 25, 50, 100], //isi combo box menampilkan jumlah data
			"pagingType": "full_numbers", //tipe pagination
			"order": [[sortColumn, sortType]], //index kolom yg akan di-sorting
			"processing": false, //show tulisan dan loading bar
			'serverSide': true, //ajax server side
			'ajax': {
				'url': Url,
				'type': 'POST'
			}
		});

}

function delConf(link) {
	swal({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Ya, Hapus!',
  cancelButtonText: 'Tidak, Batalkan!',
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false,
  reverseButtons: true
}).then((result) => {
  if (result.value) {
		$.ajax({
			type: "GET",
			url: link,
			dataType: "json",
			success: function(data){
				if(data.status){
					swal({
						allowOutsideClick: false,
						type: 'success',
						title: 'Berhasil',
						text: data.msg,
						showConfirmButton: false,
						timer:1500,
						onClose: function () {
							location.reload(true);
						}
					});
				}else{
					swal({
						type: 'error',
						title: 'Oops...',
						text: data.msg,
					})
				}
			}
		})
  } else if (
    // Read more about handling dismissals
    result.dismiss === swal.DismissReason.cancel
  ) {
    swal(
      'Cancel',
      'Hapus data dibatalkan :)',
      'error'
    )
  }
})
}
