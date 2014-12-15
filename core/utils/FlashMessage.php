<?php
/**
* classe qui permet de gerer les message flahs
* @author Amaury Lavieille
*/
namespace MvcApp\Core;


/**
* Classe qui représente un message flash
*/
class FlashMessage
{
    
    /**
    * Contruit un message
    */
    public function __construct()
    {
        
    }   

    /**
    * Ajout un message flash
    * @param String $message contenue du message
    * @param String $type type du message
    */
    public static function setFlash($message,$type = "")
    {
        $_SESSION["flashApp"] = array(
            "message" => $message,
            "type" => $type
        );

    }
    
    /**
    * Recupére les messages flash
    * @return String
    */
    public static function getFlash()
    {
      
        //self::setFlash("test");
        if(isset($_SESSION["flashApp"])){
            $flashs = "";
            $flashs .= $_SESSION["flashApp"]["message"];
            unset($_SESSION["flashApp"]);
            return $flashs;
        }
        
    }
}
