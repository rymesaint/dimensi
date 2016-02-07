<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="row">
	<div class="content col-lg-8 col-md-8">
	<header>
		<div class="single-bullet-title">
			<i class="glyphicon glyphicon-star"></i>
			Masuk Dimensi
		</div>
	</header>
	<div class="wrapper-content-inside">
	<?php echo validation_errors() ?>
	<form class="form-horizontal" action="<?php echo site_url('user/auth/') ?>" method="POST">
		<div class="form-group">
		  <div class="col-md-12">
		  <input id="username" name="username" type="text" placeholder="Username" class="form-control input-md" required>
		  </div>
		</div>
		<div class="form-group">
		  <div class="col-md-12">
		    <input id="password" name="password" type="password" placeholder="Password" class="form-control input-md" required>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="btnLogin"></label>
		  <div class="col-md-4">
		    <button id="btnLogin" name="btnLogin" class="btn btn-info"><?php echo $this->lang->line('login') ?></button>
		  </div>
		</div>
	</form>
	</div>
	</div>
	<aside class="sidebar col-lg-4 col-md-4">
		<div class="wrapper_sidebar">
			<div class="sidebar_title">Cara Masuk</div>
			<div class="sidebar_content">
				<table class="table table-stripped">
					
				</table>
			</div>
		</div>
	</aside>
</section>