<?php 
/**
* Classe fournissant une connexion à la base de donnée
* @author Amaury Lavieille
*/
namespace MvcApp\Core;


use PDO;

class Db
{

	/**
    * @param Array $instances Tableau contenant les classes qui herite de ModelDb
    */
    static $instances = array();

    /**
    * propriété contennat le lien pdo de connexion à la BD
    */
    protected $pdo;

    /**
    * constructeur privé qui initialise la connexion
    * @todo rendre le constructeur indépendant du nom des constantes
    */
    protected function __construct() {
        /**
        * tableau d'options pour le réglage de la connexion
        */
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

       	$dbConfig = App::getApp()->getConfig("db");
        $this->pdo = new PDO($dbConfig["dsn"], $dbConfig["user"], $dbConfig["pwd"], $options);
    }

    /**
    * desactive le clonage
    */
    private function __clone() {}

    /**
    * Méthode pour accéder à l'UNIQUE instance de la classe heritant de cette modèle
    * @return Object l'instance du singleton
    */
    public static function getInstance()
    {
        $calledClass = get_called_class();

        if (!isset(self::$instances[$calledClass]))
        {
             self::$instances[$calledClass] = new $calledClass();
        }

        return  self::$instances[$calledClass];
    }



    /**
    * Accesseur de la connexion
    *
    * @return L'identifiant de connexion BD à utiliser pour exécuter les requêtes
    */
    public function getConnexion() 
    {
        return $this->pdo;
    }
}
