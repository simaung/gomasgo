$(document).ready(function(){
  $('#form_register').validate({ // initialize the plugin
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
    },
    submitHandler: function (form) {
      $.ajax({
				url:  $(form).attr('action'),
				type: "POST",
				dataType: 'json',
				data: $(form).serialize(),
				beforeSend: function() {
					$("#tombol_daftar").attr('disabled');
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
                $('#form_register')[0].reset();
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
          $("#tombol_daftar").removeAttr('disabled');
          $('#wait').text("Daftar Sekarang");
          $('#loading').css('display','none');
        },
			});
    }
  });
  $('#form_login').validate({
    rules: {
			credential: {
        required: true
      },
			password: {
        required: true,
        minlength: 6
      }
    },
		messages: {
			credential: {
			  required: "Harap isi member id /email lengkap anda",
			},
			password: {
			  required: "Password harus di isi",
			  minlength: "Password harus lebih dari 6 karakter",
			}
    },
    submitHandler: function (form) {
      $.ajax({
				url:  $(form).attr('action'),
				type: "POST",
				dataType: 'json',
				data: $(form).serialize(),
				beforeSend: function() {
					$("#tombol_login").attr('disabled');
				},
				success: function(data) {
					if(data.status > 0){
            swal({
              allowOutsideClick: false,
              type: 'success',
              title: 'Berhasil',
              text: 'Login Sukses',
			        showConfirmButton: false,
              timer:1500,
			        onClose: function () {
                window.location = $("meta[name=base_url]").attr('content')+"home";
              }
            });
					}else{
            swal({
              type: 'error',
              title: 'Oops...',
              text: data.msg,
            })
					}
				},
        complete: function(data){
          $("#tombol_login").removeAttr('disabled');
        },
			});
    }
  });
  $('#form_password').validate({
    rules: {
      paket: {
        required: true
      },
      jenis: {
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
      paket:{
        required: "Silahkan Pilih Paket Umroh Terlebih Dahulu"
      },
      jenis:{
        required: "Silahkan Pilih Jenis Member"
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
					$("#tombol_login").attr('disabled');
          $('#wait').text("");
          $('#loading').css('display','block');
				},
				success: function(data) {
					if(data.status > 0){
            swal({
              allowOutsideClick: false,
              type: 'success',
              title: 'Berhasil',
              text: "Silahkan Cek Email, Untuk Melihat Informasi Detailnya",
              onClose: function () {
                window.location = $("meta[name=base_url]").attr('content')+"auth";
              }
            });
					}else{
            swal({
              type: 'error',
              title: 'Oops...',
              text: data.msg,
            })
					}
				},
        complete: function(data){
          $("#tombol_login").removeAttr('disabled');
          $('#wait').text("Simpan");
          $('#loading').css('display','none');
        },
			});
    }
  });
  $('#form_forgot').validate({
    rules: {
      email: {
        required: true,
        email: true
      }
    },
		messages: {
			email: {
			  required: "Harap isi alamat email anda",
			}
    },
    submitHandler: function (form) {
      $.ajax({
				url:  $(form).attr('action'),
				type: "POST",
				dataType: 'json',
				data: $(form).serialize(),
				beforeSend: function() {
					$("#tombol_request").attr('disabled');
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
                $('#form_forgot')[0].reset();
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
        error: function () {
          swal({
            allowOutsideClick: false,
            type: 'error',
            title: 'Oops...',
            text: 'Error Server, Hubungi Admin',
          })
        },
        complete: function(data){
          $("#tombol_request").removeAttr('disabled');
          $('#wait').text("Simpan");
          $('#loading').css('display','none');
        },
			});
    }
  });
  $('#form_reset_password').validate({
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
    },
    submitHandler: function (form) {
      $.ajax({
				url:  $(form).attr('action'),
				type: "POST",
				dataType: 'json',
				data: $(form).serialize(),
				beforeSend: function() {
					$("#tombol_save").attr('disabled');
				},
				success: function(data) {
					if(data.status > 0){
            swal({
              allowOutsideClick: false,
              type: 'success',
              title: 'Berhasil',
              text: "Password Telah Disimpan, Klik OK Untuk Ke Halaman Login",
              onClose: function () {
                window.location = $("meta[name=base_url]").attr('content')+"auth";
              }
            });
					}else{
            swal({
              type: 'error',
              title: 'Oops...',
              text: "Terjadi Kesalahan, Silahkan Hubungi Admin",
            })
					}
				},
        complete: function(data){
          $("#tombol_save").removeAttr('disabled');
        },
			});
    }
  })
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
});
