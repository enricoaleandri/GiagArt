<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 08/03/13
 * Time: 21.05
 * To change this template use File | Settings | File Templates.
 */

class adminDAO extends AbstractDAO
{

    private $getAdminByUser = "SELECT * FROM ! WHERE username = !";
    private $getAllAdmin = "SELECT * FROM ! ";
    private $updateAdmin = "UPDATE ! SET password = ! WHERE username = !";
    private $insertAdmin = "INSERT INTO ! (id_admin, username, password) VALUES (NULL, !, !)";


    function __construct()
    {
        $this -> initDAO(__CLASS__);
        $this->tableName = "ga_admin";
    }


    function getAllAdmin()
    {
        if($this->connection->getReady())
        {

            $sql = new QueryBuilder($this -> getAllAdmin);

            $sql -> setTable($this -> tableName);

            Logger::log(Logger::$INFO," Query sto recuperando tutti gli user:".$sql->toQuery());
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
    }
    function updateAdmin($username,$password)
    {
        if($this->connection->getReady())
        {

            $sql = new QueryBuilder($this -> updateAdmin);

            $sql -> setTable($this -> tableName);

            if(strlen($username) > 3 && strlen($password) == 32)
            {
                $sql -> setString($password);
                $sql -> setString($username);

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
    }

    function getAdminByUser($user)
    {
        if($this->connection->getReady())
        {

            $sql = new QueryBuilder($this -> getAdminByUser);

            $sql -> setTable($this -> tableName);

            if(strlen($user) > 0)
            {
                $sql -> setString($user);

                $query = $this->connection->query($sql->toQuery());


                if($query !== false)
                {
                    $num_results = $query->num_rows;
                    if($num_results)
                    {
                        if($riga = $query->fetch_assoc())
                        {
                            return $riga;
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


?>