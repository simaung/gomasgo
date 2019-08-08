$(document).ready(function() {
  $('#harga').number(true,0,',','.');
  $('#harga_cabang').number(true,0,',','.');

  $('#form_paket_umroh').validate({
    rules: {
      nama: {
        required: true,
        minlength: 3
      },
      harga_cabang: {
        required: true
      },
			harga: {
        required: true
      }
    },
		messages: {
			nama: {
			  required: "Harap isi nama paket anda",
			},
      harga_cabang: {
        required: "Harap isi harga cabang"
      },
			harga: {
        required: "Harap isi harga paket"
      }
    },
  });

  if($('#add_paket_status').length){
    swal({
      allowOutsideClick: false,
      type: $('#add_paket_status').data('type'),
      title: $('#add_paket_status').data('title'),
      text: $('#add_paket_status').data('message'),
    });
  }
});
