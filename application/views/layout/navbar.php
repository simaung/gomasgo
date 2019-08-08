<nav class="navbar navbar-light bg-white navbar-full navbar-fixed-top ls-left-sidebar">

  <!-- Sidebar toggle -->
  <button class="navbar-toggler pull-xs-left hidden-lg-up" type="button" data-toggle="sidebar" data-target="#sidebarLeft"><span class="material-icons">menu</span></button>

  <!-- Brand -->
  <a class="navbar-brand first-child-md" href="#">Gomasgo Umrah</a>

  <!-- Menu -->
  <?php if($_SESSION['role']=="user"): ?>
  <ul class="nav navbar-nav pull-xs-right">
    <!-- User dropdown -->
    <li class="nav-item">
    	<a href="#" class="btn btn-secondary btn-rounded-deep" data-toggle="modal" data-target="#share_modal">
        <i class="material-icons">share</i> bagikan
      </a>
 	</li>
    <!-- // END User dropdown -->

  </ul>
<?php endif; ?>
  <!-- // END Menu -->

</nav>
