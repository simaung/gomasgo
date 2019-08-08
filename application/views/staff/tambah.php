<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Home</a></li>
  <li><a href="<?=base_url()?>staff">Pengaturan Akun <?=ucfirst($tipe)?></a></li>
  <?php if (isset($user)): ?>
    <li class="active">Edit Data</li>
  <?php else: ?>
    <li class="active">Tambah Data</li>
  <?php endif; ?>
</ol>


<?php if (isset($_SESSION['success'])): ?>
  <span id="add_staff_status" data-message="<?=$_SESSION['success']?>" data-type="success" data-title="Berhasil">
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
  <span id="add_staff_status" data-message="<?=$_SESSION['error']?>" data-type="error" data-title="Ooop..!">
<?php endif; ?>

<!-- Row -->
<div class="row">
  <!-- Column -->
  <div class="col-md-12">
    <div class="card">
      <div class="card-block">
        <h5>Form Pendaftaran <?=ucfirst($tipe)?></h5><hr />
          <form id="form_staff" method="post" action="<?=base_url()?>staff/save/<?=isset($user)?$user->id : ''?>" enctype="multipart/form-data">
            <input type="hidden" class="form-control" name="tipe" value="<?=$tipe?>">
            <div class="form-group row">
              <label for="nama" class="col-sm-3 form-control-label">Nama</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nama" name="nama" value="<?=isset($user)?$user->nama : ''?>" placeholder="Nama Lengkap">
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-3 form-control-label">Email</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="email" name="email" value="<?=isset($user)?$user->email : ''?>" placeholder="Alamat Email">
              </div>
            </div>
            <div class="form-group row">
              <label for="hp" class="col-sm-3 form-control-label">Handphone</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="hp" name="hp" value="<?=isset($user)?$user->hp : ''?>" placeholder="No Handphone">
              </div>
            </div>
            <div class="form-group row">
              <label for="password" class="col-sm-3 form-control-label">Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              </div>
            </div>
            <div class="form-group row">
              <label for="confirm_password" class="col-sm-3 form-control-label">Konfirmasi Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password">
              </div>
            </div>
            <div class="form-group row">
              <label for="foto_profile" class="col-sm-3 form-control-label">Foto</label>
              <div class="col-sm-9">
                <input type="file" class="form-control-file" id="foto_profile" name="foto_profile" />
                <small class="text-help"></small>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-primary" id="tombol_simpan">
                  Simpan
                </button>
              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
  <!-- // END Column -->

</div>
<!-- // END Row -->
