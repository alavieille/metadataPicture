<?php 

namespace DevoirMetaAL\Components;

/**
* Classe qui permet de gerer l'extraction, la modification
* des données exif
* @author Amaury Lavieille
*/
class MetaExif {

	/**
	* Extrait les données exif d'un fichier
	* @param String $file chemin du fichier
	* @param Array 
	*/
	public static function extractExif($file){
		$cmd = "exiftool -g0 -json ".$file;
		$output = self::execCmdExif($cmd);
		$meta = json_decode(implode("",$output),true);
		return $meta;
	}
	/**
	* Met à jour les métadonnées d'un fichier
	* @param  String $file chemin du fichier
	* @param Array meta : array("name"=>"value", ...)
	*/
	public static function updateExifMeta($file,$meta){
		$cmd = "exiftool ";
		foreach ($meta as $name => $value) {
			$name = str_replace(" ", "", $name);
			$cmd .='-'.$name.'="'.trim($value).'" ';
			// $temp ="-".$name."='".$value."' ";
		}
		$cmd .= $file;
		return self::execCmdExif($cmd);
	}

	public static function extractXMP($file){
		$cmd = "exiftool -xmp -b ".$file;

		return implode("\n",self::execCmdExif($cmd));
	}

	/**
	* Exécute une commande et retourne son résultat
	* @param String $cmd
	* @param output Array
	*/
	private static function execCmdExif($cmd){
		exec($cmd,$output);
        return $output;
	}




}