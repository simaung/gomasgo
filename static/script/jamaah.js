$(document).ready(function() {
  $('.select2').select2();
  $('#provinsi').change(function(){
    $.ajax({
      type: "GET",
      url: $("meta[name=base_url]").attr('content')+"ajax/get_kota_by_provinsi/"+$(this).val(),
      beforeSend: function(){
        $('#kota').empty();
      },
      success: function(result){
        $('#kota').append(result);
      },
      error: function(){
        $('#kota').append("<option value=''>-- Pilih Kota --</option>");
      }
    })
  });
  $( "#presenter" ).autocomplete({
    source: function( request, response ) {
        $.ajax( {
          type: "GET",
          url: $("meta[name=base_url]").attr('content')+'ajax/get_presenter',
          dataType: 'json',
          data: {
            term: request.term
          },
          success: function( data ) {
            response( data );
          }
        } );
      },
      minLength: 2,
  });
  $('#tombol_simpan').click(function(){
    var kode_presenter = $('#presenter').val();
    if(kode_presenter != ""){
      $.ajax({
        type: 'GET',
        url: $("meta[name=base_url]").attr('content')+'ajax/check_presenter',
        dataType: 'json',
        data: {
          presenter: kode_presenter
        },
        success: function(data){
          if(data.status){
            $('#form_jamaah').trigger('submit');
          }else{
            swal({
              allowOutsideClick: false,
              type: 'error',
              title: 'Oops...',
              text: data.msg,
            })
          }
        }
      })
    }else{
      $('#form_jamaah').trigger('submit');
    }
  })
  if($('#add_jamaah_status').length){
    swal({
      allowOutsideClick: false,
      type: $('#add_jamaah_status').data('type'),
      title: $('#add_jamaah_status').data('title'),
      text: $('#add_jamaah_status').data('message'),
    });
  }
  $('#form_jamaah').validate({
    rules: {
      paket: {
        required: true
      },
      nama: {
        required: true,
        minlength: 3
      },
			hp: {
        required: true,
        minlength: 10
      },
      id_card: {
        required: true
      },
      tgl_lahir: {
        required: true
      },
      provinsi: {
        required: true
      },
      kota: {
        required: true
      },
      alamat: {
        required: true
      }
    },
		messages: {
      paket: {
        required: "Harap pilih salah satu paket umroh"
      },
			nama: {
			  required: "Harap isi nama lengkap anda",
			  minlength: "Nama harus lebih dari 5 karakter",
			},
			email: {
			  required: "Harap isi alamat email anda",
			},
			hp: {
			  required: "Harap isi no Handphone anda",
			  minlength: "Nomor harus lebih dari 10 digit",
			},
      id_card: {
        required: "Harap isi No Kartu Identitas anda"
      },
      tgl_lahir: {
        required: "Harap isi tanggal lahir anda"
      },
      provinsi: {
        required: "Harap pilih salah satu provinsi"
      },
      kota: {
        required: "Harap pilih salah satu kota"
      },
      alamat: {
        required: "Harap isi alamat anda"
      }
    }
  });
});
