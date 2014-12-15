<?php 
/**
* Classe qui gére les images (fichier et meta en xml)
* Implemente le pattern singleton
* @author Amaury Lavieille
*/
namespace DevoirMetaAL\Image;
use MvcApp\Core\App;
/**
* Gestion de la base de données des images
*/
class ImageDB {

	 /**
	 * Instance unique
	 */
	 static $instance;

	 /**
	 * Emplacement du dossier contenant les images et les métadonnées
	 **/
	 private $folderDB;

	 protected function __construct() { 
	 	$this->folderDB = App::getApp()->getConfig("dbFolder");
	 }

	/**
    * desactive le clonage
    */
    private function __clone() {}

    /**
    * Méthode pour accéder à l'UNIQUE instance de ImageBB
    * @return Instance de ImageDB
    */
    public static function getInstance()
    {
        

        if (is_null(self::$instance))
        {
             self::$instance = new ImageDB();
        }

        return  self::$instance;
    }


    /**
    * Retourne les images présentes dans le dossier 
    * @return Array<Image> Liste d'instance de Image
    */
    public function findAll(){
 		$images = array();
 		
        $files = array_diff(scandir($this->folderDB."images"), array('..', '.'));
        foreach ($files as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            if(in_array(strtolower($extension),array("gif","jpg","jpeg","png"))){
            	$id = current(explode(".", $file));
                $meta = array();
                if(file_exists(App::getApp()->getConfig("dbFolder")."meta/".$id.".json"))
                    $meta = json_decode(file_get_contents(App::getApp()->getConfig("dbFolder")."meta/".$id.".json"),true)[0];
   	            array_push($images, new Image(array("id"=>$id,"file"=>$file,"meta"=>$meta)));
            }
        }
        return $images;
    }


    /**
    * Retourne les images présentes dans le dossier au format JSON
    * @return Array<Image> Liste d'instance de Image
    */
    public function findAllJson(){
        $images = array();
        
        $files = array_diff(scandir($this->folderDB."images"), array('..', '.'));
        foreach ($files as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            if(in_array(strtolower($extension),array("gif","jpg","jpeg","png"))){
                $id = current(explode(".", $file));
                $meta = array();
                if(file_exists(App::getApp()->getConfig("dbFolder")."meta/".$id.".json")){
                    $meta = json_decode(file_get_contents(App::getApp()->getConfig("dbFolder")."meta/".$id.".json"),true)[0];
                }
                $image = new Image(array("id"=>$id,"file"=>$file,"meta"=>$meta));
                array_push($images, $image->getJsonData());
            }
        }
        return json_encode($images);
    }


    /**
    * Retourne une image par rapport à son id
    * @param String $imageId
    * @return Object Image or null
    */
    public function findById($imageId){
        $extensions = array('jpeg','jpg', 'png', 'gif');
        foreach ($extensions as $ext) {
            if (file_exists($this->folderDB."images/".$imageId.'.'. $ext)) {
                $image = new Image();
                $image->setFile($imageId.".".$ext);
                $image->setId($imageId);
                $meta = array();
                if(file_exists(App::getApp()->getConfig("dbFolder")."meta/".$imageId.".json"))
                    $meta = json_decode(file_get_contents(App::getApp()->getConfig("dbFolder")."meta/".$imageId.".json"),true)[0];
                $image->setMeta($meta);
                return $image;
                break;
            }
        };
        return null;
    }

}