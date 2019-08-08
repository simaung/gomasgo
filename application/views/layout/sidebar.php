<div class="sidebar sidebar-left si-si-3 sidebar-visible-md-up sidebar-dark bg-primary" id="sidebarLeft" data-scrollable>
  <!-- Brand -->
  <a href="#" class="sidebar-brand">
    <img src="<?=static_file()?>/img/logo2.png" style="margin-bottom:10px">
  </a>

  <!-- User -->
  <a href="#" class="sidebar-link sidebar-user">
    <?php if ($_SESSION['foto'] != ""): ?>
      <img src="<?=static_file()?>uploads/<?=$_SESSION['foto']?>" alt="user" class="img-circle">
    <?php else: ?>
      <img src="<?=static_file()?>img/dummy-profile.jpg" alt="user" class="img-circle">
    <?php endif; ?>
    <?=ucfirst($_SESSION['nama'])?> (<?=ucfirst($_SESSION['kode_user'])?>)
  </a>
  <!-- // END User -->

  <!-- Menu -->

  <ul class="sidebar-menu sm-bordered sm-active-button-bg">

	<?php if($_SESSION['role']=="user"): ?>
    <li class="sidebar-menu-item <?=isset($sidebar['home'])?$sidebar['home']:''?>">
      <a class="sidebar-menu-button" href="<?=base_url()?>home">
        <i class="sidebar-menu-icon material-icons">home</i> Dashboard
      </a>
    </li>
    <li class="sidebar-menu-item <?=isset($sidebar['jamaah'])?$sidebar['jamaah']:''?>">
      <a class="sidebar-menu-button" href="<?=base_url()?>jamaah">
        <i class="sidebar-menu-icon material-icons">nature_people</i> Data Jamaah
      </a>
    </li>
    <?php if($_SESSION['cust_type']=="marketing"): ?>
    <li class="sidebar-menu-item <?=isset($sidebar['marketing'])?$sidebar['marketing']:''?>">
      <a class="sidebar-menu-button" href="<?=base_url()?>marketing">
        <i class="sidebar-menu-icon material-icons">supervisor_account</i> Data Marketing
      </a>
    </li>
  <?php endif; ?>
    <li class="sidebar-menu-item <?=isset($sidebar['profile'])?$sidebar['profile']:''?>">
      <a class="sidebar-menu-button" href="<?=base_url()?>profile">
        <i class="sidebar-menu-icon material-icons">perm_contact_calendar</i> <span>User Profile</span>
      </a>
    </li>
  <?php elseif($_SESSION['role']=="cabang"): ?>
    <li class="sidebar-menu-item <?=isset($sidebar['jamaah'])?$sidebar['jamaah']:''?>">
      <a class="sidebar-menu-button" href="<?=base_url()?>jamaah">
        <i class="sidebar-menu-icon material-icons">nature_people</i> Data Jamaah
      </a>
    </li>
    <li class="sidebar-menu-item <?=isset($sidebar['profile'])?$sidebar['profile']:''?>">
      <a class="sidebar-menu-button" href="<?=base_url()?>profile">
        <i class="sidebar-menu-icon material-icons">perm_contact_calendar</i> <span>User Profile</span>
      </a>
    </li>
	<?php elseif($_SESSION['role']=="staff"): ?>
    <li class="sidebar-menu-item <?=isset($sidebar['jamaah'])?$sidebar['jamaah']:''?>">
      <a class="sidebar-menu-button" href="<?=base_url()?>jamaah">
        <i class="sidebar-menu-icon material-icons">nature_people</i> Data Jamaah
      </a>
    </li>
    <li class="sidebar-menu-item <?=isset($sidebar['marketing'])?$sidebar['marketing']:''?>">
      <a class="sidebar-menu-button" href="<?=base_url()?>marketing">
        <i class="sidebar-menu-icon material-icons">supervisor_account</i> Data Marketing
      </a>
    </li>
    <li class="sidebar-menu-item <?=isset($sidebar['cabang'])?$sidebar['cabang']:''?>">
      <a class="sidebar-menu-button" href="<?=base_url()?>staff/cabang">
        <i class="sidebar-menu-icon material-icons">store</i> Data Cabang
      </a>
    </li>
    <li class="sidebar-menu-item <?=(isset($sidebar['paket']) || isset($sidebar['transasksi']))? 'open':''?>">
        <a class="sidebar-menu-button" href="#">
          <i class="sidebar-menu-icon material-icons">library_books</i> Data Umrah
        </a>
        <ul class="sidebar-submenu">
          <li class="sidebar-menu-item <?=isset($sidebar['paket'])?$sidebar['paket']:''?>">
            <a class="sidebar-menu-button" href="<?=base_url()?>paket">Paket Umrah</a>
          </li>
          <li class="sidebar-menu-item <?=isset($sidebar['transaksi'])?$sidebar['transaksi']:''?>">
            <a class="sidebar-menu-button" href="<?=base_url()?>transaksi">Transaksi Pembayaran</a>
          </li>
        </ul>
    </li>
    <li class="sidebar-menu-item <?=(isset($sidebar['laporan']) || isset($sidebar['laporan']))? 'open':''?>"">
        <a class="sidebar-menu-button" href="#">
          <i class="sidebar-menu-icon material-icons">pie_chart</i> Data & Laporan
        </a>
        <ul class="sidebar-submenu">
          <li class="sidebar-menu-item">
            <a class="sidebar-menu-button" href="<?=base_url()?>laporan/komisi">Bonus Sponsor/Closing</a>
          </li>
          <li class="sidebar-menu-item">
            <a class="sidebar-menu-button" href="<?=base_url()?>laporan/sales">Bonus Sales Poin</a>
          </li>
          <li class="sidebar-menu-item">
            <a class="sidebar-menu-button" href="<?=base_url()?>laporan/pelunasan">Bonus Poin Pelunasan</a>
          </li>
        </ul>
    </li>
    <li class="sidebar-menu-item <?=(isset($sidebar['staff']) || isset($sidebar['setting']))? 'open':''?>">
        <a class="sidebar-menu-button" href="#">
          <i class="sidebar-menu-icon material-icons">settings_input_composite</i> Pengaturan
        </a>
        <ul class="sidebar-submenu">
          <li class="sidebar-menu-item">
            <a class="sidebar-menu-button" href="<?=base_url()?>setting">Sistem Setting</a>
          </li>
          <li class="sidebar-menu-item <?=isset($sidebar['staff'])?$sidebar['staff']:''?>">
            <a class="sidebar-menu-button" href="<?=base_url()?>staff">Akun Staff</a>
          </li>
        </ul>
    </li>
    <?php endif; ?>
    <li class="sidebar-menu-item">
      <a class="sidebar-menu-button" href="<?=base_url()?>auth/logout">
        <i class="sidebar-menu-icon material-icons">exit_to_app</i> <span>Logout</span>
      </a>
    </li>

  </ul>
  <!-- // END Menu -->

<?php if($_SESSION['role']=="user" && $_SESSION['cust_type']=="marketing"): ?>
  <!-- Stats -->
  <div class="sidebar-stats">
    <a href="<?=base_url()?>transaksi/sales_poin">
    <div class="sidebar-stats-lead text-primary">
      <span><?=$_SESSION['poin_sponsor']?></span>
      <small class="text-success">
        <span class="icon-text">poin</span>
      </small>
    </div>
    <small>TOTAL SALES POIN</small>
    </a>
  </div>
  <!-- // END Stats -->

  <!-- Stats -->
  <div class="sidebar-stats">
    <div class="sidebar-stats-lead text-primary">
      <span><?=$_SESSION['poin_pelunasan']?></span>
      <small class="text-success">
        <span class="icon-text">poin</span>
      </small>
    </div>
    <small>TOTAL POIN PELUNASAN</small>
  </div>
  <!-- // END Stats -->
<?php endif; ?>

</div>
