<?php
	use MvcApp\Core\App;
?>
<!doctype html>
<html class="no-js" lang="fr">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo App::getApp()->getName(); ?></title>
	
	<link rel="stylesheet" href="<?php echo App::getApp()->getBasePath() ?>libs/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo App::getApp()->getBasePath() ?>libs/material/css/ripples.min.css">
    <link rel="stylesheet" href="<?php echo App::getApp()->getBasePath() ?>libs/material/css/material-wfont.min.css">
    <link rel="stylesheet" href="<?php echo App::getApp()->getBasePath() ?>libs/material/css/material.min.css">
	<link rel="stylesheet" href="<?php echo App::getApp()->getBasePath() ?>css/reset-bootstrap.css" />
	<link rel="stylesheet" href="<?php echo App::getApp()->getBasePath() ?>css/main.css" />


	<script src="<?php echo App::getApp()->getBasePath() ?>libs/jquery/jquery.min.js"></script>
	<script src="<?php echo App::getApp()->getBasePath() ?>js/utils.js"></script>
	<script src="<?php echo App::getApp()->getBasePath() ?>libs/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo App::getApp()->getBasePath() ?>libs/material/js/ripples.min.js"></script>
    <script src="<?php echo App::getApp()->getBasePath() ?>libs/material/js/material.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"> </script>

	<script>
		App = {
			urls : "<?php echo App::getApp()->getBasePath(); ?>",
			databaseFolder : "<?php echo App::getApp()->getConfig('dbFolder') ?>"
		};
	</script>
</head>
	<body>
		<header class=" main-header">
			<nav class="row pull-right main-navigation">
				<ul class="list-inline">
					<li><a title="Liste" href="<?php echo App::getApp()->createUrl('image','list');?>"><i class="mdi-image-photo-library"></i></a></li>
					<li><a title="Carte" href="<?php echo App::getApp()->createUrl('image','map');?>"><i class="mdi-maps-pin-drop"></i></a></li>
				</ul>
			</nav>
			<?php if(isset($titlePage)) :?>
				<div class="container">
					<h2 class="main-title col-md-12"><?php echo $titlePage ?></h2>
				</div>
			<?php endif; ?>
		<?php if($this instanceof DevoirMetaAL\Image\ImageController ): ?>
			<button data-toggle="modal" data-target="#modelAdd" class="float-btn-upload btn btn-danger btn-fab btn-raised mdi-content-add"></button>
		<?php $this->uploadAction(); ?>
		<?php endif; ?>
		
		</header>
		<div class="main-container container-fluid">
			<?php echo $content; ?>
		</div>

		
	</body>
</html>
