<?php 
/**
* Classe qui gére l'upload d'un fichier
* @author Amaury Lavieille
**/

namespace MvcApp\Core;

use \Exception;

class Upload
{


	/**
	* @var String $name Nom du fichier
	*/
	protected $name;

	/**
	* @var String $extension Extension du fichier 
	*/
	protected $extension;
	
	/** 
	* @var String $tmp_name chemin temporaire du fichier
	*/
	protected $tmp_name;

	/**
	* @var String $error Message d'erreur recontré lors de l'upload
	*/
	protected $error;
	
	/**
	* constructeur 
	* @param $file an array of $_FILE
	*/
	public function __construct($file)
	{
		$this->name = $file["name"];
		$this->error = $file["error"];
		$this->extension = pathinfo($file["name"], PATHINFO_EXTENSION);
		$this->tmp_name = $file["tmp_name"];

	}

	/**
	* Vérifie si le fichier a bien était envoyé
	*/
	private function checkUploadFile()
	{
		$message = "";

		if ( $this->error ) {
			 switch ($errCode) {			 
				case UPLOAD_ERR_INI_SIZE:
					$message =  'taille du fichier supérieur à la valeur de la directive upload_max_filesize du fichier php.ini';
					break;
				 
				case UPLOAD_ERR_FORM_SIZE:
					$message = 'Taille du fichier supérieur à la valeur spécifiée par MAX_FILE_SIZE dans le formulaire';
				 	break;

				case UPLOAD_ERR_PARTIAL:
					$message = 'Fichier partiellement uploadé';
				 	break;

				case UPLOAD_ERR_NO_FILE:
					$message = 'Aucun fichier uploadé';
					 break;

				case UPLOAD_ERR_NO_TMP_DIR:
					$message = 'Pas de repertoire temporaire';
				 	break;

				case UPLOAD_ERR_CANT_WRITE:
					$message = 'Impossible d écrire sur le disque';
				 	break;

				default:
					$message = 'Erreur inconnue';
					break;
			}
		}

		if (!is_uploaded_file($this->tmp_name)) {
			$message = "Le fichier temporaire n'est pas un ficher uploadé";
		}

		if (!is_readable($this->tmp_name)) {
			$message = "Impossible de lire le fichier temporaire";
		}

		if ( $message != "" ) {
			throw new Exception($this->uploadErrCodeToString($this->uploadMeta['error']));
		}
	}

	/**
	* Crée le dossier d'upload si il n'existe pas 
	* @param String $uploadFolder chemin du dossier d'upload
	*/
	private function createFolder($uploadFolder)
	{
		if( ! file_exists($uploadFolder )) {
			mkdir($uploadFolder, 0777, true);
		}
	}


	/**
	* Generé un nom unique
	* @return String nom fichier
	*/
	public function generateName()
	{
		return uniqid().".".$this->extension;
	}
	

	public function save($uploadFolder)
	{
		$this->checkUploadFile($uploadFolder);
		$this->createFolder($uploadFolder);
		$fileName = $this->generateName();
		if(move_uploaded_file($this->tmp_name, $uploadFolder.$fileName)){
			return $fileName;
		}
		else{
			throw new Exception("Impossible d'envoyer le fichier");
		}
	}

}

