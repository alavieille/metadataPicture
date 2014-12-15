<?php 
/**
* classe qui gére les routes de l'application
* @author Amaury Lavieille
*/

namespace MvcApp\Core;

class Router{

	private $routes=array(); 

	//public function __construct();

  	public function addRoute($route)
  	{
   	 	$this->routes[] = $route;
  	}

  	public function getRoutes()
  	{
  		return $this->$routes;
  	}

    /**
    * Retourne le controlleur et l'action demande dans l'url
    * @return Array 
    **/
    private function createDefaultRoute($path)
    {

      $routeArray = explode("/",$path);

      $controller = $routeArray[0];
      $action = (isset($routeArray[1]) && $routeArray[1] != "") ? $routeArray[1] : "index";
      $param = array_slice($routeArray, 2);

      $controllerName = ucfirst($controller);
      $classController = $controllerName."Controller";
      $classController = App::getApp()->getConfig("namespaceApp")."\\".$controllerName."\\".$classController;
     
      $action = $action."Action";

      return new Route($path,$classController,$action,$param);
      

    }

    /** 
    * Retourne la route demandé par l'utilisateur
    * @param String $request
    */
    public function route($request)
    {
;

      $path = (! is_null($request->getGetIndex("p")) && ($request->getGetIndex("p") != "" ) ? $request->getGetIndex("p") : App::getApp()->getConfig("defaultController") );
      foreach ($this->routes as $route) {

        if($route->match($path)) {
            return $route;
        }
      }
       return $this->createDefaultRoute($path);

    }



}