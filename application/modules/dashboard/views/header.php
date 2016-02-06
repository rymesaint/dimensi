<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/materialize.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom.dashboard.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/datatables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/dataTables.custom.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/select2.min.css">

  <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/paging.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/select2.min.js"></script>
</head>
<body>
<header>
  <nav>
    <div class="nav-wrapper blue darken-1">
      <a href="<?php echo base_url() ?>" class="brand-logo" target="_BLANK"><?php echo $app_name ?></a>
      <ul class="right hide-on-med-and-down">
        <li>
          <a class="dropdown-button" href="#!" data-activates="menuaccount">
          <div class="chip">
        <img src="<?php echo base_url() ?>assets/img/avatar.jpg" alt="Contact Person">
        <?php echo $user->username ?>
      </div>
        </a>
      </li>
      </ul>
    </div>
    <ul id="menuaccount" class="dropdown-content blue darken-1">
    <li><a href="<?php echo site_url('dashboard/') ?>" class="shades-text white-text">Dashboard</a></li>
    <li><a href="<?php echo site_url('dashboard/users/profile/') ?>" class="shades-text white-text">Akun Saya</a></li>
    <li class="divider"></li>
    <li><a href="#" class="shades-text white-text">Pengaturan</a></li>
    <li class="divider"></li>
    <li><a href="<?php echo site_url('dashboard/users/logout/') ?>" class="shades-text white-text">Keluar</a></li>
  </ul>
  </nav>
</header>

<main>
<div class="row">
  <div class="col s12 m4 l3"> 
    <ul class="collapsible" data-collapsible="accordion">
      <li>
        <div class="collapsible-header waves-effect">
          <a href="<?php echo site_url('dashboard/') ?>"><i class="material-icons">dashboard</i>Dashboard</a>
        </div>
      </li>
      <li>
        <div class="collapsible-header waves-effect">
          <i class="material-icons">subject</i>Animes
        </div>
        <div class="collapsible-body">
          <ol class="blue accent-2">
            <li class="waves-effect"><a href="<?php echo site_url('dashboard/animes/set-featured') ?>" class="shades-text text-white">Set Slider Anime</a></li>
            <li class="waves-effect"><a href="<?php echo site_url('dashboard/animes/tambah_anime/') ?>" class="shades-text text-white">Tambah Anime</a></li>
            <li class="waves-effect"><a href="<?php echo site_url('dashboard/animes/tambah_episode/') ?>" class="shades-text text-white">Tambah Episode</a></li>
            <li class="divider"></li>
            <li class="waves-effect"><a href="<?php echo site_url('dashboard/animes/') ?>" class="shades-text text-white">Semua Anime</a></li>
          </ol>
        </div>
      </li>
      <li>
        <div class="collapsible-header waves-effect"><a href="<?php echo site_url('dashboard/genres/') ?>"><i class="material-icons">album</i>Genre</a></div>
      </li>
      <li>
        <div class="collapsible-header waves-effect"><i class="material-icons">perm_identity</i>Akun</div>
        <div class="collapsible-body">
          <ol class="blue accent-2">
            <li class="waves-effect"><a href="#" class="shades-text text-white">Tambah Akun Baru</a></li>
            <li class="waves-effect"><a href="#" class="shades-text text-white">Tambah Grup Baru</a></li>
            <li class="divider"></li>
            <li class="waves-effect"><a href="#" class="shades-text text-white">Lihat Semua Akun</a></li>
            <li class="waves-effect"><a href="#" class="shades-text text-white">Lihat Semua Grup</a></li>
          </ol>
        </div>
      </li>
      <li>
        <div class="collapsible-header waves-effect"><i class="material-icons">description</i>Halaman</div>
        <div class="collapsible-body">
          <ol class="blue accent-2">
            <li class="waves-effect"><a href="#" class="shades-text text-white">Tambah Halaman Baru</a></li>
            <li class="divider"></li>
            <li class="waves-effect"><a href="#" class="shades-text text-white">Lihat Semua Halaman</a></li>
          </ol>
        </div>
      </li>
      <li>
        <div class="collapsible-header waves-effect"><a href="#"><i class="material-icons">settings_applications</i>Pengaturan Website</a></div>
      </li>
      <li>
        <div class="collapsible-header waves-effect"><a href="#"><i class="material-icons">info</i>Tentang</a></div>
      </li>
    </ul>
  </div>

  <div class="col s12 m8 l9">
  