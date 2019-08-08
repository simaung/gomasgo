$(document).ready(function(){
  $('#form_staff').validate({
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
  });
  if($('#add_staff_status').length){
    swal({
      allowOutsideClick: false,
      type: $('#add_staff_status').data('type'),
      title: $('#add_staff_status').data('title'),
      text: $('#add_staff_status').data('message'),
    });
  }
})
