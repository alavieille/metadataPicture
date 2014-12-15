<?php 
/**
* classe qui représente une route
* @author Amaury Lavieille
*/

namespace MvcApp\Core;


class Route
{	

	private $path;
	public $controllerClass;
	private $action;
	private $param;

	public function __construct($path,$controllerClass,$action="index",$param=array())
	{
		$this->path = $path;
		$this->controllerClass = $controllerClass;
		$this->action = $action;
		$this->param = $param;
		$this->cleanArrayParam();
	}

	private function cleanArrayParam()
	{

		foreach ($this->param as $key => $param) {
			if(trim($param) == "") {
				unset($this->param[$key]);
			}
		}
	}

	public function match($request)
	{
		return $this->path === $request;
	}

	public function getController()
	{
		return  $this->controllerClass;
	}

	public function getAction()
	{
		return $this->action;
	}

	public function getParam()
	{
		return $this->param;
	}
}
