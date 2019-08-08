<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="base_url" content="<?=base_url()?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Gomasgo Umrah</title>
  <meta name="robots" content="noindex">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
  <link type="text/css" href="<?=static_file()?>assets/css/style.min.css" rel="stylesheet">
  <link type="text/css" href="<?=static_file()?>jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet">
  <link type="text/css" href="<?=static_file()?>jquery-ui-1.12.1/jquery-ui.structure.min.css" rel="stylesheet">
  <link type="text/css" href="<?=static_file()?>jquery-ui-1.12.1/jquery-ui.theme.min.css" rel="stylesheet">
  <style type="text/css">
    .error{
      color: red
    }
  </style>
</head>

<body class="login" style="background-image:url('<?=static_file()?>img/sayagata.png');">

  <div class="row">
    <div class="col-sm-10 col-sm-push-1 col-md-6 col-md-push-3 col-lg-6 col-lg-push-3">
      <h2 class="text-primary center m-a-2">
        <img src="<?=static_file()?>/img/logo.png">
      </h2>
      <div class="card-group">
        <div class="card bg-transparent2">
          <div class="card-block">
            <div class="center">
              <h4 class="m-b-0"><span class="icon-text">Login</span></h4>
              <p class="text-muted">Masuk ke akun anda</p>
            </div>
            <form action="<?=base_url()?>auth/login" method="post" id="form_login">
              <div class="form-group">
                <input type="text" class="form-control" name="credential" id="credential" placeholder="Member ID / Email">
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <a href="<?=base_url()?>auth/forgot" class="pull-xs-right">
                  <small>Lupa password?</small>
                </a>
                <div class="clearfix"></div>
              </div>
              <div class="center">
                <button type="submit" class="btn  btn-primary btn-rounded" id="tombol_login">
                  Login
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="card">
          <div class="card-block center">
            <h4 class="m-b-0">
              <span class="icon-text">Daftar</span>
            </h4>
            <p class="text-muted">Pendaftaran Marketing Baru</p>
            <form action="<?=base_url()?>auth/register" method="post" id="form_register">
              <div class="form-group">
                <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Lengkap">
              </div>
              <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Alamat Email">
              </div>
              <div class="form-group">
                <input type="text" class="form-control"  name="hp" id="hp" placeholder="No Handphone">
              </div>
              <?php if ($partner_code != ""): ?>
                <input type="hidden" name="referal" value="<?=$partner_code?>" />
                <p class="text-muted">Referal anda <?=$partner_code?></p>
              <?php endif; ?>
              <button type="submit" class="btn btn-primary btn-rounded" id="tombol_daftar">
                <i id="loading" class="fa fa-spinner fa-spin" style="font-size:24px; display: none"></i>
                <span id="wait">Daftar Sekarang</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

	<script src="<?=static_file()?>assets/vendor/jquery.min.js"></script>
	<script src="<?=static_file()?>assets/vendor/tether.min.js"></script>
	<script src="<?=static_file()?>assets/vendor/bootstrap.min.js"></script>
	<script src="<?=static_file()?>assets/vendor/adminplus.js"></script>
	<script src="<?=static_file()?>assets/js/main.min.js"></script>
  <script src="<?=static_file()?>assets/vendor/sweetalert.js"></script>
  <script src="<?=static_file()?>jquery-ui-1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
  <script src="<?=static_file()?>assets/js/auth.js"></script>
</body>
</html>
