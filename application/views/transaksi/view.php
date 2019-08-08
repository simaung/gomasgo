<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Home</a></li>
  <li><a href="<?=base_url()?>transaksi">Transaksi</a></li>
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
            <a class="nav-link active" href="#first" data-toggle="tab"><i class="material-icons">perm_identity</i> Detail Transaksi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#second" data-toggle="tab"><i class="material-icons">playlist_add_check</i> Persyaratan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#third" data-toggle="tab"><i class="material-icons">redeem</i> Pembayaran</a>
          </li>
          <?php if($_SESSION['role']=="staff"): ?>
          <li class="nav-item">
            <a class="nav-link" href="#four" data-toggle="tab"><i class="material-icons">compare_arrows</i> Distribusi Bonus</a>
          </li>
          <?php endif; ?>
        </ul>
        <div class="card-block tab-content">
          <div class="tab-pane active" id="first">
            <div class="row">
			        <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Info Transaksi</h4>
                  </div>
                  <div class="card-block">
                    <form>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 form-control-label"><b>Id Transaksi</b></label>
                        <div class="col-sm-9"><?=$trx[0]->id_trx?></div>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-sm-3 form-control-label"><b>Tgl Transaksi</b></label>
                        <div class="col-sm-9"><?=$trx[0]->trx_date?></div>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-sm-3 form-control-label"><b>Nama Paket</b></label>
                        <div class="col-sm-9"><?=$trx[0]->nama_paket?></div>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-sm-3 form-control-label"><b>Harga</b></label>
                        <div class="col-sm-9"><?=int_to_rupiah($trx[0]->harga)?></div>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-sm-3 form-control-label"><b>Marketing</b></label>
                        <div class="col-sm-9"><?=$trx[0]->marketing?> (<?=$trx[0]->kode_marketing?>)</div>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-sm-3 form-control-label"><b>Presenter</b></label>
                        <div class="col-sm-9"><?=$trx[0]->presenter?> (<?=$trx[0]->kode_presenter?>)</div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Info Jamaah</h4>
                  </div>
                  <div class="card-block">
                    <form>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 form-control-label"><b>Nama</b></label>
                        <div class="col-sm-9"><?=$trx[0]->nama_lengkap?></div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 form-control-label"><b>Email</b></label>
                        <div class="col-sm-9"><?=$trx[0]->email?></div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 form-control-label"><b>No HP</b></label>
                        <div class="col-sm-9"><?=$trx[0]->hp?></div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 form-control-label"><b>No KTP</b></label>
                        <div class="col-sm-9"><?=$trx[0]->id_card?></div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 form-control-label"><b>Tgl Lahir</b></label>
                        <div class="col-sm-9"><?=$trx[0]->tgl_lahir?></div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 form-control-label"><b>Provinsi</b></label>
                        <div class="col-sm-9"><?=$trx[0]->provinsi?></div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 form-control-label"><b>Kota</b></label>
                        <div class="col-sm-9"><?=$trx[0]->kota?></div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 form-control-label"><b>Alamat</b></label>
                        <div class="col-sm-9"><?=$trx[0]->alamat?></div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 form-control-label"><b>Kodepos</b></label>
                        <div class="col-sm-9"><?=$trx[0]->kode_pos?></div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="second">
            <form>
          	   <div class="form-group row">
                <label for="foto_paspor" class="col-sm-3 form-control-label"></label>
                <div class="col-sm-9">
                  <div class="user-profile-friends" style="min-height: 0">
                    <?php if ($trx[0]->foto_ktp != ""): ?>
                      <a href="<?=static_file()?>uploads/<?=$trx[0]->foto_ktp?>" class="photo-link" style="width: 30%">
                        <img src="<?=static_file()?>uploads/<?=$trx[0]->foto_ktp?>" alt="Foto KTP">
                      </a>
                    <?php endif; ?>
                    <?php if ($trx[0]->foto_kk != ""): ?>
                      <a href="<?=static_file()?>uploads/<?=$trx[0]->foto_kk?>" class="photo-link" style="width: 30%">
                        <img src="<?=static_file()?>uploads/<?=$trx[0]->foto_kk?>" alt="Foto Kartu Keluarga">
                      </a>
                    <?php endif; ?>
                    <?php if ($trx[0]->foto_paspor != ""): ?>
                      <a href="<?=static_file()?>uploads/<?=$trx[0]->foto_paspor?>" class="photo-link" style="width: 30%">
                        <img src="<?=static_file()?>uploads/<?=$trx[0]->foto_paspor?>" alt="Foto Paspor">
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
          	</form>
          </div>
          <div class="tab-pane" id="third">
            <p>Nama Paket : <b><?=$trx[0]->nama_paket?></b></p>
            <table id="DataTrxPembayaran" class="table table-striped table-hover" style="width: 100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Nominal</th>
                  <th>Via</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
              <?php $no=1; $tBayar=0; foreach($pembayaran as $p): ?>
              	<tr>
                  <td><?=$no?></td>
                  <td><?=$p->tgl_pembayaran?></td>
                  <td><?=int_to_rupiah($p->nominal)?></td>
                  <td><?=$p->jenis_pembayaran?></td>
                  <td><?=strtoupper($p->jenis_trx)?></td>
                </tr>
			        <?php $no++; $tBayar=$tBayar+$p->nominal; endforeach; ?>
              </tbody>
              <tfoot>
              	<tr align="right">
                	<td colspan="4"><b>Harga</b></td>
                    <td><?=int_to_rupiah($trx[0]->harga)?></td>
                </tr>
              	<tr align="right">
                	<td colspan="4"><b>Total Bayar</b></td>
                    <td><?=int_to_rupiah($tBayar)?></td>
                </tr>
              	<tr align="right">
                	<td colspan="4"><b>Belum dibayar</b></td>
                    <td><b><?=int_to_rupiah(($trx[0]->harga-$tBayar))?></b></td>
                </tr>
              </tfoot>
            </table>
            <!-- Pake POPUP-->
            <?php if ($tBayar < $trx[0]->harga): ?>
              <div align="right">
              	<a href="#" class="btn btn-primary" onclick="show_modal_pembayaran('<?=$trx[0]->id_trx?>')">
                		<i class="material-icons">redeem</i> <span class="icon-text">Pembayaran Baru</span>
              	</a>
            	</div>
            <?php endif; ?>
          </div>
          <?php if($_SESSION['role']=="staff"): ?>
          <div class="tab-pane" id="four">
            <p>Nama Paket : <b><?=$trx[0]->nama_paket?></b></p>
            <table id="DataBonus" class="table table-striped table-hover" style="width: 100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Bonus</th>
                  <th>User</th>
                  <th>Nilai</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; foreach($bonus as $b): ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?=$b->tgl?></td>
                    <td><?=$b->tipe?></td>
                    <td><?=$b->user_id?></td>
                    <td><?=$b->nilai?></td>
                    <td><?=$b->keterangan?></td>
                  </tr>
                <?php $no++; endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php endif; ?>
      	</div>
      </div>
    </div>
    <!-- // END Column -->
  </div>
  <!-- // END Row -->
<?php endif; ?>
