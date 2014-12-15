<?php 
/**
* Gestion de la connexion
* @author Amaury lavieille
*/

namespace MvcApp\Core;

class AuthManager
{

  
    protected static $instance = null;
    protected $auth;

    private function __construct()
    {
        if (isset($_SESSION['auth']) && isset($_SESSION['auth']["value"]) && isset($_SESSION['auth']["role"])) {
            $this->auth = new Auth(true,$_SESSION["auth"]["role"],$_SESSION["auth"]["value"]);
        } 
        else {
            $this->auth = new Auth();
        }
    }

    private function __clone() {}

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function login($user,$role)
    {
        $this->auth = new Auth(true,$role,$user);
        $_SESSION["auth"]["role"] = $role;
        $_SESSION["auth"]["value"] = $user;
    }	

    public function logout()
    {
    	unset($_SESSION["auth"]["role"]);
        unset($_SESSION["auth"]["value"]);
        $this->auth = new Auth();
    }

    public function getAuth()
    {
        return $this->auth;
    }

}

