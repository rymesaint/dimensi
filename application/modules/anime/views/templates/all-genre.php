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
					<a itemprop="item" href="<?php echo site_url('genre/') ?>">
					<span itemprop="name"><?php echo $this->lang->line('browse_genre') ?></span></a>
					<meta itemprop="position" content="2" />
				</li>
			</ol>
		</nav>
		<header>
			<div class="single-bullet-title">
				<i class="glyphicon glyphicon-star"></i>
				<?php echo $this->lang->line('browse_genre') ?>
			</div>
		</header>
		<div class="wrapper-content-inside">
			<?php foreach ($genres as $genre): 
				$count = $count_genre->select_by_genre($genre->namegenre, 0, false)->num_rows();
			?>
				<div class="wrapper-genre">
					<a href="<?php echo site_url('genre/'.strtolower(urlencode($genre->namegenre))) ?>">
					<div class="label lbl-genre"><?php echo $count; ?></div>
					<p><?php echo $genre->namegenre ?></p>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
</div>