<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="featured row">
	<div class="col-lg-8 col-md-8">		
		<ul class="bxslider">
		  <li><img src="images/thumb-01.jpg" class="img img-responsive" /></li>
		  <li><img src="images/thumb-02.jpg" class="img img-responsive" /></li>
		  <li><img src="images/thumb-03.jpg" class="img img-responsive" /></li>
		  <li><img src="images/thumb-04.jpg" class="img img-responsive" /></li>
		  <li><img src="images/thumb-05.jpg" class="img img-responsive" /></li>
		</ul>
	</div>
	<div class="col-lg-4 col-md-4">
		<div class="wrapper-box-widget">
			<div class="box-widget-title">
				<i class="glyphicon glyphicon-star"></i>
				Anime Terpopuler
			</div>
			<div class="box-widget-content">
			<?php foreach($popular as $limit_episode): ?>
				<div class="popular-animes">
					<div class="thumb-img">
						<img src="<?php echo base_url().'uploads/'.$limit_episode->image ?>" class="img img-responsive">
					</div>
					<div class="title"><a href="<?php echo site_url('anime/'.$limit_episode->permalink) ?>"><?php echo $limit_episode->title_anime ?></a></div>
					<div class="short-desc"><?php echo substr($limit_episode->synopsis, 0 ,100) ?>...</div>
					<div class="clearfix"></div>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<div class="row">
	<section class="content col-lg-8 col-md-8">
		<div class="wrapper-bullet-title">
			<i class="glyphicon glyphicon-star"></i>
			Rilisan Anime Terbaru
		</div>
		<div class="wrapper-content-inside">
			<?php foreach ($anime as $episode): $result = $rating->get($episode->idanime); ?>
			<div class="wrapper-block-anime">
				<a href="<?php echo base_url().'anime/'.$episode->permalink.'/'.$episode->episode.'/' ?>">
					<div class="block-anime-title">
					<?php echo $episode->title_anime ?> Episode <span class="episode"><?php echo $episode->episode ?></span>
					</div>
				</a>
				<div class="block-anime-img">
					<a href="<?php echo base_url().'anime/'.$episode->permalink.'/'.$episode->episode.'/' ?>"><img src="<?php echo base_url().'uploads/'.$episode->image ?>" class="img img-responsive"></a>
				</div>
				<div class="block-anime-meta">
					<table class="table table-stripped">
						<tr>
							<td><?php echo $this->lang->line('release_date') ?></td>
							<td>: <?php echo date('F d Y H:i A', $episode->date_added); ?></td>
						</tr>
						<tr>
							<td>Rating</td>
							<td>: <?php echo $result->avg ?>/5 dari <?php echo $result->votes ?> pengguna.</td>
						</tr>
						<tr>
							<td>Lihat semua Episode</td>
							<td>: <a href="<?php echo base_url().'anime/'.$episode->permalink.'/' ?>"><?php echo $episode->title_anime ?></a></td>
						</tr>
					</table>
				</div>
				<div class="clearfix"></div>
			</div>
		<?php endforeach; ?>
		</div>
	</section>
	<aside class="sidebar col-lg-4 col-md-4">
		<div class="wrapper_sidebar">
			<div class="sidebar_title">Status Website</div>
			<div class="sidebar_content">
				<table class="table table-stripped">
					<tr>
						<td>Judul Anime</td>
						<td>: <?php echo $count_anime ?> Anime</td>
					</tr>
					<tr>
						<td>Episode Dirilis</td>
						<td>: <?php echo $count_episode ?> Episode</td>
					</tr>
					<tr>
						<td>Genre Anime</td>
						<td>: <?php echo $count_genre ?> Genre</td>
					</tr>
					<tr>
						<td>Anggota</td>
						<td>: 5 anggota</td>
					</tr>
					<tr>
						<td>Pengunjung</td>
						<td>: -/+ 200 Pengunjung per hari</td>
					</tr>
					<tr>
						<td>Menyukai Website</td>
						<td>: 102 orang menyukai website ini.</td>
					</tr>
				</table>
			</div>
		</div>
	</aside>
</div>
