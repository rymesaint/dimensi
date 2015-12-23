<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  ?>
<div class="row">
	<section class="content col-lg-8 col-md-8">
		<nav>
			<ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope
				  itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="<?php echo base_url() ?>">
					<span itemprop="name"><?php echo $this->lang->line('home') ?></span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope
				  itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="<?php echo site_url('anime/browse/') ?>">
					<span itemprop="name"><?php echo $this->lang->line('browse_anime') ?></span></a>
					<meta itemprop="position" content="2" />
				</li>
				<li class="current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="<?php echo site_url('anime/'.$anime->permalink.'/') ?>">
						<span itemprop="name"><?php echo $anime->title_anime ?></span>
						<meta itemprop="position" content="3"/>	
					</a>
				</li>
			</ol>
		</nav>
		<header>
			<div class="single-bullet-title">
				<i class="glyphicon glyphicon-star"></i>
				<?php echo $anime->title_anime ?>
			</div>
		</header>
		<div class="wrapper-content-inside">
			<article class="single-anime">
				<div class="thumb-single-img">
					<img src="<?php echo base_url().'uploads/'.$anime->image ?>" class="img img-responsive">
				</div>
				<div class="synopsis">
					<p><?php echo $anime->synopsis ?></p>
				</div>
				<div class="clearfix"></div>

				<table class="table-episode table table-stripped">
					<legend>Tabel Episode</legend>
					<tr>
						<th>No. Episode</th>
						<th>Judul</th>
						<th>Dilihat</th>
					</tr>
					<?php foreach ($episodes as $itemEpisode): ?>
					<tr>
						<td><a href="<?php echo site_url('anime/'.$anime->permalink.'/'.$itemEpisode->episode.'/') ?>">Episode <?php echo $itemEpisode->episode ?></a></td>
						<td><a href="<?php echo site_url('anime/'.$anime->permalink.'/'.$itemEpisode->episode.'/') ?>"><?php echo $itemEpisode->judul_episode ?></a></td>
						<td><?php echo $itemEpisode->klik ?>x</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</article>
		</div>
	</section>
	<aside class="sidebar col-lg-4 col-md-4">
		<div class="wrapper_sidebar">
			<div class="sidebar_title">Informasi Anime</div>
			<div class="sidebar_content">
				<table class="table table-stripped">
					<tr>
						<td>Tipe</td>
						<td>: <?php echo strtoupper($anime->series) ?></td>
					</tr>
					<tr>
						<td>Episode</td>
						<td>: <?php echo $anime->max_episodes ?></td>
					</tr>
					<tr>
						<td>Status</td>
						<td>: <?php echo $anime->status ?></td>
					</tr>
					<tr>
						<td>Sumber</td>
						<td>: <?php echo $anime->source_anime ?></td>
					</tr>
					<tr>
						<td>Genre</td>
						<td>: <?php echo $genre_link ?></td>
					</tr>
					<tr>
						<td>Rating</td>
						<td>: PG-13</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="wrapper_sidebar">
			<div class="sidebar_title">Statistik</div>
			<div class="sidebar_content">
				<table class="table table-stripped">
					<tr>
						<td>Skor</td>
						<td>: <?php echo $rating->avg ?>/5 (dipilih oleh <?php echo $rating->votes ?> pengguna)</td>
					</tr>
					<tr>
						<td>Ranking</td>
						<td>: #N/A</td>
					</tr>
					<tr>
						<td>Favorite</td>
						<td>: 477</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="wrapper_sidebar">
			<div class="sidebar_title">Laporan</div>
			<div class="sidebar_content">
				<div class="alert alert-info">Jika kalian menemukan link yang tidak dapat diakses pada tabel, silahkan laporkan kepada kami lewat form dibawah ini :</div>
				<form class="form-horizontal">
				<fieldset>
				<div class="form-group">
				  <label class="col-md-4 control-label" for="episodeNum">No. Episode</label>  
				  <div class="col-md-8">
				  <input id="episodeNum" name="episodeNum" type="text" placeholder="Masukan No Episode" class="form-control input-md" required="">
				    
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="judulAnime">Judul</label>  
				  <div class="col-md-8">
				  <input id="judulAnime" name="judulAnime" type="text" value="<?php echo set_value('judulAnime', $anime->title_anime) ?>" placeholder="Judul Anime" class="form-control input-md" required="">
				    
				  </div>
				</div>

				<!-- Textarea -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="keterangan">Keterangan</label>
				  <div class="col-md-8">                     
				    <textarea class="form-control" rows="5" id="keterangan" name="keterangan" placeholder="Masukan keterangan link tidak dapat diakses atau kerusakan lainnya."></textarea>
				  </div>
				</div>

				<!-- Button -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="laporBtn"></label>
				  <div class="col-md-8">
				    <button id="laporBtn" name="laporBtn" class="btn btn-warning"><i class="glyphicon glyphicon-send"></i> Laporkan</button>
				  </div>
				</div>

				</fieldset>
				</form>
			</div>
		</div>
	</aside>
</div>