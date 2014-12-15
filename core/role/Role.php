<?php 
/**
* Classe qui définit un role
* @author Amaury Lavieille
*/
namespace MvcApp\Core;


class Role
{	
	/**
	* @var Array $actions Nom des actions autorisées
	*/
	protected $actions;

	/**
	* @var String $name Nom du role
	**/
	protected $name;


	/**
	* @var Boolean Expression filtre le role selon une expression
	*/
	protected $expression;

	public function __construct($name,$actions,$expression=null)
	{
		$this->name = $name;
		$this->expression = $expression;
		//($this->expression);
		foreach ($actions as $key => $action) {
			$actions[$key] = $action."Action";
		}
		$this->actions = $actions;
	}


	protected function validExpression($instanceController,$paramAction)
	{
			return call_user_func_array(array($instanceController,$this->expression), $paramAction);
	}

	/**
	* Verifie si un utilisateurs est autorisé
	* @param String $action action demandé
	* @param Object $userAuth Instance of Auth
	**/
	public function validAccess($action,$userAuth,$instanceController,$paramAction)
	{
		$validAction = ($userAuth->getRole() == $this->name && in_array($action, $this->actions));
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