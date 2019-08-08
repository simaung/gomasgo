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
        <img src="<?=static_file()?>img/logo.png">
      </h2>
      <div class="card-group">
        <div class="card bg-transparent2">
          <div class="card-block">
            <?php if ($status): ?>
              <div class="center">
                <p class="text-muted">Silahkan Setting Password Anda</p>
              </div>
              <form action="<?=base_url()?>auth/update_password" method="post" id="form_reset_password">
                <input type="hidden" name="user_id" value="<?=$user->id?>"/>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Konfirmasi Password">
                </div>
                <div class="center">
                  <button type="submit" class="btn  btn-primary btn-rounded" id="tombol_save">
                    Simpan
                  </button>
                </div>
              </form>
            <?php else: ?>
              <div class="center">
                <h4 class="m-b-0"><span class="icon-text">Data Tidak Ditemukan</span></h4>
              </div>
            <?php endif; ?>
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
