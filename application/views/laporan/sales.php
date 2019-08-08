<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Home</a></li>
  <li><a href="#">Laporan</a></li>
  <li class="active">Data Bonus Sales Poin</li>
</ol>

<div class="card">
  <div class="card-header">
    <div class="media">
      <div class="media-body media-middle">
        <h6 class="card-title m-b-0"><i class="material-icons">payment</i> Data Bonus Sales Poin</h6>
      </div>
    </div>
  </div>
    <div class="m-t-1 m-r-1" align="right">
      <a href="<?=base_url('laporan/export_poin')?>" class="btn btn-white">
        <i class="material-icons">print</i>
      </a>
      <a href="<?=base_url('laporan/pencairan_sales_poin')?>" class="btn btn-warning">
        <i class="material-icons">touch_app</i> <span>Bayarkan</span>
      </a>
    </div>
    <table id="DataBonusSales" class="table table-striped table-hover table-sm">
      <thead>
        <tr>
          <th>Kode User</th>
          <th>Nama Lengkap</th>
          <th>Jumlah Poin</th>
        </tr>
      </thead>
    </table>
    <div class="clearfix"></div>
</div>
