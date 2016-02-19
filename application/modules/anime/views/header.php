<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<?php
    echo meta('X-UA-Compatible', 'IE=edge', 'equiv');
    echo meta('viewport', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no') 
    ?>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
    <title><?php echo $title ?></title>
 <?php
		echo meta('description', $description);
		echo meta('keywords', $keywords);
		echo link_tag('assets/favicon.png', 'shortcut icon', 'image/png');
		echo link_tag('assets/css/bootstrap.min.css');
    echo link_tag('assets/css/dimensi.min.css');
	?>
	<?php

  $meta = array(
        array(
                'name' => 'robots',
                'content' => 'index, follow'
        ),
        array(
                'name' => 'author',
                'content' => 'Dimensi'
        ),
        array(
                'name' => 'googlebot',
                'content' => 'index,noodp,noarchive,follow'
        ),
        array(
                'name' => 'msnbot',
                'content' => 'index, follow'
        ),
        array(
                'name' => 'copyright',
                'content' => 'Copyright (c)'.date("Y").' '.$website.'. All Rights Reserved.'
        )
);
  echo meta($meta);

  $canonical = array(
          'href'  => current_url(),
          'rel'   => 'canonical'
  );
  echo link_tag($canonical);;
  ?>
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="<?php echo $title ?>" />
	<meta property="og:description" content="<?php echo $description ?>" />
	<meta property="og:url" content="<?php echo current_url() ?>" />
	<meta property="og:site_name" content="<?php echo $website ?>" />
	<script src="<?php echo base_url().'assets/js/jquery.min.js'; ?>"></script>
  <script src="<?php echo base_url().'assets/js/dimensi.min.js'; ?>"></script>
  <?php if(current_url() == base_url()): ?>
  <script src="<?php echo base_url().'assets/js/jquery.bxslider.min.js'; ?>"></script>
	<script>
		$(document).ready(function(){
		  $('.bxslider').bxSlider({
		  		auto: true,
		  		mode: 'fade',
		  		speed: 3000,
		  		randomStart: true,
		  		hideControlOnEnd: true,
		  		adaptiveHeight: false,
          captions: true
		  });
		});
	</script>
<?php endif; ?>
<script>
  $(document).scroll(function(e){
    var scrollTop = $(document).scrollTop();
    if(scrollTop > 80){
        $('.navbar').removeClass('navbar-static-top').addClass('navbar-fixed-top');
    } else {
        $('.navbar').removeClass('navbar-fixed-top').addClass('navbar-static-top');
    }
});
</script>
</head>
<body>
<header class="container">
  <nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url() ?>"><img src="<?php echo base_url().'assets/favicon.png' ?>" width="25" height="25" alt="Dimensi"></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home') ?>"><span class="ic ic-house"></span></a></li>
          <li><a href="<?php echo site_url('anime/browse/') ?>" title="<?php echo $this->lang->line('browse_anime') ?>"><span class="ic ic-list"></span></a></li>
          <li><a href="<?php echo site_url('genre/') ?>" title="<?php echo $this->lang->line('browse_genre') ?>"><span class="ic ic-tag"></span></a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="ic ic-sm-chevron-down"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#"><?php echo $this->lang->line('forum') ?></a></li>
              <li><a href="#">Hentai Anime</a></li>
              <li><a href="#"><?php echo $this->lang->line('about') ?></a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">DMCA Copyright</a></li>
              <li><a href="#"><?php echo $this->lang->line('privacy') ?></a></li>
              <li><a href="#"><?php echo $this->lang->line('tos') ?></a></li>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="ic ic-user"></span></a>
            <?php if($this->session->login == null): ?>
            <div class="dropdown-menu" style="padding:5px;width:275px;">
                <form class="form-horizontal formLogin" action="<?php echo site_url('user/auth/') ?>" method="POST">
  				<fieldset>
  				<div class="form-group">
  				  <div class="col-md-12">
  				  <input id="username" name="username" type="text" placeholder="Username" class="form-control input-md" required>
  				  </div>
  				</div>
  				<div class="form-group">
  				  <div class="col-md-12">
  				    <input id="password" name="password" type="password" placeholder="Password" class="form-control input-md" required>
  				  </div>
  				</div>
  				<div class="form-group">
  				  <div class="col-md-8">
  				  <div class="checkbox">
  				    <label for="cookie_login-0">
  				      <input type="checkbox" name="cookie_login" id="cookie_login-0" value="1">
  				      <?php echo $this->lang->line('remember_me') ?>
  				    </label>
  					</div>
  				  </div>
  				  <div class="col-md-4">
  				  <a href="<?php echo site_url('account/register/') ?>"><?php echo $this->lang->line('not_register') ?></a>
  				  </div>
  				</div>
  				<div class="form-group">
  				  <label class="col-md-4 control-label" for="btnLogin"></label>
  				  <div class="col-md-4">
  				    <button id="btnLogin" name="btnLogin" class="btn btn-info"><?php echo $this->lang->line('login') ?></button>
  				  </div>
  				</div>
  				</fieldset>
  				</form>
              </div>
            <?php else: ?>
              <ul class="dropdown-menu">
                <li><a href="#">Profil</a></li>
                <li><a href="#">Aktivitas</a></li>
                <li><a href="#">Favorit</a></li>
                <li class="divider"></li>
                <li><a href="#">Pengaturan</a></li>
                <li><a href="#">Keluar</a></li>
              </ul>
            <?php endif; ?>
          </li>
          <li><a href="#"><?php echo $this->lang->line('faq') ?></a></li>
        </ul>
        <form class="navbar-form navbar-right" action="<?php echo base_url().'search/get-keyword' ?>" method="POST" role="search">
          <div class="form-group">
            <input type="text" name="q" class="form-control input-sm" placeholder="<?php echo $this->lang->line('text_search') ?>">
          </div>
          <button type="submit" class="btn btn-sm btn-default"><?php echo $this->lang->line('btn_search') ?></button>
        </form>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
</header>
<div class="container">
