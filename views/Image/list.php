<?php use MvcApp\Core\App; ?>
<div class="container">
	<div class="panel panel-default">
	    <div class="panel-body">
	        <?php if(count($images) > 0 ) :?>
	        	<ul class="list-inline list-picture">
				<?php foreach($images as $image): ?>
					<li class="picture">
						<a href="view/<?php echo $image->getId(); ?>">
							<figure>
								<img itemprop="contentUrl" src="<?php echo App::getApp()->getBasePath().App::getApp()->getConfig("dbFolder")."images/".$image->getFile() ;?>" alt="<?php echo $image->getMetaAttr("XMP","Title"); ?>" >
								<figcaption>
						      		<?php if (! is_null($image->getMetaAttr("XMP","Title"))) : ?>
										<h4 itemprop="name" class="text-center"><?php echo $image->getMetaAttr("XMP","Title"); ?></h4>
									<?php endif ?>
									<?php if (! is_null($image->getMetaAttr("XMP","Creator"))) : ?>
										<p itemprop="author" ><?php echo $image->getMetaAttr("XMP","Creator"); ?></p>
									<?php endif ?>
			      				</figcaption>
							</figure>
						</a>
					</li>
				<?php endforeach; ?>
				</ul>
	        <?php else: ?>
	        	<p class="text-center">Aucune image</p>
	        <?php endif; ?>
	    </div>
	</div>
</div>


