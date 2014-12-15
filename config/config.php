<?php 
// configuration de l'application

$config = array(
	// nom de l'application 
	"appName" => "Devoir métadonnées", 
	//namespace principale utilisé dans vos classe( ex: MonApli/Exemple)
	"namespaceApp" => "DevoirMetaAL",
	"path" =>"http://" . $_SERVER['HTTP_HOST'].str_replace("index.php","",$_SERVER["SCRIPT_NAME"]),
	"basePath" => str_replace("index.php","",$_SERVER["SCRIPT_NAME"]),
	// controlleur par defaut
	"defaultController" => "image", 
	//rmq:action par defaut index
	"dbFolder"=>"databaseImage/",
	// information de connexion à la base de donnée
	'db'=>array(
			'dsn' => 'mysql:host=localhost;dbname=Dev2',
			'user' => 'localhost',
			'pwd' => 'localhost',
		),
	);
