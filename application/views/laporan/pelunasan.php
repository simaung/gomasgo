<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Home</a></li>
  <li><a href="#">Laporan</a></li>
  <li class="active">Data Poin Pelunasan</li>
</ol>

<div class="card">
  <div class="card-header">
    <div class="media">
      <div class="media-body media-middle">
        <h6 class="card-title m-b-0"><i class="material-icons">payment</i> Data Poin Pelunasan</h6>
      </div>
      <div class="media-right media-middle">
        <a href="<?=base_url('laporan/export_pelunasan')?>" class="btn btn-white">
          <i class="material-icons">print</i>
        </a>
      </div>
    </div>
  </div>
    <table id="DataBonusPelunasan" class="table table-striped table-hover table-sm">
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
