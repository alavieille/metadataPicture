<div class="modal fade" id="modelAdd" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Ajouter une image</h4>
            </div>
            <div class="modal-body">
              <div class="col-md-8">
                <?php $form->beginForm(); ?>
                <div class="form-group">
                      <?php echo $form->label("fileUpload","Fichier",array("class"=>"control-label")); ?>
                      <?php echo $form->inputFile("fileUpload",array("required"=>"required")); ?>
                </div>       
              </div>
            <div class="modal-footer">
                <?php echo $form->submit("Ajouter",array("class"=>"btn btn-info"));?>
            </div>
        </div>
    </div>
</div>