<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Home</a></li>
  <li><a href="<?=base_url()?>paket">Paket Umroh</a></li>
  <li class="active">Data</li>
</ol>

	<div class="card">
    	<div class="card-header">
          <div class="media">
            <div class="media-body media-middle">
              <h6 class="card-title m-b-0"><i class="sidebar-menu-icon material-icons">insert_drive_file</i> Paket Umroh</h6>
            </div>
            <div class="media-right media-middle">
              <a href="<?=base_url()?>paket/tambah" class="btn btn-white">
                <i class="material-icons">add</i> <span class="icon-text">Paket Umroh Baru</span>
              </a>
            </div>
          </div>
        </div>
        <table id="DataPaket" class="table table-striped table-hover table-sm">
          <thead>
            <tr>
	            <th>Nama Paket</th>
              <th>Harga</th>
              <th>Harga Cabang</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
        <div class="clearfix"></div>
      </div>
