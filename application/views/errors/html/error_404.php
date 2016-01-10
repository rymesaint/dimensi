<?php
defined('BASEPATH') OR exit('No direct script access allowed');
function base_url(){
	return "http://localhost/dimensi/";
}
?><!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="description" content="Dimensi Anime">
  <meta name="author" content="@dimensi">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>404 Page Not Found</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">

  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/simple-line-icons.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/animate.min.css"/>
  <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
  <!-- end: Css -->

  <link rel="shortcut icon" href="<?php echo base_url() ?>assets/img/logomi.png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body id="mimin">
   
  <div class="col-md-12">

    <!-- start: Content -->
    <center>
      <div class="page-404 animated flipInX">
        <h1><?php echo $heading; ?></h1>
        <p><?php echo $message ?></p>
        <a href="<?php echo base_url() ?>"> Back To Home
          </br>
          <span class="icons icon-arrow-down"></span>
        </a>
      </div>
    </center>
    <!-- end: content -->
  </div>

<!-- start: Javascript -->
<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.ui.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>


<!-- plugins -->
<script src="<?php echo base_url() ?>assets/js/plugins/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/jquery.nicescroll.js"></script>


<!-- custom -->
<script src="<?php echo base_url() ?>assets/js/main.js"></script>
<script type="text/javascript">
</script>
<!-- end: Javascript -->
</body>
</html>