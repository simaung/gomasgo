<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Dashboard</a></li>
  <li class="active">Profile</li>
</ol>


<?php if (isset($_SESSION['success'])): ?>
  <span class="profile_status" data-message="<?=$_SESSION['success']?>">
<?php endif; ?>

<!-- Row -->
<div class="row">

  <!-- Column -->
  <div class="col-md-3 m-b-1">
    <div class="card-primary">
      <div class="card-block" align="right">
        <center id="lightgallery">
          <?php if ($_SESSION['foto'] != ""): ?>
            <a href="<?=static_file()?>uploads/<?=$_SESSION['foto']?>">
              <img src="<?=static_file()?>uploads/<?=$_SESSION['foto']?>" alt="Foto <?=$user->nama?>" class="img-circle">
            </a>
          <?php else: ?>
            <a href="<?=static_file()?>img/dummy-profile.jpg">
              <img src="<?=static_file()?>img/dummy-profile.jpg" alt="Foto Profile Belum Diset" class="img-circle" style="max-height: 150px">
            </a>
          <?php endif; ?>
        </center>
      <button type="button" class="btn btn-secondary btn-rounded"><i class="material-icons">wallpaper</i></button>
      </div>
    </div>
    <div class="card">

        <ul class="list-group list-group-fit m-b-0">
          <li class="list-group-item">
            <div class="media">
              <div class="media-body media-middle">
                <b>Kode User</b>
              </div>
              <div class="media-right media-middle">
                <div class="center"><?=$user->kode_user?></div>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <div class="media">
              <div class="media-body media-middle">
                <b>Referal</b>
              </div>
              <div class="media-right media-middle">
                <div class="center"><?=$user->referal?></div>
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <div class="media">
              <center><a href="#" data-toggle="modal" data-target="#share_modal"><i class="material-icons">share</i> Bagikan Referal</a></center>
            </div>
          </li>
        </ul>

    </div>
  </div>
  <!-- // END Column -->

  <!-- Column -->
  <div class="col-md-9">

    <div class="card">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" href="#first" data-toggle="tab"><i class="material-icons">perm_identity</i> Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#second" data-toggle="tab"><i class="material-icons">playlist_add_check</i> Persyaratan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#third" data-toggle="tab"><i class="material-icons">vpn_key</i> Password</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#four" data-toggle="tab"><i class="material-icons">payment</i> Akun Bank</a>
          </li>
        </ul>
        <div class="card-block tab-content">
          <div class="tab-pane active" id="first">
          <form id="form_profile" method="post" action="<?=base_url()?>profile/update">
            <input type="hidden" name="section" value="profile">
            <div class="form-group row">
              <label for="nama" class="col-sm-3 form-control-label">Nama Lengkap</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nama" name="nama" value="<?=$user->nama?>" placeholder="Nama Lengkap">
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-3 form-control-label">Email</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="email" name="email" value="<?=$user->email?>" placeholder="Alamat Email">
              </div>
            </div>
            <div class="form-group row">
              <label for="hp" class="col-sm-3 form-control-label">Handphone</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="hp" name="hp" value="<?=$user->hp?>" placeholder="No Handphone">
              </div>
            </div>
            <div class="form-group row">
              <label for="id_card" class="col-sm-3 form-control-label">Kartu Identitas</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="id_card" name="id_card" value="<?=$user->id_card?>" placeholder="No Kartu Identitas (KTP/SIM)">
              </div>
            </div>
            <div class="form-group row">
              <label for="tgl_lahir" class="col-sm-3 form-control-label">Tanggal Lahir</label>
              <div class="col-sm-9">
                <input type="text" class="datepicker form-control" id="tgl_lahir" name="tgl_lahir" value="<?=to_human_date($user->tgl_lahir)?>" placeholder="Tanggal Lahir">
              </div>
            </div>
            <div class="form-group row">
              <label for="provinsi" class="col-sm-3 form-control-label">Provinsi</label>
              <div class="col-sm-9">
                <select class="form-control select2" id="provinsi" name="provinsi">
                  <option value="">-- Pilih Provinsi --</option>
                  <?php foreach ($provinsi as $key ): ?>
                    <?php if ($key->id == $user->id_provinsi): ?>
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
                    <?php if ($key->id == $user->id_kota): ?>
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
                <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="<?=$user->kode_pos?>" placeholder="Kode Pos">
              </div>
            </div>
            <div class="form-group row">
              <label for="alamat" class="col-sm-3 form-control-label">Alamat</label>
              <div class="col-sm-9">
                <textarea class="form-control" id="alamat" name="alamat" rows="3"><?=$user->alamat?></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-primary">
                  <span>Simpan</span>
                </button>
              </div>
            </div>
          </form>
          </div>
          <div class="tab-pane" id="second">
          <form id="form_persyaratan" method="post" action="<?=base_url()?>profile/update" enctype="multipart/form-data">
            <input type="hidden" name="section" value="persyaratan">
            <div class="form-group row">
                <label for="foto_paspor" class="col-sm-3 form-control-label"></label>
                <div class="col-sm-9">
                  <div class="user-profile-friends" style="min-height: 0">
                    <?php if ($user->foto_ktp != ""): ?>
                      <a href="<?=static_file()?>uploads/<?=$user->foto_ktp?>" class="photo-link" style="width: 30%">
                        <img src="<?=static_file()?>uploads/<?=$user->foto_ktp?>" alt="Foto KTP">
                      </a>
                    <?php endif; ?>
                    <?php if ($user->foto_kk != ""): ?>
                      <a href="<?=static_file()?>uploads/<?=$user->foto_kk?>" class="photo-link" style="width: 30%">
                        <img src="<?=static_file()?>uploads/<?=$user->foto_kk?>" alt="Foto Kartu Keluarga">
                      </a>
                    <?php endif; ?>
                    <?php if ($user->foto_paspor != ""): ?>
                      <a href="<?=static_file()?>uploads/<?=$user->foto_paspor?>" class="photo-link" style="width: 30%">
                        <img src="<?=static_file()?>uploads/<?=$user->foto_paspor?>" alt="Foto Paspor">
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <div class="form-group row">
              <label for="foto_profile" class="col-sm-3 form-control-label">Pas Foto</label>
              <div class="col-sm-9">
                <input type="file" class="form-control-file" id="foto_profile" name="foto_profile" />
                <small class="text-help"></small>
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
              <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-primary" id="tombol_profile">
                  <i id="loading" class="fa fa-spinner fa-spin" style="font-size:24px; display: none"></i>
                  <span id="wait">Simpan</span>
                </button>
              </div>
            </div>
          </form>
          </div>
          <div class="tab-pane" id="third">
          	<form id="form_password" method="post" action="<?=base_url()?>profile/update">
              <input type="hidden" name="section" value="password" />
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
                <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" class="btn btn-primary">
                    <span>Simpan</span>
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="four">
            <form id="form_akun_bank" method="post" action="<?=base_url()?>profile/update">
              <input type="hidden" name="section" value="akun_bank" />
              <div class="form-group row">
                <label for="nama_bank" class="col-sm-3 form-control-label">Bank</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nama_bank" name="nama_bank" value="<?php if(isset($bank[0]->nama_bank)) echo $bank[0]->nama_bank?>" placeholder="Nama Bank">
                </div>
              </div>
              <div class="form-group row">
                <label for="cabang" class="col-sm-3 form-control-label">Cabang</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="cabang" name="cabang" value="<?php if(isset($bank[0]->cabang)) echo $bank[0]->cabang?>" placeholder="Cabang Bank">
                </div>
              </div>
              <div class="form-group row">
                <label for="nama_pemilik" class="col-sm-3 form-control-label">Nama Pemilik</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" value="<?php if(isset($bank[0]->nama_pemilik)) echo $bank[0]->nama_pemilik?>" placeholder="Nama Pemilik Akun Rekening">
                </div>
              </div>
              <div class="form-group row">
                <label for="no_rekening" class="col-sm-3 form-control-label">No Rekening</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="<?php if(isset($bank[0]->no_rekening)) echo $bank[0]->no_rekening?>" placeholder="No Rekening Bank">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" class="btn btn-primary">
                    <span>Simpan</span>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>

  </div>
  <!-- // END Column -->

</div>
<!-- // END Row -->
