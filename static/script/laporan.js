function komisi() {
  swal({
    title: 'Apakah anda yakin ?',
    input: 'textarea',
    showCancelButton: true,
    inputPlaceholder: "Tuliskan Keterangan Pencairan",
    confirmButtonText: 'Ya',
  }).then((result) => {
    console.log(result);
    if(result.value){
      $.ajax( {
        type: "POST",
        url: $("meta[name=base_url]").attr('content')+'laporan/pencairan_komisi',
        data: {
          keterangan: result.value
        },
        dataType: 'json',
        success: function( data ) {
          swal(
            'Berhasil',
            'Pencairan Bonus Komisi Telah Diproses',
            'success'
          )
        }
      });
    }else{
      swal(
        'Gagal',
        'Anda Harus Mengisi Keterangan Untuk Melanjutkan Pencairan',
        'error'
      )
    }
  });
}
