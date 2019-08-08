<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Home</a></li>
  <li><a href="<?=base_url()?>setting">Setting</a></li>
  <li class="active">Update Setting</li>
</ol>



<?php if (isset($_SESSION['success'])): ?>
  <span id="update_setting_status" data-message="<?=$_SESSION['success']?>" data-type="success" data-title="Berhasil">
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
  <span id="update_setting_status" data-message="<?=$_SESSION['error']?>" data-type="error" data-title="Ooop..!">
<?php endif; ?>

<!-- Row -->
<div class="row">
  <!-- Column -->
  <div class="col-md-12">
    <div class="card">
      <div class="card-block">
        <h5>Form Update Setting</h5><hr />
          <form id="form_setting" method="post" action="<?=base_url()?>setting/update/<?=$setting->setting_id?>">
            <div class="form-group row">
              <label for="group" class="col-sm-3 form-control-label">Group</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="group" name="group" value="<?=$setting->setting_group?>" placeholder="Nama Group Setting">
              </div>
            </div>
            <div class="form-group row">
              <label for="nama" class="col-sm-3 form-control-label">Nama</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nama" name="nama" value="<?=$setting->setting_name?>" placeholder="Nama Setting">
              </div>
            </div>
            <div class="form-group row">
              <label for="nilai" class="col-sm-3 form-control-label">Nilai</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nilai" name="nilai" value="<?=$setting->setting_value?>" placeholder="Nilai Setting">
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
