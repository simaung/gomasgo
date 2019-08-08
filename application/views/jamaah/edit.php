<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Home</a></li>
  <li><a href="<?=base_url()?>jamaah">Jamaah</a></li>
  <li class="active">Tambah Data</li>
</ol>


<?php if (isset($_SESSION['success'])): ?>
  <span id="add_jamaah_status" data-message="<?=$_SESSION['success']?>" data-type="success" data-title="Berhasil">
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
  <span id="add_jamaah_status" data-message="<?=$_SESSION['error']?>" data-type="error" data-title="Ooop..!">
<?php endif; ?>

<?php if (isset($error)): ?>
  <!-- Row -->
  <div class="row">
    <!-- Column -->
    <div class="col-md-12">
      <div class="card">
        <div class="card-block">
          <h5>Data Tidak Ditemukan</h5>
        </div>
      </div>
    </div>
  </div>
<?php else: ?>
  <!-- Row -->
  <div class="row">
    <!-- Column -->
    <div class="col-md-12">
      <div class="card">
        <div class="card-block">
          <h5>Edit Data Jamaah</h5>
            <form id="form_jamaah" method="post" action="<?=base_url()?>jamaah/save/<?=$customer->id_cust?>" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="nama" class="col-sm-3 form-control-label">Nama Lengkap</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nama" name="nama" value="<?=$customer->nama_lengkap?>" placeholder="Nama Lengkap">
                </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-sm-3 form-control-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="email" name="email" value="<?=$customer->email?>" placeholder="Alamat Email">
                </div>
              </div>
              <div class="form-group row">
                <label for="hp" class="col-sm-3 form-control-label">Handphone</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="hp" name="hp" value="<?=$customer->hp?>" placeholder="No Handphone">
                </div>
              </div>
              <div class="form-group row">
                <label for="id_card" class="col-sm-3 form-control-label">Kartu Identitas</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="id_card" name="id_card" value="<?=$customer->id_card?>" placeholder="No Kartu Identitas (KTP/SIM)">
                </div>
              </div>
              <div class="form-group row">
                <label for="tgl_lahir" class="col-sm-3 form-control-label">Tanggal Lahir</label>
                <div class="col-sm-9">
                  <input type="text" class="datepicker form-control" id="tgl_lahir" name="tgl_lahir" value="<?=to_human_date($customer->tgl_lahir)?>" placeholder="Tanggal Lahir">
                </div>
              </div>
              <div class="form-group row">
                <label for="provinsi" class="col-sm-3 form-control-label">Provinsi</label>
                <div class="col-sm-9">
                  <select class="form-control select2" id="provinsi" name="provinsi">
                    <option value="">-- Pilih Provinsi --</option>
                    <?php foreach ($provinsi as $key ): ?>
                      <?php if ($key->id == $customer->id_provinsi): ?>
                        <option value="<?=$key->id?>" selected><?=$key->name?></option>
                      <?php else: ?>
                        <option value="<?=$key->id?>"><?=$key->name?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="kota" class="col-sm-3 form-control-label">Kota</label>
                <div class="col-sm-9">
                  <select class="form-control select2" id="kota" name="kota">
                    <option value="">-- Pilih Kota --</option>
                    <?php foreach ($kota as $key ): ?>
                      <?php if ($key->id == $customer->id_kota): ?>
                        <option value="<?=$key->id?>" selected><?=$key->name?></option>
                      <?php else: ?>
                        <option value="<?=$key->id?>"><?=$key->name?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="kode_pos" class="col-sm-3 form-control-label">Kode Pos</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="<?=$customer->kode_pos?>" placeholder="Kode Pos">
                </div>
              </div>
              <div class="form-group row">
                <label for="alamat" class="col-sm-3 form-control-label">Alamat</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="alamat" name="alamat" rows="3"><?=$customer->alamat?></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="foto_ktp" class="col-sm-3 form-control-label">Foto KTP</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control-file" id="foto_ktp" name="foto_ktp" />
                </div>
              </div>
              <div class="form-group row">
                <label for="foto_kk" class="col-sm-3 form-control-label">Foto KK</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control-file" id="foto_kk" name="foto_kk" />
                </div>
              </div>
              <div class="form-group row">
                <label for="foto_paspor" class="col-sm-3 form-control-label">Foto Paspor</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control-file" id="foto_paspor" name="foto_paspor" />
                </div>
              </div>
              <div class="form-group row">
                <label for="foto_paspor" class="col-sm-3 form-control-label"></label>
                <div class="col-sm-9">
                  <div class="user-profile-friends" style="min-height: 0">
                    <?php if ($customer->foto_ktp != ""): ?>
                      <a href="<?=static_file()?>uploads/<?=$customer->foto_ktp?>" class="photo-link" style="width: 30%">
                        <img src="<?=static_file()?>uploads/<?=$customer->foto_ktp?>" alt="Foto KTP">
                      </a>
                    <?php endif; ?>
                    <?php if ($customer->foto_kk != ""): ?>
                      <a href="<?=static_file()?>uploads/<?=$customer->foto_kk?>" class="photo-link" style="width: 30%">
                        <img src="<?=static_file()?>uploads/<?=$customer->foto_kk?>" alt="Foto Kartu Keluarga">
                      </a>
                    <?php endif; ?>
                    <?php if ($customer->foto_paspor != ""): ?>
                      <a href="<?=static_file()?>uploads/<?=$customer->foto_paspor?>" class="photo-link" style="width: 30%">
                        <img src="<?=static_file()?>uploads/<?=$customer->foto_paspor?>" alt="Foto Paspor">
                      </a>
                    <?php endif; ?>
                    <div class="clearfix"></div>
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
<?php endif; ?>
