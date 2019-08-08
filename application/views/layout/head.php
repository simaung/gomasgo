<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="base_url" content="<?=base_url()?>">
<?php
if(isset($meta)):
	foreach($meta as  $key=>$value):
		echo '<meta name="'.$key.'" content="'.$value.'">';
	endforeach;
endif;
?>

<title>Gomasgo Umrah</title>
<meta name="robots" content="noindex">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet">
<link type="text/css" href="<?=static_file()?>assets/css/style.min.css" rel="stylesheet">
<link type="text/css" href="<?=static_file()?>jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet">
<link type="text/css" href="<?=static_file()?>jquery-ui-1.12.1/jquery-ui.structure.min.css" rel="stylesheet">
<link type="text/css" href="<?=static_file()?>jquery-ui-1.12.1/jquery-ui.theme.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?=static_file()?>light-gallery/css/lightgallery.min.css">
<link rel="stylesheet" href="<?=static_file()?>examples/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?=static_file()?>assets/css/datatables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/fontawesome/4.5.0/css/font-awesome.min.css">
