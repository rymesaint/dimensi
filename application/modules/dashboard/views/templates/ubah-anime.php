<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<script>
$(document).ready(function() {
  $('select').material_select();
});
</script>

<header>
  <h2>Ubah Anime</h2>
</header>
<div class="row">
  <form class="col s12" action="<?php echo site_url('dashboard/animes/proses/ubah') ?>" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="input-field col s12">
        <select id="series" name="series">
          <option value="" disabled selected>Pilih Series Anime</option>
          <option <?php echo ($animes->series == "tv"? "selected" : "") ?> value="tv">TV</option>
          <option <?php echo ($animes->series == "ova"? "selected" : "") ?> value="ova">OAV/OVA</option>
          <option <?php echo ($animes->series == "movie"? "selected": "") ?> value="movie">Movies</option>
          <option <?php echo ($animes->series == "ona"? "selected": "") ?> value="ona">ONA</option>
        </select>
        <label for="series">Series Anime</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input type="hidden" name="idanime" value="<?php echo $animes->idanime ?>">
        <input placeholder="Judul Anime" value="<?php echo $animes->title_anime ?>" id="judul-anime" name="judul-anime" type="text" class="validate">
        <label for="judul-anime">Judul Anime</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <textarea id="synopsis" class="materialize-textarea" name="synopsis" placeholder="Sinopsis Anime">
          <?php echo $animes->synopsis ?>
        </textarea>
        <label for="synopsis">Synopsis</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <select id="genre" class="genre form-control" multiple="multiple" name="genre[]">
          <?php 
            $arr = explode(",", $animes->genres);
            $jumlah = 0;
            foreach($arr as $val):
              $jumlah = $jumlah + 1;
            endforeach;
              foreach($genres as $genre):
                for($j = 0; $j  < $jumlah; $j++):
                  if($arr[$j] == $genre->namegenre):
                    echo "<option selected value=\"".$arr[$j]."\">".$arr[$j]."</option>";
                  endif;
                endfor;
                    echo "<option value=\"".$genre->namegenre."\">".$genre->namegenre."</option>";
              endforeach;
          ?>
        </select>
        <label for="genre"></label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input placeholder="Max. Episode" id="episodes" value="<?php echo $animes->max_episodes ?>" name="episodes" type="number" class="validate">
        <label for="episodes">Max Episode</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <select id="koderate" class="koderate form-control" name="ratingkode" required>
          <option value="" disabled selected>Pilih Rating Kode Anime</option>
          <option <?php echo ($animes->kode_rate == "g"? "selected": "") ?> value="g">G</option>
            <option <?php echo ($animes->kode_rate == "pg"? "selected": "") ?> value="pg">PG</option>
            <option <?php echo ($animes->kode_rate == "pg-13"? "selected": "") ?> value="pg-13">PG-13</option>
            <option <?php echo ($animes->kode_rate == "r"? "selected": "") ?> value="r">R</option>
            <option <?php echo ($animes->kode_rate == "nc-17"? "selected": "") ?> value="nc-17">NC-17</option>
        </select>
        <label for="koderate">Rating Kode Anime</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input placeholder="Nama Studio Produksi" value="<?php echo $animes->studios ?>" id="studio" name="studio" type="text" class="validate">
        <label for="studio">Studio Produksi</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <select id="rilistahun" class="rilistahun form-control" name="rilistahun" required>
          <option value="" disabled selected>Pilih Tahun Rilis Anime</option>
          <?php for ($i = date("Y"); $i >= 1945 ; $i--): ?>
            <option <?php echo ($animes->date_published == $i? "selected": "") ?> value="<?php echo $i ?>"><?php echo $i ?></option>
          <?php endfor; ?>
        </select>
        <label for="rilistahun">Tahun Rilis Anime</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <select id="season" class="season form-control" name="season" required>
          <option value="" disabled selected>Pilih Musim Anime Dirilis</option>
          <?php foreach($seasons as $season): ?>
            <option <?php echo ($animes->season == $season->idseason? "selected" : "") ?> value="<?php echo $season->idseason ?>"><?php echo $season->nama_season ?></option>
          <?php endforeach; ?>
        </select>
        <label for="season">Anime Musim</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <select id="status" class="status form-control" name="status" required>
          <option value="" disabled selected>Pilih Status Anime</option>
            <option <?php echo ($animes->status == "On-Going"? "selected": "") ?> value="On-Going">On-Going</option>
            <option <?php echo ($animes->status == "Completed"? "selected": "") ?> value="Completed">Completed</option>
            <option <?php echo ($animes->status == "Break"? "selected": "") ?> value="Break">Break</option>
            <option <?php echo ($animes->status == "Dropped"? "selected": "") ?> value="Dropped">Dropped</option>
          </select>
        <label for="status">Status Anime</label>
      </div>
    </div>
    <div class="row">
      <div class="file-field input-field col s12">
        <div class="btn">
          <span>Photo</span>
          <input name="photo" type="file" accept="image/*">
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text">
        </div>
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
$(".genre").select2({
  tags: true,
  placeholder: "Masukan Genre Anime",
  tokenSeparators: [',', ' ']
})
</script>

<script>
	$('#judul-anime').on('input', function() {
  var permalink;
      
	// Trim empty space
 	permalink = $.trim($(this).val());
  
	// replace more then 1 space with only one
 	permalink = permalink.replace(/\s+/g,' ');

  $('#permalink').html(permalink.toLowerCase());
  $('#permalink').html($('#permalink').html().replace(/\W/g, ' '));
  $('#permalink').html($.trim($('#permalink').html()));
  $('#permalink').html($('#permalink').html().replace(/\s+/g, '-')+'/');
});

</script>
