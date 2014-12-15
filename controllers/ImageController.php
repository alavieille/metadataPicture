<?php 
/**
* Controlleur des images
* @author Amaury Lavieille
*/
namespace DevoirMetaAL\Image;

use MvcApp\Core\Controller;
use MvcApp\Core\App;
use MvcApp\Core\AppException;
use MvcApp\Core\Form;
use MvcApp\Core\Upload;

use DevoirMetaAL\Components\MetaExif;
use DevoirMetaAL\Components\HelpersMicrodataImage;

/**
* Controlleur image
*/
class ImageController extends Controller
{

 	/**
    * initialise le controlleur
    */
    public function __construct()
    {
        $this->name = 'Image';
        parent::__construct();
    }


    protected function roles()
    {
      return array(
        array(
            "role" => "*",
            "actions" => array("index","list","upload","extractMeta","view","editMeta","extractXMP","map","listJson"),  
            )
        );
    }

    /**
    * Action par défaut
    */
    public function indexAction(){
        $this->listAction();
    }

    /**
    * Affiche la liste des images
    */
	public function listAction(){
        $imageDB = ImageDB::getInstance();
        $images = $imageDB->findAll();
        $this->render("list",array(
            "titlePage"=>"Liste des images",
            "images"=>$images
        ));
	}

    /**
    * Affiche la liste des images au format JSON
    */
    public function listJsonAction(){
        $imageDB = ImageDB::getInstance();
        $imagesJson = $imageDB->findAllJson();
        header('Content-Type: application/json');
        echo $imagesJson;
    }


    /**
    * Extrait les métadonnées d'une image au format json 
    * @param $imageId id de l'image
    */
    public function extractMetaAction($imageId){
        $image = ImageDB::getInstance()->findById($imageId);
        $meta = MetaExif::extractExif(App::getApp()->getConfig("dbFolder")."images/".$image->getFile());
        file_put_contents(App::getApp()->getConfig("dbFolder")."meta/".$imageId.".json",json_encode($meta));
    }


    /**
    * Afficher une image
    * @param $id Id de l'image
    */
    public function viewAction($id){
        $image = ImageDB::getInstance()->findById($id);
        if(is_null($image)){
            throw new \Exception("Impossible de trouver l'image", 1);
        }
        $helpersMicro = new HelpersMicroDataImage();
        $this->render("view",array(
            "titlePage"=>"Détails",
            "image"=>$image,
            "helpersMicro"=>$helpersMicro,
        ));

    }

    /**
    * Proppose au téléchargement le fichier XMP sidecar d'un image
    * @param id Id de l'image
    */
    public function extractXMPAction($id){
        $image = ImageDB::getInstance()->findById($id);
        if(is_null($image)){
            var_dump("error");
        }
        $file = App::getApp()->getConfig("dbFolder")."images/".$image->getFile();

        header("Content-type: text/xml");
        header('Content-Disposition: attachment; filename="meta.xmp"');
        echo MetaExif::extractXMP($file);

    }

    /**
    * Modifie les métadonnées d'un image
    * @param id Id de l'image
    */
    public function editMetaAction($id){
         $image = ImageDB::getInstance()->findById($id);
         if(is_null($image)){
            throw new \Exception("Impossible de trouver l'image", 1);
         }
         if( count(App::getApp()->getRequest()->getPost()) > 0) {
            $file = App::getApp()->getConfig("dbFolder")."images/".$image->getFile();
            $meta = App::getApp()->getRequest()->getPost()["exif"];
            MetaExif::updateExifMeta($file,$meta);
            if(file_exists($file."_original"))
                unlink($file."_original");
            $this->extractMetaAction($image->getId());
            App::getApp()->setFlash("Metadonnées correctement mise à jour","success");
            App::getApp()->redirect("image","view",$image->getId());
        }
         $this->render("editMeta",array(
            "titlePage"=>"Modifier les métadonnées",
            "image"=>$image
        ));
    }

    /**
    * Ajoute une image
    */ 
    public function uploadAction(){
        $image = new Image();
        $form = new Form($image,App::getApp()->createUrl('image','upload'),array(
            "id" => "form-upload-image",
            "enctype"=>"multipart/form-data",
        ));
        if( count($_FILES) > 0 ){

            if(! exif_imagetype($_FILES["fileUpload"]["tmp_name"])){
                    $image->setErrors("fileUpload","Le fichier n'est pas une image");
            }
            else {
                $upload = new Upload($_FILES["fileUpload"]);
                try {
                    $file = $upload->save(App::getApp()->getConfig("dbFolder")."images/");
                    $image->setFile($file);
                    $id = current(explode(".", $file));
                    $image->setId($id);
                    $this->extractMetaAction($image->getId());
                    App::getApp()->redirect("image","view",$image->getId());
                } catch (Exception $e) {
                    App::getApp()->setFlash("Impossible d'envoyer la photo","error");
                }
            }
        }

        $this->renderPartial("uploadModal",array(
            "titlePage" => "Ajouter une image",
            "form" => $form,
        ));

    }

    /**
    * Affiche les images sur une carte
    */
    public function mapAction(){
        $this->render("map",array(
            "titlePage" => "Carte",
        ));
    }



		
}