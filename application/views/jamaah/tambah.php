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

<!-- Row -->
<div class="row">
  <!-- Column -->
  <div class="col-md-12">
    <div class="card">
      <div class="card-block">
        <h5>Form Pendaftaran Jamaah</h5><hr />
          <form id="form_jamaah" method="post" action="<?=base_url()?>jamaah/save" enctype="multipart/form-data">
            <div class="card">
              <div class="card-header">
                <i class="material-icons">perm_identity</i> Profile Jamaah
              </div>
              <div class="card-block">
                <div class="form-group row">
                  <label for="paket" class="col-sm-3 form-control-label">Paket</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="paket" name="paket">
                      <option value="">-- Pilih Paket Umrah--</option>
                      <?php foreach ($paket as $pk ): ?>
                        <?php if($_SESSION['role']=="cabang"): $harga = $pk->harga_cabang; else: $harga=$pk->harga; endif; ?>
                        <option value="<?=$pk->id_paket?>"><?=$pk->nama_paket?> (Rp <?=number_format($harga,0,'.','.')?>)</option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="referal" class="col-sm-3 form-control-label">Referal</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="referal" name="referal" value="<?=$_SESSION['kode_user']?>" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="presenter" class="col-sm-3 form-control-label">Presenter</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control text-uppercase" name="presenter" id="presenter" placeholder="KODE PRESENTER">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="nama" class="col-sm-3 form-control-label">Nama Lengkap</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-sm-3 form-control-label">Email</label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Alamat Email">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="hp" class="col-sm-3 form-control-label">Handphone</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="hp" name="hp" placeholder="No Handphone">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="id_card" class="col-sm-3 form-control-label">Kartu Identitas</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="id_card" name="id_card" placeholder="No Kartu Identitas (KTP/SIM)">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="tgl_lahir" class="col-sm-3 form-control-label">Tanggal Lahir</label>
                  <div class="col-sm-9">
                    <input type="text" class="datepicker form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal Lahir">
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <i class="material-icons">nature_people</i> Alamat Jamaah
              </div>
              <div class="card-block">
                <div class="form-group row">
                  <label for="provinsi" class="col-sm-3 form-control-label">Provinsi</label>
                  <div class="col-sm-9">
                    <select class="form-control select2" id="provinsi" name="provinsi">
                      <option value="">-- Pilih Provinsi --</option>
                      <?php foreach ($provinsi as $key ): ?>
                        <option value="<?=$key->id?>"><?=$key->name?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="kota" class="col-sm-3 form-control-label">Kota</label>
                  <div class="col-sm-9">
                    <select class="form-control select2" id="kota" name="kota">
                      <option value="">-- Pilih Kota --</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="kode_pos" class="col-sm-3 form-control-label">Kode Pos</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="kode_pos" name="kode_pos" placeholder="Kode Pos">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="alamat" class="col-sm-3 form-control-label">Alamat</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <i class="material-icons">playlist_add_check</i> Persyaratan
              </div>
              <div class="card-block">
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
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-offset-3 col-sm-9">
                <button type="button" class="btn btn-primary" id="tombol_simpan">
                  <i id="loading" class="fa fa-spinner fa-spin" style="font-size:24px; display: none"></i>
                  <span id="wait">Simpan</span>
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
