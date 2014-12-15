<?php use MvcApp\Core\App; ?>
<div class="container picture-view">
	<div class="panel panel-default well-lg">
		<?php if (! is_null($image->getMetaAttr("XMP","Title"))) : ?>
			<h2  class="col-md-10 col-md-offset-1"><?php echo $image->getMetaAttr("XMP","Title"); ?></h2>
		<?php endif ?>
		<figure class="text-center figure-image" >
			<img src="<?php echo App::getApp()->getBasePath().App::getApp()->getConfig("dbFolder")."images/".$image->getFile() ;?>" alt="" >
		</figure>
		<nav class="text-center">
			<a type="button" href="<?php echo App::getApp()->createUrl('image','editMeta',array($image->getId()));?>" class="btn btn-info">Editer</a>	
			<a type="button" href="<?php echo App::getApp()->createUrl('image','extractXMP',array($image->getId()));?>" class="btn btn-info">Fichier XMP</a>
			<?php $file=App::getApp()->getBasePath().App::getApp()->getConfig("dbFolder")."images/".$image->getFile(); ?>
			<a type="button" href="<?php echo $file ?>" class="btn btn-info" download="<?php echo $image->getFile(); ?>">Télécharger</a>
		</nav>
	</div>
	<div class="panel panel-default well-lg">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">		
				<h2>Métadonnées EXIF</h2>
				<?php if(count($image->getMeta()) > 0) : ?>
					<div itemscope itemtype="http://schema.org/ImageObject" class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
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
		      								<table class="table table-striped">
											<?php foreach($group as $nameMeta => $meta) : ?>

												<?php if(is_array($meta)) $meta = implode(",",$meta) ?>
												<tr>
													<td><?php echo $nameMeta ?></td>
													<td data-meta="<?php echo $name.':'.$nameMeta ?>" <?php echo $helpersMicro->getMicrodata($name,$nameMeta,$meta) ?> ><?php echo $meta ?></td>
												</tr>
											<?php endforeach ?>
											</table>
										<?php else :?>
												<p>
													<?php echo $group; ?>
												</p>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php endforeach ?>
					</div>
				<?php else : ?>
					<p class="text-center">Aucune métadonnée</p>
				<?php endif ?>
			</div>
		</div>
	</div>
	<div class="panel panel-default well-lg flickr">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h2>Relations FLICKR</h2>
				<form class=" form-search-flickr" role="form">
					<div class="form-group">
						<label for="">Filtre : </label>
						<div class="radio radio-info">
                           	<label>
                                <input type="radio" name="searchFlickr" value="gps" checked="checked"><span class="circle"></span><span class="check"></span>
                                Position
                            </label>
                       </div>
						<div class="radio radio-info">
                           	<label>
                                <input type="radio" name="searchFlickr" value="tag"><span class="circle"></span><span class="check"></span>
                                Tags
                            </label>
                       </div>
						<div class="radio radio-info">
                           	<label>
                                <input type="radio" name="searchFlickr" value="title"><span class="circle"></span><span class="check"></span>
                                Titre
                            </label>
                       </div>
					</div>
				</form>
				<div class="flickr-image"></div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo App::getApp()->getBasePath() ?>js/flickrAPI.js"></script>
<script src="<?php echo App::getApp()->getBasePath() ?>js/flickr.js"></script>


