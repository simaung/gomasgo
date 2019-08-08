<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Home</a></li>
  <li><a href="<?=base_url()?>jamaah">Jamaah</a></li>
  <li class="active">Lihat Data</li>
</ol>

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
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" href="#first" data-toggle="tab"><i class="material-icons">perm_identity</i> Data Jamaah</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#second" data-toggle="tab"><i class="material-icons">playlist_add_check</i> Persyaratan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#third" data-toggle="tab"><i class="material-icons">redeem</i> Transaksi dan pembayaran</a>
          </li>
        </ul>
        <div class="card-block tab-content">
          <div class="tab-pane active" id="first">

          	<form>
              <div class="form-group row">
                <label for="nama" class="col-sm-3 form-control-label">Nama Lengkap</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nama" name="nama" value="<?=$customer->nama_lengkap?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-sm-3 form-control-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="email" name="email" value="<?=$customer->email?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="hp" class="col-sm-3 form-control-label">Handphone</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="hp" name="hp" value="<?=$customer->hp?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="id_card" class="col-sm-3 form-control-label">Kartu Identitas</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="id_card" name="id_card" value="<?=$customer->id_card?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="tgl_lahir" class="col-sm-3 form-control-label">Tanggal Lahir</label>
                <div class="col-sm-9">
                  <input type="text" class="datepicker form-control" id="tgl_lahir" name="tgl_lahir" value="<?=to_human_date($customer->tgl_lahir)?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="provinsi" class="col-sm-3 form-control-label">Provinsi</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="provinsi" name="provinsi" value="<?=$customer->nama_provinsi?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="kota" class="col-sm-3 form-control-label">Kota</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="provinsi" name="provinsi" value="<?=$customer->nama_kota?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="kode_pos" class="col-sm-3 form-control-label">Kode Pos</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="<?=$customer->kode_pos?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="alamat" class="col-sm-3 form-control-label">Alamat</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="alamat" name="alamat" rows="3" readonly><?=$customer->alamat?></textarea>
                </div>
              </div>
            </form>

          </div>
          <div class="tab-pane" id="second">

            <form>
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
                  </div>
                </div>
              </div>
          	</form>

          </div>
          <div class="tab-pane" id="third">

            <table id="DataTrxJamaah" class="table table-striped table-hover" style="width: 100%">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Jamaah</th>
                  <th>Paket</th>
                  <th>Harga</th>
                  <th>dibayar</th>
                  <th>Status</th>
                  <!--<th>Action</th>-->
                </tr>
              </thead>
            </table>

          </div>
      	</div>
      </div>

    </div>
    <!-- // END Column -->

  </div>
  <!-- // END Row -->
<?php endif; ?>
