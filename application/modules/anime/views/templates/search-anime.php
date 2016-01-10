<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
	<section class="content col-lg-8 col-md-8">
		<div class="wrapper-bullet-title">
			<i class="glyphicon glyphicon-star"></i>
			Cari Anime Berdasarkan Kata Kunci : <strong><?php echo $txt_keyword ?></strong>
		</div>
		<div class="wrapper-content-inside">
			<?php foreach ($anime as $episode): $result = $rating->get($episode->idanime); ?>
			<div class="wrapper-block-anime">
				<a href="<?php echo base_url().'anime/'.$episode->permalink.'/' ?>">
					<div class="block-anime-title">
					<?php echo $episode->title_anime ?></span>
					</div>
				</a>
				<div class="block-anime-img">
					<a href="<?php echo base_url().'anime/'.$episode->permalink.'/' ?>"><img src="<?php echo base_url().'uploads/'.$episode->image ?>" class="img img-responsive"></a>
				</div>
				<div class="block-anime-meta">
					<table class="table table-stripped">
						<tr>
							<td><?php echo $this->lang->line('release_date') ?></td>
							<td>: <?php echo date('F d Y H:i A', $episode->created_date); ?></td>
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
			<div class="sidebar_title">Lihat Genre Lainnya</div>
			<div class="sidebar_content">
				
			</div>
		</div>
	</aside>
</div>
