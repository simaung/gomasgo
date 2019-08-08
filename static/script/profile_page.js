$(document).ready(function() {
  $('.select2').select2();
  $("#lightgallery").lightGallery();
  $('.user-profile-friends').lightGallery({
    thumbnail: true,
    selector: 'a'
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
  $('#form_profile').validate({
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
			}
    }
  });
  $('#form_password').validate({
    rules: {
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
			password: {
			  required: "Password harus di isi",
        minlength: "Password harus lebih dari 6 karakter",
			},
			confirm_password: {
			  required: "Password harus di isi",
			  minlength: "Password harus lebih dari 6 karakter",
        equalTo: "Isi kedua password tidak sama"
			}
    }
  });
  $('#form_akun_bank').validate({
    rule: {
      nama_bank: {
        required: true
      },
      cabang: {
        required: true
      },
      nama_pemilik: {
        required: true
      },
      no_rekening: {
        required: true
      }
    },
    messages: {
      nama_bank: {
        required: "Nama bank harus di isi"
      },
      cabang: {
        required: "Cabang bank harus di isi"
      },
      nama_pemilik: {
        required: "Nama pemilik akun rekening harus di isi"
      },
      no_rekening: {
        required: "No rekening harus di isi"
      }
    }
  })
  if($('.profile_status').length){
    swal({
      allowOutsideClick: false,
      type: 'success',
      title: 'Berhasil',
      text: $('.profile_status').data('message'),
    });
  }
});
