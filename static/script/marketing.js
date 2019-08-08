jQuery.validator.addMethod("notEqual", function(value, element, param) {
  return this.optional(element) || value != param;
}, "Please specify a different (non-default) value");

$(document).ready(function() {
  $('.select2').select2();
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
  if($('#add_marketing_status').length){
    swal({
      allowOutsideClick: false,
      type: $('#add_marketing_status').data('type'),
      title: $('#add_marketing_status').data('title'),
      text: $('#add_marketing_status').data('message'),
    });
  }
  $('#form_marketing').validate({
    rules: {
      nama: {
        required: true,
        minlength: 3
      },
      email: {
        required: true,
        email: true
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
      },
      password: {
        required: true,
        minlength: 6
      },
			confirm_password: {
        required: true,
        minlength: 6,
        equalTo: "#password"
      }
    },
		messages: {
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
      },
      password: {
			  required: "Password harus di isi",
        minlength: "Password harus lebih dari 6 karakter",
			},
			confirm_password: {
			  required: "Password harus di isi",
			  minlength: "Password harus lebih dari 6 karakter",
        equalTo: "Isi kedua password tidak sama"
			}
    },
    submitHandler: function (form) {
      $.ajax({
				url:  $(form).attr('action'),
				type: "POST",
				dataType: 'json',
				data: $(form).serialize(),
				beforeSend: function() {
					$("#tombol_simpan").attr('disabled');
          $('#wait').text("");
          $('#loading').css('display','block');
				},
				success: function(data) {
					if(data.status > 0){
            swal({
              allowOutsideClick: false,
              type: 'success',
              title: 'Berhasil',
              text: data.msg,
              onClose: function () {
                window.location = $("meta[name=base_url]").attr('content')+"marketing";
              }
            });
					}else{
            swal({
              allowOutsideClick: false,
              type: 'error',
              title: 'Oops...',
              text: data.msg,
            })
					}
				},
        complete: function(data){
          $("#tombol_simpan").removeAttr('disabled');
          $('#wait').text("Simpan");
          $('#loading').css('display','none');
        },
			});
    }
  });
});
