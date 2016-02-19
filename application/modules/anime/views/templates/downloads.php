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
					<a itemprop="item" href="<?php echo site_url('anime/'.$anime->permalink.'/'.$sAnime[0]->episode.'/') ?>">
						<span itemprop="name">Episode <?php echo $sAnime[0]->episode ?></span>
						<meta itemprop="position" content="3"/>	
					</a>
				</li>
			</ol>
		</nav>
		<header>
			<div class="single-bullet-title">
				<i class="glyphicon glyphicon-star"></i>
				Unduh <?php echo $anime->title_anime ?> Episode <?php echo $sAnime[0]->episode ?>
			</div>
		</header>

		<div class="wrapper-content-inside">
			<div class="alert alert-warning">
				Sebelum anda mengunduh file yang berada dibawah ini, anda harus menyutujui beberapa persetujuan dibawah ini:
				<ul>
					<li>Kami tidak bertanggung jawab atas apapun yang terhadap file (berkas) yang anda unduh dari website ini.</li>
					<li>Jika terdapat permasalahan dengan file contoh seperti file rusak, tidak bisa di unduh, dll. Hubungi pengguna yang telah membagikan link nya dengan kami.</li>
					<li>Persetujuan diatas ini adalah sementara, dan dapat kami ubah kapanpun.</li>
				</ul>
			</div>
			<table class="table table-horizontal">
				<tr>
					<th>#ID</th>
					<th>Hosting</th>
					<th>Ukuran File</th>
					<th>Subtitle</th>
					<th>Dibagikan Oleh</th>
					<th>Tanggal</th>
				</tr>
				<?php foreach($sAnime as $eAnime): ?>
				<tr>
					<td><?php echo $eAnime->idepisode ?></td>
					<td><a href="<?php echo site_url('download/url/'.urlencode($eAnime->hashcode)) ?>" target="_BLANK"><?php echo $eAnime->namahosting ?></a></td>
					<td><?php echo $eAnime->filesize ?> MB</td>
					<td><?php echo $eAnime->subname ?></td>
					<td><?php echo $eAnime->username ?></td>
					<td><?php echo date("M, d Y H:iA", $eAnime->date_added) ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<div class="wrapper-comments">
			<h5 class="title-comments">Komentar</h5>
			<div id="disqus_thread"></div>
			<script>
			/**
			* RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
			* LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
			*/
			
			var disqus_config = function () {
			this.page.url = 'http://<?php echo base_url()."download/".$anime->permalink."/".$sAnime[0]->episode."/"; ?>'; // Replace PAGE_URL with your page's canonical URL variable
			this.page.identifier = '41<?php echo $anime->idanime; ?>';
			this.page.title = 'Download <?php echo $anime->title_anime; ?> Episode <?php echo $sAnime[0]->episode; ?>';
			};
			
			(function() { // DON'T EDIT BELOW THIS LINE
			var d = document, s = d.createElement('script');

			s.src = '//ryme-anime.disqus.com/embed.js';

			s.setAttribute('data-timestamp', +new Date());
			(d.head || d.body).appendChild(s);
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
						<td>: <?php echo humanize($anime->series) ?></td>
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
						<td>: <?php echo humanize($anime->kode_rate) ?></td>
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
				  <input id="episodeNum" name="episodeNum" type="text" placeholder="Masukan No Episode" value="<?php echo set_value('episodeNum', $sAnime[0]->episode) ?>" class="form-control input-md" required="">
				    
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