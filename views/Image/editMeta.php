<?php 
	use MvcApp\Core\App; 

?>
<div class="container">
	<div class="panel panel-default well-lg">
		<?php if (! is_null($image->getMetaAttr("XMP","Title"))) : ?>
			<h3><?php echo $image->getMetaAttr("XMP","Title"); ?></h3>
		<?php endif ?>

		<figure class="text-center figure-image" >
			<img src="<?php echo App::getApp()->getBasePath().App::getApp()->getConfig("dbFolder")."images/".$image->getFile() ;?>" alt="" >
		</figure>

		<div class="row">
			<div class="col-md-10 col-md-offset-1">	
				<h2>Métadonnées EXIF</h2>
				<?php if(count($image->getMeta()) > 0) : ?>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<form method="post" action="<?php echo App::getApp()->createUrl('image','editMeta',array($image->getId()));?>">
						<?php foreach ($image->getMeta() as $name => $group) : ?>
							<div class="panel panel-default">
    							<div class="panel-heading" role="tab" id="headingOne">
      								<h4 class="panel-title">
        								<a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $name ?>" aria-expanded="false" aria-controls="<?php echo $name ?>">
          								<?php echo $name ?>
        								</a>
      								</h4>
    							</div>
	   						 	<div id="<?php echo $name ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
		      						<div class="panel-body">
		      							<?php if(is_array($group)) :?>
											<?php foreach($group as $nameMeta => $meta) : ?>
												<?php if(is_array($meta)) $meta = implode(",",$meta) ?>
												<div class="form-group">
													<label for="<?php echo $nameMeta ?>" class="control-label"><?php echo $nameMeta ?></label>
													<input type="text" class="form-control" name="exif[<?php echo $nameMeta ?>]" value="<?php echo $meta ?>">
												</div>
											<?php endforeach ?>
										<?php else :?>
												<div class="form-group">
													<label for="<?php echo $name ?>" class="control-label"><?php echo $name ?></label>
													<input type="text" class="form-control" name="exif[<?php echo $name ?>]" value="<?php echo $group ?>">
												</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
				
						<?php endforeach ?>
						<div class="form-group form-button-submit">
							<button type="submit" class="btn btn-primary">Modifier</button>
							<a type="button" href="<?php echo App::getApp()->createUrl('image','view',array($image->getId()));?>" class="btn btn-warning">Annuler</a>	
						</div>
						</form>
					</div>
				<?php else : ?>
					<p class="text-center">Aucune métadonnée a modifier</p>
				<?php endif ?>

			</div>
		</div>
	</div>
</div>
