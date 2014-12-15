<?php 
require_once("config/init.php");
require_once("core/App.php");

use MvcApp\Core\App;
use MvcApp\Core\Router;
use MvcApp\Core\Route;
// var_dump($_GET);
$router = new Router();

/*
$route = new Route("article/create/","Dev2AL\Article\ArticleController","viewAllAction",array(2));
$router->addRoute($route);
*/
App::newApp($config,$router)->run();

