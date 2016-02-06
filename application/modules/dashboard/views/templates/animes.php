<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<header>
  <h2>Animes</h2>
</header>
<div class="card-panel">
  <legend>Daftar Anime</legend>
  <div class="left">
    <a class="btn btn-success" href="<?php echo site_url('dashboard/animes/tambah_anime/') ?>"><i class="fa fa-plus"></i> Tambah Anime</a>
  </div>
  <div class="right">
    <form>
      <input type="search" id="title_anime" name="q" placeholder="Search anime..." class="form-control"/> 
    </form>
  </div>
  <table class="highlight responsive-table">
    <thead>
      <tr>
        <th>#ID</th>
        <th>Judul Anime</th>
        <th>Publikasi Anime</th>
        <th>Total Episode</th>
        <th>Tanggal Rilis</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="animes">
    </tbody>
  </table>
<div id="paging-anime" class="pagination"></div>
</div>
<script type="text/javascript">
  var MIN_LENGTH = 3;
  $( document ).ready(function() {
    $("#title_anime").keyup(function() {
      var keyword = $("#title_anime").val();
      if (keyword.length >= MIN_LENGTH) {
        $.get( "<?php echo base_url() ?>dashboard/animes/animesearch/", { keyword: keyword } )
          .done(function( data ) {
            $("#animes").html(data);
          });
      }
    });

  });
</script>
<script type="text/javascript">
$("#paging-anime").paging(<?php echo $count_anime ?>, {
  format: '< nnncnnn >',
  perpage: 15,
  onSelect: function (page) {
    // add code which gets executed when user selects a page
    var dataS = "start="+ this.slice[0] + "&end="+ this.slice[1] + "&page=" + page;
    $.ajax({
      url: "<?php echo base_url().'dashboard/animes/listanimes/' ?>",
      data: dataS,
      type: 'POST',
      beforeSend:function(){
        $("#animes").html('<div class="loader-wrap"><img src="<?php echo base_url() ?>assets/images/waiting.gif"></div>');
      },
      success:function(data){
        $("#animes").html(data);
      },
      error:function(data){
        $("#animes").html("Try to load but return with error code : "+data.txtStatus);
      }
    })
  },
  onFormat: function (type) {
    switch (type) {
    case 'block': // n and c
      if(this.value != this.page)
        return '<li><a href="#'+ this.value +'" id="'+ this.value +'">' + this.value + '</a></li>';
      else
        return '<li class="active"><a href="#'+ this.value +'" id="'+ this.value +'">' + this.value + '</a></li>';
    case 'next': // >
      if(this.active)
        return '<li><a href="#'+ this.value +'" id="'+ this.value +'"><i class="material-icons">chevron_right</i></a></li>';
      else
        return '<li class="disabled"><a href="#'+ this.value +'" id="'+ this.value +'"><i class="material-icons">chevron_right</i></a></li>';
    case 'prev': // <
      if(this.active)
        return '<li><a href="#'+ this.value +'" id="'+ this.value +'"><i class="material-icons">chevron_left</i></a></li>';
      else
        return '<li class="disabled"><a href="#'+ this.value +'" id="'+ this.value +'"><i class="material-icons">chevron_left</i></a></li>';
    case 'first': // [
      if(this.active)
        return '<li><a href="#'+ this.value +'" id="'+ this.value +'">First</a></li>';
      else
        return '<li class="disabled"><a href="#'+ this.value +'" id="'+ this.value +'">First</a></li>';
    case 'last': // ]
      if(this.active)
        return '<li><a href="#'+ this.value+ '" id="'+ this.value +'">Last</a></li>';
      else
        return '<li class="disabled"><a href="#'+ this.value+ '" id="'+ this.value +'">Last</a></li>';
    }
  }
});
</script>

<div class="card-panel">
  <h5>Daftar Link Episodes</h5>
  <div class="left">
    <a class="btn btn-success" href="<?php echo site_url('dashboard/animes/tambah_episode/') ?>"><i class="fa fa-plus"></i> Tambah Episode</a>
  </div>
  <div class="right">
    <form>
      <input type="search" id="title_episode" name="q" placeholder="Search anime..." class="form-control"/> 
    </form>
  </div>
  <table class="highlight responsive-table">
    <thead>
    <tr>
      <th>#ID</th>
      <th>Judul Anime</th>
      <th>Episode</th>
      <th>Sumber Video</th>
      <th>Tanggal Rilis</th>
    </tr>
    </thead>
    <tbody  id="episodes">
    </tbody>
  </table>
    <div id="paging-episode" class="pagination"></div>
</div>

<script>
$("#paging-episode").paging(<?php echo $count_episode ?>, {
  format: '< nnncnnn >',
  perpage: 15,
  onSelect: function (page) {
    // add code which gets executed when user selects a page
    var dataS = "start="+ this.slice[0] + "&end="+ this.slice[1] + "&page=" + page;
    $.ajax({
      url: "<?php echo base_url().'dashboard/animes/listepisode/' ?>",
      data: dataS,
      type: 'POST',
      beforeSend:function(){
        $("#episodes").html('<div class="loader-wrap"><img src="<?php echo base_url() ?>assets/images/waiting.gif"></div>');
      },
      success:function(data){
        $("#episodes").html(data);
      },
      error:function(data){
        $("#episodes").html("Try to load but return with error code : "+data.txtStatus);
      }
    })
  },
  onFormat: function (type) {
    switch (type) {
    case 'block': // n and c
      if(this.value != this.page)
        return '<li class="waves-effect"><a href="#'+ this.value +'" id="'+ this.value +'">' + this.value + '</a></li>';
      else
        return '<li class="active"><a href="#'+ this.value +'" id="'+ this.value +'">' + this.value + '</a></li>';
    case 'next': // >
      if(this.active)
        return '<li><a href="#'+ this.value +'" id="'+ this.value +'"><i class="material-icons">chevron_right</i></a></li>';
      else
        return '<li class="disabled"><a href="#'+ this.value +'" id="'+ this.value +'"><i class="material-icons">chevron_right</i></a></li>';
    case 'prev': // <
      if(this.active)
        return '<li><a href="#'+ this.value +'" id="'+ this.value +'"><i class="material-icons">chevron_left</i></a></li>';
      else
        return '<li class="disabled"><a href="#'+ this.value +'" id="'+ this.value +'"><i class="material-icons">chevron_left</i></a></li>';
    case 'first': // [
      if(this.active)
        return '<li><a href="#'+ this.value +'" id="'+ this.value +'">First</a></li>';
      else
        return '<li class="disabled"><a href="#'+ this.value +'" id="'+ this.value +'">First</a></li>';
    case 'last': // ]
      if(this.active)
        return '<li><a href="#'+ this.value+ '" id="'+ this.value +'">Last</a></li>';
      else
        return '<li class="disabled"><a href="#'+ this.value+ '" id="'+ this.value +'">Last</a></li>';
    }
  }
});
</script>

<script type="text/javascript">
  var MIN_LENGTH = 3;
  $( document ).ready(function() {
    $("#title_episode").keyup(function() {
      var keyword = $("#title_episode").val();
      if (keyword.length >= MIN_LENGTH) {
        $.get( "<?php echo base_url() ?>dashboard/animes/episodesearch/", { keyword: keyword } )
          .done(function( data ) {
            $("#episodes").html(data);
          });
      }
    });

  });
</script>