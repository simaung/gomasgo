<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Home</a></li>
  <li><a href="#">Laporan</a></li>
  <li class="active">Data Bonus Sponsor/Closing</li>
</ol>

<div class="card">
  <div class="card-header">
    <div class="media">
      <div class="media-body media-middle">
        <h6 class="card-title m-b-0"><i class="material-icons">payment</i> Data Bonus Sponsor/Closing</h6>
      </div>
    </div>
  </div>
    <div class="m-t-1 m-r-1" align="right">
      <a href="<?=base_url('laporan/export_closing')?>" class="btn btn-white">
        <i class="material-icons">print</i>
      </a>
      <a onclick="komisi()" class="btn btn-warning">
        <i class="material-icons">touch_app</i> <span>Bayarkan</span>
      </a>
    </div>
    <table id="DataBonusSponsor" class="table table-striped table-hover table-sm">
      <thead>
        <tr>
          <th>Kode User</th>
          <th>Nama Lengkap</th>
          <th>Nilai Bonus</th>
        </tr>
      </thead>
    </table>
    <div class="clearfix"></div>
</div>
