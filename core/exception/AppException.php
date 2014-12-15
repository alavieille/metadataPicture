<?php 
/**
* classe gère les erreurs 
* @author Amaury Lavieille
*/
namespace MvcApp\Core;


use \Exception;

/**
* Classe qui représente une erreur l'application
*/
class AppException extends Exception
{
    /**
    * squelette utilisé par le controlleur
    * @param string $layout
    */
    public $layout = "main";

    /**
    * Affiche l'erreur
    */
    public function display()
    {
        $message = $this->getMessage();
        $code = ($this->getCode() != 0) ? $this->getCode() : "";
        if(file_exists("views/error.php")) {
            $content = "";
            ob_start();
                require_once("views/error.php");
                $content = ob_get_contents();
            ob_end_clean();
            require_once("views/layout/".$this->layout.".php");
        }
        else {
            echo "Erreur : ".$code."\n";
            echo $message;
        }

    }

}
