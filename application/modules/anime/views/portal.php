<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php echo 'Portal '.$title; ?></title>
	<?php 
	echo meta('description', $description);
	echo meta('keywords', $keywords);

	echo link_tag('assets/favicon.png', 'shortcut icon', 'image/png');
	echo link_tag('assets/css/bootstrap.min.css');
	echo link_tag('assets/css/portal.css');
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="alert-message">
				<p>Selamat Datang <br/> Portal <?php echo $title ?></p>
			</div>
		</div>
	</div>
	<div class="row">
	    <div class="col-md-3 col-md-offset-2">
	    	<div class="wrapper-block-enter">
	    		<div class="block-enter-image">
	    			<div class="button enter-anime" onclick="javascript:window.location='<?php echo site_url('portal/anime/') ?>'">Masuk Portal Anime</div>
	    		</div>
	    	</div>
	    </div>
	    <div class="col-md-3 col-md-offset-1">
	    	<div class="wrapper-block-enter">
		    	<div class="block-enter-image">
		    		<div class="button enter-hentai" onclick="javascript:window.location='<?php echo site_url('portal/hentai/') ?>'">Masuk Portal Hentai</div>
		    	</div>
		    </div>
	    </div>	
	</div>
</div>

<script src="js/bootstrap.min.js"></script>
</body>
</html>