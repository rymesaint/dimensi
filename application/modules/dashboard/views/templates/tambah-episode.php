<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script>
$(document).ready(function() {
  $('select').material_select();
});
</script>

<header>
  <h2>Tambah Episode Anime</h2>
</header>
<div class="row">
  <form class="col s12" action="<?php echo site_url('dashboard/episodes/proses/tambah') ?>" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="input-field col s12">
      <input type="hidden" name="iduser" value="<?php echo $this->session->iduser ?>">
        <select id="idanime" name="idanime" required>
          <option value="" disabled selected>Pilih Anime</option>
          <?php foreach ($animes as $anime): ?>
            <option value="<?php echo $anime->idanime ?>"><?php echo $anime->title_anime ?></option>
          <?php endforeach; ?>
        </select>
        <label for="idanime">Judul Anime *</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <select id="episode" name="episode" required>
          <option value="" disabled selected>Pilih Judul Anime Terlebih Dahulu</option>
        </select>
        <label for="episode">Episode Anime *</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input placeholder="Judul Episode" id="judul" name="judul" type="text" class="validate">
        <label for="url">Judul Episode (Opsional)</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input placeholder="URL Anime Episode" id="url" name="url" type="url" class="validate" required>
        <label for="url">URL Anime Episode *</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <select id="sumbervideo" class="form-control" name="sumbervideo" required>
          <option value="" disabled selected>Pilih Sumber Video</option>
          <?php foreach($source_videos as $source_video ): ?>
            <option value="<?php echo $source_video->idhosting ?>"><?php echo $source_video->namahosting ?></option>
          <?php endforeach; ?>
        </select>
        <label for="sumbervideo">Sumber Video *</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input placeholder="Ukuran File" id="filesize" name="filesize" type="number" class="validate">
        <label for="filesize">Ukuran File dalam MB (Opsional)</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <select id="subs" class="form-control" name="subtitle" required>
          <option value="" disabled selected>Pilih Subtitle Anime</option>
          <?php foreach($subtitles as $subtitle ): ?>
            <option value="<?php echo $subtitle->idsub ?>"><?php echo $subtitle->subname ?></option>
          <?php endforeach; ?>
        </select>
        <label for="subs">Subtitle Anime *</label>
      </div>
    </div>
  <div class="row">
    <div class="input-field col s12">
      <input class="btn waves-effect waves-light" type="submit" name="action" value="Simpan">
    </div>
  </div>
  </form>
</div>

<script>
$(function(){
$("#idanime").change(function(e){
    e.preventDefault();
    var id = $(this).val(),
    dataJ = "idanime="+id;
    $.ajax({
      url: '<?php echo base_url().'dashboard/ajax/getEpisode/' ?>',
      data: dataJ,
      type: 'POST',
      success:function(data){
        $("#episode").html(data);
        $("#episode").material_select();
      },
      error: function(data){
        $("#episode").html("Failed request episode data.");
      }
    });
  });
});
</script>