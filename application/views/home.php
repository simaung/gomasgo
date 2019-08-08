<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="index.html">Home</a></li>
  <li class="active">Dashboard</li>
</ol>

<?php if(isset($profile)):?>
    <div class="row">
      <div class="card card-stats-danger">
        <div class="card-block">
          <div class="media">
            <div class="media-left media-middle">
              <i class="material-icons text-muted-light text-danger">info_outline</i>
            </div>
            <div class="media-body media-middle">
              <strong class="text-danger">Profil anda belum lengkap!!</strong> mohon lengkapi Informasi profil anda.
            </div>
            <div class="media-right">
              <a class="btn btn-danger btn-sm" href="<?=base_url()?>profile">
                edit
                </a>
            </div>
          </div>
        </div>
      </div>
      <!-- // END Column -->
    </div>
    <!-- // END Row -->
<?php endif; ?>

<!-- Row -->
<div class="row">

  <!-- Column -->
  <div class="col-md-6 m-b-1">
    <div class="card-primary">
      <div class="card-block">
        <i class="material-icons pull-xs-right md-48">redeem</i>
        <h5 class="m-b-0"><?=int_to_rupiah($_SESSION['komisi']);?></h5>
        <p class="m-a-0">Saldo Bonus</p>
        <center><small class="text-warning">Saldo bonus akan dicairkan setiap minggu pada hari senin.</small></center>
      </div>
    </div>
  </div>
  <!-- // END Column -->

  <!-- Column -->
  <div class="col-md-6">
    <div class="card-info">
      <div class="card-block">
        <p class="pull-xs-right"><?=int_to_rupiah($bayar[0]->harga)?></p>
        <h6 class="m-b-1"><i class="material-icons">payment</i> <span class="icon-text">Pembayaran Umrah</span></h6>
        <?php
          $persen = ($bayar[0]->dibayar/$bayar[0]->harga)*100;
        ?>
        <progress class="progress progress-animated progress-danger m-a-0" value="<?=number_format($persen, 0, '.', '')?>" max="100"></progress>
        <center><small><?=int_to_rupiah($bayar[0]->dibayar)?></small></center>
      </div>
    </div>
  </div>
  <!-- // END Column -->

</div>
<!-- // END Row -->
<?php if($_SESSION['cust_type']=="marketing"): ?>
    <!-- Row -->
    <div class="row">

      <!-- Column -->
      <div class="col-md-6"> 

        <div class="card">
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link active" id="history-tab" data-toggle="tab" href="#history">
                <i class="material-icons">schedule</i> <span class="icon-text">Notifikasi sistem</span>
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade in active" id="history">
              <ul class="list-group list-group-fit">
                <li class="list-group-item">
                  <div class="media">
                    <div class="media-left media-middle">
                      <i class="material-icons md-36 text-muted">receipt</i>
                    </div>
                    <div class="media-body">
                      <p class="m-a-0">
                        <a href="#">Sam</a> added a new invoice <a href="#">#9591</a>
                      </p>
                      <small class="text-muted">
                        <i class="material-icons md-18">timer</i> <span class="icon-text">5 hrs ago</span>
                      </small>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="media">
                    <div class="media-left media-middle">
                      <i class="material-icons md-36 text-muted">dns</i>
                    </div>
                    <div class="media-body">
                      <p class="m-a-0">
                        <a href="#">John</a> created a new <a href="#">task</a>
                      </p>
                      <small class="text-muted">
                        <i class="material-icons md-18">today</i> <span class="icon-text">1 day ago</span>
                      </small>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="media">
                    <div class="media-left media-middle">
                      <i class="material-icons md-36 text-muted">group</i>
                    </div>
                    <div class="media-body">
                      <p class="m-a-0">
                        <a href="#">Partick</a> added <a href="#">Sam</a> are now friends.
                      </p>
                      <small class="text-muted">
                        <i class="material-icons md-18">today</i> <span class="icon-text">2 days ago</span>
                      </small>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- // END Column -->

      <!-- Column -->
      <div class="col-md-6">

        <div class="card-success">
          <div class="card-block">
            <p class="pull-xs-right"><?=$stat[0]->lunas?> dari <?=$stat[0]->total?></p>
            <h6 class="m-b-1"><i class="material-icons">trending_up</i> <span class="icon-text">Progres Pelunasan</span></h6>
            <?php if($stat[0]->total!=0): $persen = ($stat[0]->lunas/$stat[0]->total)*100; else: $persen=0; endif;?>
            <progress class="progress progress-animated progress-danger m-a-0" value="<?=$persen?>" max="100">50%
            </progress>
          </div>
        </div>

        <div class="card">
          <div class="card-header bg-white center">
            <p class="card-subtitle m-b-0"><b>Progres Pembayaran Jamaah</b></p>
          </div>
          <table class="table table-sm m-b-0">
          <?php foreach($jamaah as $j): ?>
            <tr>
              <td><i class="material-icons text-primary">nature_people</i> <span class="icon-text">
                <a href="<?=base_url()?>/jamaah/view/<?=$j->id_cust?>"><?=$j->nama_lengkap?></a></span></td>
              <td class="right">
                <div class="label label-success"><?=strtoupper($j->status)?></div>
              </td>
              <td class="right" width="1">
                <a href="<?=base_url()?>/jamaah/view/<?=$j->id_cust?>" class="btn btn-xs btn-white"><i class="material-icons md-18">chevron_right</i></a>
              </td>
            </tr>
          <?php endforeach; ?>
          </table>
        </div>
      </div>
      <!-- // END Column -->

    </div>
    <!-- // END Row -->
<?php endif; ?>
