<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Home</a></li>
  <li><a href="<?=base_url()?>marketing">Marketing</a></li>
  <li class="active">Detail Marketing</li>
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
    <div class="col-md-4">
    	<div class="card-primary">
          <div class="card-block" align="right">
            <center id="lightgallery">
              <?php if ($marketing[0]->foto != ""): ?>
                <a href="<?=static_file()?>uploads/<?=$marketing[0]->foto?>">
                  <img src="<?=static_file()?>uploads/<?=$marketing[0]->foto?>" alt="Foto <?=$marketing[0]->nama?>" class="img-circle">
                </a>
              <?php else: ?>
                <a href="<?=static_file()?>img/dummy-profile.jpg">
                  <img src="<?=static_file()?>img/dummy-profile.jpg" alt="Foto Profile Belum Diset" class="img-circle" style="max-height: 150px">
                </a>
              <?php endif; ?>
            </center>
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
                    <div class="center"><?=$marketing[0]->kode_user?></div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="media">
                  <div class="media-body media-middle">
                    <b>Nama</b>
                  </div>
                  <div class="media-right media-middle">
                    <div class="center"><?=$marketing[0]->nama?></div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="media">
                  <div class="media-body media-middle">
                    <b>Email</b>
                  </div>
                  <div class="media-right media-middle">
                    <div class="center"><?=$marketing[0]->email?></div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="media">
                  <div class="media-body media-middle">
                    <b>Handphone</b>
                  </div>
                  <div class="media-right media-middle">
                    <div class="center"><?=$marketing[0]->hp?></div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="media">
                  <div class="media-body media-middle">
                    <b>Saldo Bonus</b>
                  </div>
                  <div class="media-right media-middle">
                    <div class="center"><?=int_to_rupiah($marketing[0]->komisi)?></div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="media">
                  <div class="media-body media-middle">
                    <b>Poin Sponsor</b>
                  </div>
                  <div class="media-right media-middle">
                    <div class="center"><?=$marketing[0]->poin_sponsor?></div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="media">
                  <div class="media-body media-middle">
                    <b>Poin Pelunasan</b>
                  </div>
                  <div class="media-right media-middle">
                    <div class="center"><?=$marketing[0]->poin_pelunasan?></div>
                  </div>
                </div>
              </li>
            </ul>
    
        </div>
    </div>
    <div class="col-md-8">

      <div class="card">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" href="#first" data-toggle="tab"><i class="material-icons">supervisor_account</i>Daftar Marketing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#second" data-toggle="tab"><i class="material-icons">nature_people</i>Daftar Jamaah</a>
          </li>
        </ul>
        <div class="card-block tab-content">
          <div class="tab-pane active" id="first">
			       <table id="dMarketing" class="table table-striped table-hover table-sm">
              <thead>
                <tr>
                <th>Tgl Join</th>
                  <th>Kode User</th>
                  <th>Nama</th>
                  <th>Jaringan</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="tab-pane" id="second">
              <table id="dJamaah" class="table table-striped table-hover table-sm">
              <thead>
                <tr>
                <th>Tgl Transaksi</th>
                  <th>Nama Jamaah</th>
                  <th>Nama Paket</th>
                  <th>Status</th>
                </tr>
              </thead>
          </div>
      	</div>
        
      </div>

    </div>
    <!-- // END Column -->

  </div>
  <!-- // END Row -->
<?php endif; ?>

