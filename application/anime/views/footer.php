<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
</div>
<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-4">
				<div class="footer_widget_title">
				<i class="glyphicon glyphicon-star"></i> <?php echo $this->lang->line('footer_popular_anime') ?>
				</div>
				<div class="footer_widget_content">
					
				</div>
			</div>

			<div class="col-lg-4 col-md-4">
				<div class="footer_widget_title">
				<i class="glyphicon glyphicon-star"></i> <?php echo $this->lang->line('footer_latest_comments') ?>
				</div>
				<div class="footer_widget_content">
				</div>
			</div>

			<div class="col-lg-4 col-md-4">
				<div class="footer_widget_title">
				<i class="glyphicon glyphicon-star"></i> <?php echo $this->lang->line('links') ?>
				</div>
				<div class="footer_widget_content">
					<ul class="sitemap">
						<li><a href="#"><?php echo $this->lang->line('forum') ?></a></li>
						<li><a href="<?php echo site_url('p/dmca/') ?>">DMCA Copyright</a></li>
						<li><a href="<?php echo site_url('p/privacy/') ?>"><?php echo $this->lang->line('privacy') ?></a></li>
						<li><a href="<?php echo site_url('p/tos/') ?>"><?php echo $this->lang->line('tos') ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="credits">
			<div class="pull-left">
			Copyright &copy; 2015 <a href="<?php echo base_url() ?>">Dimensi Anime</a>. All rights reserved.
			</div>
			<div class="pull-right"><?php echo $this->lang->line('render_time') ?> <strong>{elapsed_time}</strong> <?php echo $this->lang->line('seconds') ?></div>
			<div class="clearfix"></div>
		</div>
	</div>
</footer>

<script src="<?php echo base_url().'assets/js/bootstrap.min.js' ?>"></script>
</body>
</html>