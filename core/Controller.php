<?php

/**
* Classe parente qui représente un controlleur
* @author Amaury Lavieille
*/
namespace MvcApp\Core;


use MvcApp\Core\App;
/**
* Classe parente qui représente un controlleur
*/
Abstract class Controller
{
    /**
    * squelette utilisé par le controlleur
    * @var string $layout
    */
    public $layout = "main";

    /**
    * Nom du controlleur
    * @var string $name
    **/
    public $name;


    public $roleManager;

    /**
    * initialise un constructeur en générale
    **/
    public function __construct(){
        $this->roleManager = new RoleManager($this->roles());

    }

    abstract protected function roles();


    public function runAction($action,$param)
    {
     //   var_dump($this->roleManager->validAccess($action,App::getApp()->getAuth(),$this,$param));
        if($this->roleManager->validAccess($action,App::getApp()->getAuth(),$this,$param)){
            call_user_func_array(array($this,$action), $param);

            //$this->$action($param);
        }
    }


    /**
    * Inclut la vue definsi par $filename dans le layout
    * @param string $filename
    * @param Array $vars 
    */
    public function render($filename="",$vars=array())
    {
        $content = "";
        extract($vars);
        if($filename != ""){
            ob_start();
            require_once("views/".$this->name."/".$filename.".php");
            $content = ob_get_contents();
            ob_end_clean();
        }
        require_once("views/layout/".$this->layout.".php");
    }

    /**
    * Inclut la vue defini par $filename sans layout
    * @param string $filename
    * @param Array $vars 
    */
    public function renderPartial($filename="",$vars=array())
    {
        $content = "";
        extract($vars);
        if($filename != ""){
            require("views/".$this->name."/".$filename.".php");
        }
        
    }

}
