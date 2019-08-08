$(document).ready(function(){
  if($('#update_setting_status').length){
    swal({
      allowOutsideClick: false,
      type: $('#update_setting_status').data('type'),
      title: $('#update_setting_status').data('title'),
      text: $('#update_setting_status').data('message'),
    });
  }
  $('#form_setting').validate({
    rules: {
      group: {
        required: true,
      },
      nama: {
        required: true
      },
			nilai: {
        required: true
      }
    },
		messages: {
			group: {
			  required: "Harap isi group setting",
			},
      nama: {
        required: "Harap isi nama setting"
      },
			nilai: {
        required: "Harap isi nilai setting"
      }
    },
  })
})
