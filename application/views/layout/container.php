<!DOCTYPE html>
<html class="bootstrap-layout">
<head>
  <?=$head?>
  <style type="text/css">
    .error{
      color: red
    }
  </style>
</head>

<body class="layout-container ls-top-navbar si-l3-md-up">

  <!-- Navbar -->
  <?=$navbar?>
  <!-- // END Navbar -->

  <!-- Sidebar -->
  <?=$sidebar?>
  <!-- // END Sidebar -->

  <!-- Content -->
  <div class="layout-content" data-scrollable>
    <div class="container-fluid">

      <?=$content?>

    </div>
  </div>

  <!-- Modal Share -->
  <div class="modal fade" id="share_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
        <center>
            <div class="form-group">
              <label for="exampleInputEmail1">Link referal anda</label>
              <div class="input-group">
              <input type="text" class="form-control" id="link_referal" value="<?=base_url()?>auth?r=<?=$_SESSION['kode_user']?>">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button" onclick="copy_text()">
                  <i class="material-icons">content_copy</i>
                </button>
              </span>
              </div>
              <small class="text-help" id="referal_help">copy link diatas untuk mengajak bergabung orang lain.</small>
            </div>
           <div class="a2a_kit a2a_kit_size_32 a2a_default_style sharelink" data-a2a-url="<?=base_url()?>auth?r=<?=$_SESSION['kode_user']?>" data-a2a-title="GOMASGO UMROH">
                <a class="a2a_button_facebook"></a>
                <a class="a2a_button_twitter"></a>
                <a class="a2a_button_linkedin"></a>
                <a class="a2a_button_google_gmail"></a>
                <a class="a2a_button_whatsapp"></a>
                <a class="a2a_button_copy_link"></a>
                <a class="a2a_button_facebook_messenger"></a>
                <a class="a2a_button_line"></a>
            </div>
            <script async src="https://static.addtoany.com/menu/page.js"></script>
            <script type="text/javascript">
              function copy_text() {
                /* Get the text field */
                var copyText = document.getElementById("link_referal");

                /* Select the text field */
                copyText.select();

                /* Copy the text inside the text field */
                document.execCommand("Copy");
                /* Notify */
                document.getElementById('referal_help').innerHTML = "link berhasil dicopy ke clipboard";
              }
            </script>
        </center>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Pembayaran -->
  <div class="modal fade" id="pembayaran_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form id="form_pembayaran" action="" method="post">
          <div class="modal-header">
            <h4 class="modal-title">Pembayaran Baru</h4>
          </div>
          <div class="modal-body">
            <div class="form-group row">
              <label for="nama" class="col-sm-4 form-control-label">Jumlah Bayar</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah Bayar">
              </div>
            </div>
            <div class="form-group row">
              <label for="via" class="col-sm-4 form-control-label">Via</label>
              <div class="col-sm-8">
                <label>
                  <input type="radio" name="via" id="via_tunai" value="tunai" checked> Tunai
                </label>
                <label>
                  <input type="radio" name="via" id="via_transfer" value="transfer bank"> Transfer Bank
                </label>
              </div>
            </div>
            <div class="form-group row">
              <label for="jenis" class="col-sm-4 form-control-label">Jenis Pembayaran</label>
              <div class="col-sm-8" id="jenis_pembayaran">
                
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary" id="tombol_bayar">Bayar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?=$footer?>
</body>
</html>
