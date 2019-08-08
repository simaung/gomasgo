<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>home">Home</a></li>
  <li><a href="<?=base_url()?>staff">Pengaturan Akun Staff</a></li>
  <li class="active">Data</li>
</ol>

<div class="card">
  <div class="card-header">
    <div class="media">
      <div class="media-body media-middle">
        <h6 class="card-title m-b-0"><i class="material-icons">account_circle</i> Data Akun Staff</h6>
      </div>
      <div class="media-right media-middle">
        <a href="<?=base_url()?>staff/tambah" class="btn btn-white">
          <i class="material-icons">add</i> <span class="icon-text">Staff Baru</span>
        </a>
      </div>
    </div>
  </div>
    <table id="DataStaff" class="table table-striped table-hover table-sm">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>HP</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
    <div class="clearfix"></div>
</div>
