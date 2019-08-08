$(document).ready(function () {
  $('#jumlah').number(true,0,',','.');
  $('#form_pembayaran').validate({
    rules: {
			jumlah: {
        required: true
      },
			jenis: {
        required: true,
      }
    },
		messages: {
			jumlah: {
			  required: "Harap isi jumlah pembayaran anda",
			},
			jenis: {
			  required: "Harap pilih salah satu jenis pembayaran",
			}
    },
    submitHandler: function (form) {
      $.ajax({
				url:  $(form).attr('action'),
				type: "POST",
				dataType: 'json',
				data: $(form).serialize(),
				beforeSend: function() {
					$("#tombol_bayar").attr('disabled');
				},
				success: function(data) {
					if(data.status > 0){
            swal({
              allowOutsideClick: false,
              type: 'success',
              title: 'Berhasil',
              text: 'Pembayaran Berhasil',
			        showConfirmButton: false,
              timer:1500,
              onClose: function(){
                location.reload(true);
              }
            });
					}else{
            swal({
              type: 'error',
              title: 'Oops...',
              text: 'Pembayaran Gagal',
            })
					}
				},
        complete: function(data){
          $("#tombol_bayar").removeAttr('disabled');
        },
			});
    }
  });
});

function show_modal_pembayaran(id_trx,jenis = 0) {
  console.log(id_trx);
  $('#form_pembayaran').attr('action',$("meta[name=base_url]").attr('content')+'transaksi/pembayaran/'+id_trx);
  $('#pembayaran_modal').modal('show');
  if(jenis > 0){
    $('#jenis_pembayaran').empty().append('<input type="hidden" class="form-control" id="jenis" name="jenis" value="dp"><input type="text" class="form-control" value="Down Payment" readonly>');
  }else{
    $('#jenis_pembayaran').empty().append('<select class="form-control" name="jenis" id="jenis">'+
      '<option value="">-- Pilih Jenis --</option>'+
      '<option value="topup">Topup</option>'+
      '<option value="pelunasan">Pelunasan</option>'+
    '</select>');
  }
}
