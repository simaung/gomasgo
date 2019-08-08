<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Home</a></li>
  <li><a href="<?=base_url()?>paket">Paket Umroh</a></li>
  <?php if (isset($paket)): ?>
    <li class="active">Edit Data</li>
  <?php else: ?>
    <li class="active">Tambah Data</li>
  <?php endif; ?>
</ol>


<?php if (isset($_SESSION['success'])): ?>
  <span id="add_paket_status" data-message="<?=$_SESSION['success']?>" data-type="success" data-title="Berhasil">
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
  <span id="add_paket_status" data-message="<?=$_SESSION['error']?>" data-type="error" data-title="Ooop..!">
<?php endif; ?>

<!-- Row -->
<div class="row">
  <!-- Column -->
  <div class="col-md-12">
    <div class="card">
      <div class="card-block">
        <h5>Form Paket Umroh</h5><hr />
          <form id="form_paket_umroh" method="post" action="<?=base_url()?>paket/save/<?=isset($paket)?$paket->id_paket : ''?>">
            <div class="form-group row">
              <label for="nama" class="col-sm-3 form-control-label">Nama</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nama" name="nama" value="<?=isset($paket)?$paket->nama_paket : ''?>" placeholder="Nama Paket Umroh">
              </div>
            </div>
            <div class="form-group row">
              <label for="harga" class="col-sm-3 form-control-label">Harga</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="harga" name="harga" value="<?=isset($paket)?int_to_rupiah($paket->harga) : ''?>" placeholder="Harga Paket">
              </div>
            </div>
            <div class="form-group row">
              <label for="harga_cabang" class="col-sm-3 form-control-label">Harga Cabang</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="harga_cabang" name="harga_cabang" value="<?=isset($paket)?int_to_rupiah($paket->harga_cabang) : ''?>" placeholder="Harga Cabang">
              </div>
            </div>
            <div class="form-group row">
              <label for="status" class="col-sm-3 form-control-label">Status</label>
              <div class="col-sm-9">
                <div class="radio">
                  <?php
				  if(isset($paket)){
                    if($paket->id_paket == 1){
                      $check_1 = "checked";
                      $check_2 = "";
                    }else{
                      $check_1 = "";
                      $check_2 = "checked";
                    }
                  }else{
                    $check_1 = "checked";
                    $check_2 = "";
                  }
                   ?>
                  <label>
                    <input type="radio" name="status" id="status_active" value="1" <?=$check_1?>> Aktif
                  </label>
                  <label>
                    <input type="radio" name="status" id="status_not_active" value="0" <?=$check_2?>> Tidak Aktif
                  </label>
                </div>
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
