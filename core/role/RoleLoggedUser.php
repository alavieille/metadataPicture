<?php 
/**
* Classe qui définit un role pour les utilisateurs connecté
* @author Amaury Lavieille
*/
namespace MvcApp\Core;


class RoleLoggedUser extends Role
{	

	/**
	* Verifie si un utilisateurs est autorisé
	* @param String $action action demandé
	* @param Object $userAuth Instance of Auth
	**/
	public function validAccess($action,$userAuth,$instanceController,$paramAction)
	{
		$validAction = ($userAuth->isLogged() && in_array($action, $this->actions));
		if($validAction) {
			$expression = true;
			if(! is_null($this->expression)) {
				$expression = $this->validExpression($instanceController,$paramAction);
		
			}
			return $expression;
		}
		return false;
	}

}