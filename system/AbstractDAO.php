<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 08/06/14
 * Time: 23.56
 * To change this template use File | Settings | File Templates.
 */
 abstract class  AbstractDAO
{

    protected $tableName;
    private $getColonne = "SHOW COLUMNS FROM !";
    private $getMaxIndexNumber = "SELECT LAST_INSERT_ID() as ID";


    protected $settings;
    protected $connection;
    protected function initDAO($classe)
    {
        $this->settings = initConfig::getInstance()->getSettings();
        $this->connection = initConfig::getInstance()->getConnect();
        Logger::log(Logger::$DEBUG,"Inizializzazione dato per tabella $this->tableName in classe :".$classe);
    }

     protected function  getColonne()
    {
         if($this->connection->getReady())
         {

             $sql = new QueryBuilder($this -> getColonne);

             $sql -> setTable($this -> tableName);
             //echo $sql->toQuery();
             $query = $this->connection->query($sql->toQuery());

             if($query !== false)
             {
                 $num_results = $query->num_rows;
                 if($num_results)
                 {
                     $colonne = array();
                     for($i = 0; $result = $query->fetch_assoc(); $i++)
                     {
                         $colonne[$i] = $result["Field"];
                     }
                     return  $colonne;
                 }
                 else
                 {
                     return false;
                 }

             }
             else
             {
                 return false;
             }
         }
         else
         {
             return false;
         }
     }

     protected function getMaxIndexNumber()
     {
         if($this->connection->getReady())
         {
             $sql = new QueryBuilder($this->getMaxIndexNumber);

             $sql -> setTable($this -> tableName);

             $query = $this->connection->query($sql->toQuery());

             if($query)
             {
                 $num_results = $query->num_rows;
                 if($num_results)
                 {
                     $id  = $query->fetch_assoc()['ID'];
                     Logger::log(Logger::$DEBUG," Memorizzo l'id che è stato generato :  ".$id);
                     return  $id;
                 }
                 else
                 {
                     return false;
                 }
             }
             else
             {
                 return false;
             }

         }
         else
         {
             return false;
         }
     }
 }
