<script src="<?=static_file()?>assets/vendor/jquery.min.js"></script>
<script src="<?=static_file()?>assets/vendor/tether.min.js"></script>
<script src="<?=static_file()?>assets/vendor/bootstrap.min.js"></script>
<script src="<?=static_file()?>assets/vendor/adminplus.js"></script>
<script src="<?=static_file()?>assets/js/main.min.js"></script>
<script src="<?=static_file()?>assets/js/colors.js"></script>
<script src="<?=static_file()?>assets/js/jquery.number.min.js"></script>
<script src="<?=static_file()?>assets/vendor/raphael-min.js"></script>
<script src="<?=static_file()?>assets/vendor/morris.min.js"></script>
<script src="<?=static_file()?>examples/js/chart.js"></script>
<script src="<?=static_file()?>assets/vendor/bootstrap-datepicker.min.js"></script>
<script src="<?=static_file()?>examples/js/date-time.js"></script>
<script src="<?=static_file()?>light-gallery/js/lightgallery-all.min.js"></script>
<script src="<?=static_file()?>assets/vendor/sweetalert.js"></script>
<script src="<?=static_file()?>jquery-ui-1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<?php if (isset($js_file)): ?>
  <?php foreach ($js_file as $key): ?>
    <script src="<?=static_file()?><?=$key?>"></script>
  <?php endforeach; ?>
<?php endif; ?>
