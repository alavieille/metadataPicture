<?php 
/**
* Controlleur principale du site
* @author Amaury Lavieille
*/
namespace DevoirMetaAL\Site;

use MvcApp\Core\Controller;
use MvcApp\Core\App;
use MvcApp\Core\AppException;



/**
* Controlleur du site
*/
class SiteController extends Controller
{

 	/**
    * initialise le controlleur du site
    */
    public function __construct()
    {
        $this->name = 'Site';
        parent::__construct();
    }

    
    protected function roles()
    {
      return array(
        array(
            "role" => "*",
            "actions" => array("index"),  
            )
        );
        //new ImageDB::getInstance()->findAl
    }

	public function indexAction(){
		//var_dump("test");
        $this->render();
	}



		
}