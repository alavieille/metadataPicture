<?php
/**
* Classe qui gére le modèle en base de donnée
* @author Amaury Lavieille
*/

namespace MvcApp\Core;

use MvcApp\Core\Db;
use \PDO;


Abstract class ModelDB extends Db
{
    
    /**
    * @param String $dbName Nom de la table 
    */
    protected $tableName;

    /**
    * @param Nom de l'objet
    */
    protected $className;

    /**
    * @param clé primaire par défaut id
    */
    protected $pk = "id";

    private $createModelStatement;
    private $updateModelStatement;
    private $deleteModelStatement;
    private $findAllModelStatement;
    private $findLimitModelStatement;
    private $countAllModelStatement;
    private $findModelStatement;

    /**
    * Contructeur protégé, 
    * utiliser getInstance() pour acceder à l'instance de classe
    */
    protected function __construct()
    {

        parent::__construct();
        $this->createModelStatement = $this->createInsertQuery();
       	$this->updateModelStatement = $this->createUpdateQuery();
		$this->deleteModelStatement = $this->createDeleteQuery();
        $this->findAllModelStatement = $this->createSelectAllQuery();
        $this->findLimitModelStatement = $this->createSelectLimitQuery();
        $this->countAllModelStatement = $this->createCountAllQuery();
        $this->findModelStatement = $this->createSelectQuery();
    }


    abstract protected function queryData($model);


    abstract protected function partQuery() ;

  	
  	/* === INSERT === */
    /**
    * Créer la requête preparée pour l'insertion du modele
    * @return PDO statement 
    */
    protected function createInsertQuery()
    {
        $query = "INSERT INTO ".$this->tableName." ".$this->partQuery();
        return $this->pdo->prepare($query);
    }


    /**
    * Sauvegarde un modele dans la base de donnée
    * @var Object $model
    */
    public function save($model)
    {    
        $this->createModelStatement->execute($this->queryData($model));
        return $this->pdo->lastInsertId();
    }



    /* === UPDATE === */

    /**
    * Créer la requête preparée pour la mise jour du modele
    * @return PDO statement 
    */
    private function createUpdateQuery()
    {

        $query = " UPDATE ".$this->tableName." ".$this->partQuery()." WHERE ".$this->pk."=:pk";
        return $this->pdo->prepare($query);
    }   

    /**
    * Met à jour un modele dans la base de donnée
    * @var Object $model
    */
    public function update($model)
    {     
    	$paramPk = $this->pk;
    	$data = array(":pk"=> $model->$paramPk);
    	$data += $this->queryData($model);
        $this->updateModelStatement->execute($data);    
        return $model->$paramPk;
    }


    /* == DELETE == */

     /**
    * Créer la requête preparée pour la supprésion du modele
    * @return PDO statement 
    */
    private function createDeleteQuery()
    {
        $query = "DELETE FROM ".$this->tableName." WHERE ".$this->pk."=:pk";
        return $this->pdo->prepare($query);
    }

    /**
    * Supprimer un modele
    * @var Object $model
    */
    public function delete($model)
    {       
        $paramPk = $this->pk;
        $this->deleteModelStatement->bindValue(":pk",$model->$paramPk);
        $this->deleteModelStatement->execute(); 

    } 

    

    /* == SELECT */

    /**
    * Crée la requête préparée pour la selection de tous les lignes
    * @return PDO statement
    */
    public function createSelectAllQuery()
    {
        $query = "  SELECT * FROM ". $this->tableName." ORDER BY ".$this->pk." desc";
        return $this->pdo->prepare($query);
    }    

    /**
    * Cherche tous les lignes
    * @return Array array of model
    */
    public function findAll()
    {
        $this->findAllModelStatement->execute();
        $res = array();
        while (($ligne = $this->findAllModelStatement->fetch()) !== false) {
        	 $res[] = call_user_func($this->className.'::initialize',$ligne);
        } 
        return $res;
    }

    /*
    * Crée la requête préparée pour la selection de $nbrligne lignes à partir de $offset 
    * @return PDO statement
    */
    public function createSelectLimitQuery()
    {
        $query = "  SELECT * FROM ". $this->tableName." ORDER BY id desc LIMIT :offset,:nbrligne";
        return $this->pdo->prepare($query);
    }    


    /**
    * Cherche les $nbrLigne à partir de $offset
    * @param int $offset Début de la recherche
    * @param int $nbrLigne Nombre de ligne à rechercher
    * @return Array array of model
    */
    public function findLimit($offset,$nbrligne)
    {
  
        $this->findLimitModelStatement->bindValue(":offset",$offset,PDO::PARAM_INT);
        $this->findLimitModelStatement->bindValue(":nbrligne",$nbrligne,PDO::PARAM_INT);
        $this->findLimitModelStatement->execute();
        $res = array();
        while (($ligne = $this->findLimitModelStatement->fetch()) !== false) {
            $res[] = call_user_func($this->className.'::initialize',$ligne);
        } 
        return $res;
    }


    /**
    * Crée la requête préparée pour la selection d'une ligne
    * @return PDO statement
    */
    public function createSelectQuery()
    {
        $query = "  SELECT * FROM ". $this->tableName." WHERE ".$this->pk."=:pk";
        return $this->pdo->prepare($query);
    }


    /**
    * Cherche une ligne
    * @return Object Model if exist else return null
    */
    public function find($id)
    {  
        $this->findModelStatement->bindValue("pk",$id);
        $this->findModelStatement->execute();
        if($ligne = $this->findModelStatement->fetch()) {
            return call_user_func($this->className.'::initialize',$ligne);
        }
        return null;
    }

    /**
    * Cherche une ligne
    * @return Object Model if exist else return null
    */
    public function findByattribute($attribute,$value)
    {  
        

        $query = "  SELECT * FROM ". $this->tableName." WHERE ".$attribute."='".$value."'";
        $find = $this->pdo->query($query);
        if($ligne = $find->fetch()) {
            return call_user_func($this->className.'::initialize',$ligne);
        }
        return null;
    }


    /*
    * Crée la requête préparée pour compter le nombre de ligne
    * @return PDO statement
    */
    public function createCountAllQuery()
    {
        $query = "  SELECT count(*) as nbr FROM ". $this->tableName;
        return $this->pdo->prepare($query);
    }




    /**
    * Comtpe le nombre de ligne
    * @return integer
    */
    public function countAll()
    {
        $this->countAllModelStatement->execute();
        if($ligne = $this->countAllModelStatement->fetch()) {
            return (int) $ligne["nbr"];
        }
        return 0;
    }

}