<?php
/**
* Classe qui représente le modèle Image
* @author Amaury Lavieille
*/
namespace DevoirMetaAL\Image;

use MvcApp\Core\Model;


class Image extends Model{


    private $id;

    private $file;

    private $meta;

    /**
    * Crée un objet Image
	* @param array $data liste des données
    */
	public function __construct($data=array()) 
    {
        parent::__construct();
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->file = isset($data['file']) ? $data['file'] : null;
        $this->meta = isset($data['meta']) ? $data['meta'] : array();
    }


    /**
    * Accesseur file
    * @return String
    */
    public function getFile(){
    	return $this->file;
    }

    /**
    * Mutateur file
    * @param String file
    */
    public function setFile($file){
        $this->file = $file;
    }

    /**
    * Mutateur id
    * @return String
    */
    public function getId(){
        return $this->id;
    }

    /**
    * Accesseur id
    * @param String id
    */
    public function setId($id){
        $this->id = $id;
    }

    /**
    * Accesseur metadonnées
    * @return Array
    */
    public function getMeta(){
        return $this->meta;
    }

    /**
    * Mutateur metadonnées
    * @param Array meta
    */
    public function setMeta(Array $meta){
        $this->meta = $meta;
    }

    /**
    * Accesseur a une métadonnées d'un groupe spécifié
    * @param group Groupe de la métdaonnée
    * @param name Nom de la mete
    * @return le contenue de la meta ou null si elle existe pas
    */
    public function getMetaAttr($group, $name){
        // var_dump($this->meta);
        $res = null;
        if(array_key_exists($group, $this->meta) &&  array_key_exists($name, $this->meta[$group]) )
            $res = $this->meta[$group][$name];
        return $res;
    }

    public function getJsonData(){
        $var = get_object_vars($this);
        return $var;
     }

}
