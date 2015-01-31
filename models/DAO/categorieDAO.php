<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 08/03/13
 * Time: 21.05
 * To change this template use File | Settings | File Templates.
 */

class categorieDAO extends AbstractDAO
{

    private $getAllCategorie = "SELECT * FROM ! ";
    private $insertCategoria = "INSERT INTO ! ( nome_categoria) VALUES (!)";


    function __construct()
    {
        $this -> initDAO(__CLASS__);
        $this->tableName = "ga_categorie";
    }


    function getAllCategorie()
    {
        if($this->connection->getReady())
        {

            $sql = new QueryBuilder($this -> getAllCategorie);

            $sql -> setTable($this -> tableName);

            Logger::log(Logger::$INFO," Query sto recuperando tutte le categoria:".$sql->toQuery());
            $query = $this->connection->query($sql->toQuery());

            if($query !== false)
            {
                $num_results = $query->num_rows;
                if($num_results)
                {
                    return $query;
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
/*
    function insertAdmin($username,$password, $livello = 1)
    {
        if($this->connection->getReady())
        {

            $sql = new QueryBuilder($this -> insertAdmin);

            $sql -> setTable($this -> tableName);

            if(strlen($username) > 3 && strlen($password) == 32)
            {
                $sql -> setString($username);
                $sql -> setString($password);
                $sql -> setInt($livello);

                $query = $this->connection->query($sql->toQuery());


                if($query !== false)
                {
                    return true;
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
    }*/
}


?>