<?php 
/**
* Classe qui représente un utilisateur connecté
* @author Amaury lavieille
*/

namespace MvcApp\Core;

class Auth
{
	protected $isLogged;
    protected $role;
    protected $value;


    public function __construct($isLogged=false,$role=null,$value=null)
    {
    	$this->isLogged = $isLogged;
    	$this->role = $role;
    	$this->value = $value;
    }


    public function isLogged()
    {
    	return $this->isLogged;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getRole()
    {
        return $this->role;
    }
}


