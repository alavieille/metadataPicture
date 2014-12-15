<?php
/**
* Classe qui représente un modèle
* @author Amaury Lavieille
*/
namespace MvcApp\Core;


Abstract class Model
{
    protected $errors;

    protected function __construct(){}

    /**
    * Nettoie les variables
    * @param Array $arrayVar
    * @return Array Tableau des varibles nettoyées
    */
    public function cleanVar($arrayVar)
    {
        $arrayRes = array();
        foreach ($arrayVar as $name => $var) {
            $arrayRes[$name] = trim(htmlentities($var));
        }
        return $arrayRes;
    }


    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property,$value)
    {
        return $this->$property = $value;
    }

    /**
    * Retourne le tableau des erreurs
    * @return Array
    */
    public function getErrors(){
        return $this->errors;
    }

    
    /**
    * ajoute une erreur
    * @param String $key nom de l'input 
    * @param String $value Message de l'erreur
    * @return Array
    */
    public function setErrors($key,$value){
        return $this->errors[$key]=$value;
    }

}
