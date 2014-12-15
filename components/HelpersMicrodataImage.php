<?php 

namespace DevoirMetaAL\Components;

/**
* Classe qui permet d'affihcer les microdata des différentes métadonnées
*/
class HelpersMicrodataImage
{

	/**
	* Liste des microdatas déjà ajouté
	*/
	private $listAddMicrodata;
	
	/**
	* Correspondance des métadonnées File avec les microdata
	*/
	private $groupFile = array(
		"FileName"=>"contentUrl",
		"FileModifyDate"=>"dateModified",
		"FileSize"=>"contentSize",
		"ImageWidth"=>"height",
		"ImageHeight"=>"width"
	);

	/**
	* Correspondance des métadonnées Exif avec les microdata
	*/
	private $groupExif = array(
		"ImageWidth"=>"height",
		"ImageHeight"=>"width",
		"DateTimeOriginal"=>"dateCreated",
		"ImageWidth"=>"height",
		"ImageHeight"=>"width",
		"ExifImageWidth"=>"height",
		"ExifImageHeight"=>"width",
	);

	/**
	* Correspondance des métadonnées XMP avec les microdata
	*/
	private $groupXMP = array(
		"Creator"=>"author",
		"Description"=>"description",
		"Subject"=>"about",
		"Title"=>"name",
		"City"=>"contentLocation",
		"DateCreated"=>"dateCreated",
	);

	/**
	* Correspondance des métadonnées IPTC avec les microdata
	*/
	private $groupIPTC = array(
		"ObjectName"=>"name",
		"City"=>"contentLocation",
	);

	/**
	* Correspondance des métadonnées Composite avec les microdata
	*/
	private $groupComposite = array(
		"DateTimeCreated"=>"dateCreated",
	);

	/**
	* Constructeur
	*/
	public function __construct(){
		$this->listAddMicrodata = array();
	}

	/**
	* Retourne la microdata corerspondant selon la métédonnées 
	* définis par son groupe, son nom et sa valeur
	* @param $group Groupe de la metadonnées
	* @param $meta Nom de la metadonnées
	* @param $data Valeur de la metadonnées
	*/
	public function getMicrodata($group,$meta,$data){
		switch ($group) {
			case 'File':
				return $this->getGroupMicrodata($this->groupFile,$meta,$data);
			case 'EXIF':
				return $this->getGroupMicrodata($this->groupExif,$meta,$data);
			case 'XMP':
				return $this->getGroupMicrodata($this->groupXMP,$meta,$data);
			case 'IPTC':
				return $this->getGroupMicrodata($this->groupIPTC,$meta,$data);
			case 'Composite':
				return $this->getGroupMicrodata($this->groupComposite,$meta,$data);
			
			default:
				return "";
		}
	}


	/**
	* Recherche la microdata dans le tableau du group de la métadonnées
	* @param $arrayGroup Tableau de correspondance des microdata avec le groupe de la metadonnées
	* @param $meta Nom de la metadonnées
	* @param $data Valeur de la metadonnées
	**/
	private function getGroupMicrodata($arrayGroup, $meta, $data){
		$res = "";
		if(array_key_exists($meta, $arrayGroup) && ! in_array($arrayGroup[$meta], $this->listAddMicrodata)){
			$res .= "itemprop='".$arrayGroup[$meta]."'";
			array_push($this->listAddMicrodata, $arrayGroup[$meta]);
			if(in_array($arrayGroup[$meta], array("dateCreated","dateModified")))
				$res .= " content=".date("Y-m-d",strtotime($data));
		}
		return $res;
	}

}