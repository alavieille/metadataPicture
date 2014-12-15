<?php 
/**
* Classe qui gère les roles
* @author Amaury Lavieille
*/
namespace MvcApp\Core;


class RoleManager
{
	protected $arrayRoles = array();

	public function __construct($roles)
	{
		$this->extractRole($roles);
	}


	/**
	* Extrait les roles definis dans un controlleur
	* @param Array $roles tableau qui définis les roles d'un controlleur
	*/
	protected function extractRole($roles)
	{

		foreach ($roles as $role) {

			
			$expression = isset($role["expression"]) ? $role["expression"] : null;
			//var_dump($expression);
			if($role["role"] == "*") { // tous les utilisateurs
				$this->arrayRoles[] = new RoleAllUser($role["role"],$role["actions"],$expression);
			}
			else if($role["role"] == "@") { // utilisateurs connecté
				$this->arrayRoles[] = new RoleLoggedUser($role["role"],$role["actions"],$expression);
			}
			else { // les autres roles
				$this->arrayRoles[] = new Role($role["role"],$role["actions"],$expression);
			}	
		}
	}

	/**
	* Verifie si un utilisateurs est autorisé à acceder à l'action 
	* @param String $action l'action demandé
	* @param Object $authUser instance de Auth
	*/
	public function validAccess($action, $authUser,$instanceController,$paramAction)
	{


		foreach ($this->arrayRoles as $role) {
			
			if($role->validAccess($action,$authUser,$instanceController,$paramAction)) {
				return true;
			}
		}
		throw new RoleException("Accés non autorisé");
		
	}
}