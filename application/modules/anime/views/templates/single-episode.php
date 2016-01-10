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
				<li itemprop="itemListElement" itemscope
				  itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="<?php echo site_url('anime/'.$anime->permalink.'/') ?>">
						<span itemprop="name"><?php echo $anime->title_anime ?></span>
						<meta itemprop="position" content="3"/>	
					</a>
				</li>
				<li class="current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="<?php echo site_url('anime/'.$anime->permalink.'/'.$eAnime->episode.'/') ?>">
						<span itemprop="name">Episode <?php echo $eAnime->episode ?></span>
						<meta itemprop="position" content="3"/>	
					</a>
				</li>
			</ol>
		</nav>
		<header>
			<div class="single-bullet-title">
				<i class="glyphicon glyphicon-star"></i>
				<?php echo $anime->title_anime ?> Episode <?php echo $eAnime->episode ?>
			</div>
		</header>

		<div class="wrapper-content-inside">
			<object data="<?php echo $hashcode ?>" class="video-embed entry-content" width="100%" height="460">
				<param name="src" value="<?php echo $hashcode ?>">
				<param name="autoplay" value="false">
				<param name="autoStart" value="0">
			</object>

			<div class="wrapper-mirror">
				<?php foreach ($mirror as $mirr): ?>
					<div class="mirror-title">
						<a class="active" href="<?php echo base_url().'anime/'.$anime->permalink.'/'.$mirr->episode.'/'.$mirr->parentid.'/' ?>"><?php echo $mirr->namahosting ?></a>
					</div>
				<?php endforeach; ?>
				<div class="cleafix">&nbsp;</div>
			</div>

		</div>
		<div class="wrapper-comments">
			<h5 class="title-comments">Comments</h5>
			<div id="disqus_thread"></div>
			<script type="text/javascript">
			    /* * * CONFIGURATION VARIABLES * * */
			    var disqus_shortname = 'ryme-anime';
			    var disqus_title = 'Streaming <?php echo $anime->title_anime; ?> Episode <?php echo $eAnime->episode; ?>';
			    var disqus_url = '<?php echo base_url()."anime/".$anime->permalink."/".$eAnime->episode."/"; ?>';

			    /* * * DON'T EDIT BELOW THIS LINE * * */
			    (function() {
			        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
			        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
			        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			    })();
			</script>
			<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
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
				  <input id="episodeNum" name="episodeNum" type="text" placeholder="Masukan No Episode" value="<?php echo set_value('episodeNum', $eAnime->episode) ?>" class="form-control input-md" required="">
				    
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