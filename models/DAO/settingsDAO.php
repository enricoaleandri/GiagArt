<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 03/04/13
 * Time: 15.04
 * To change this template use File | Settings | File Templates.
 */
class settingsDAO extends AbstractDAO
{

    private $getValue = "SELECT * FROM ! WHERE name = ! AND livello >= !";
    private $getAllValues = "SELECT * FROM ! WHERE livello >= !";
    private $getNumberSetting = "SELECT COUNT(*) FROM !";
    private $updateSetting = "UPDATE ! SET value = ! WHERE  name = !";

    function __construct($connection = null)
    {
        if($connection != null)
            $this->connection = $connection;
        $this -> initDAO(__CLASS__);
        $this->tableName = "ga_settings";
    }


    function getValue($key, $livello)
    {
        if($this->connection->getReady())
        {

            $sql = new QueryBuilder($this -> getValue);

            $sql -> setTable($this -> tableName);

            $sql ->setInt($livello);

            if(strlen($key) > 0)
            {
                $sql -> setString($key);

                Logger::log(Logger::$INFO,$sql -> toQuery());

                $query= $this->connection->query($sql->toQuery());

                if($query !== false)
                {
                    $num_results = $query->num_rows;
                    if($num_results)
                    {
                        $riga = $query->fetch_assoc();
                        return $riga['value'];
                    }
                    else
                    {
                        Logger::log(Logger::$ERROR, " Nono sono state restituire righe dall'esecusione della query.");
                        return false;
                    }
                }
                else
                {
                    Logger::log(Logger::$ERROR,"L'esecuzione della query non è andato a buon fine : ".$this->connection->error);
                    return false;
                }
            }
            else
            {
                Logger:log(Logger::$ERROR, " La chiave : '$key' di livello : '$livello' Non è valida.");
                return false;
            }
        }
        else
        {
            Logger::log(Logger::$ERROR, "Connessione al db non pronta : ".$this->connection->getReady());
            return false;
        }
    }

    function getNumberSetting()
    {
        if($this->connection->getReady())
        {

            $sql = new QueryBuilder($this -> getNumberSetting);

            $sql -> setTable($this -> tableName);

            Logger::log(Logger::$INFO,$sql -> toQuery());

            $query= $this->connection->query($sql->toQuery());

            if($riga = $query->fetch_assoc())
            {
                return $riga[0];
            }
            else
            {
                Logger::log(Logger::$ERROR, "L'esecuzione della query non è andata a buon fine : ".$this->connection->error);
                return false;
            }

        }
        else
        {
            Logger::log(Logger::$ERROR, "Connessione al db non pronta : ".$this->connection->getReady());
            return false;
        }
    }

    function getAllValues($livello)
    {
        if($this->connection->getReady())
        {

            $sql = new QueryBuilder($this -> getAllValues);

            $sql -> setTable($this -> tableName);

            $sql ->setInt($livello);

            Logger::log(Logger::$INFO,$sql -> toQuery());

            $query = $this->connection->query($sql->toQuery());

            if($query !== false)
            {
                $num_results = $query->num_rows;
                if($num_results)
                {
                    $settings = array();
                    while($riga = $query->fetch_assoc())
                    {
                        $settings[$riga['name']] = $riga['value'];
                    }
                    return $settings;
                }
                else
                {
                    Logger::log(Logger::$ERROR, " Nono sono state restituire righe dall'esecusione della query.");
                    return false;
                }
            }
            else
            {
                Logger::log(Logger::$ERROR,"L'esecuzione della query non è andato a buon fine : ".$this->connection->error);
                return false;
            }

        }
        else
        {
            Logger::log(Logger::$ERROR, "Connessione al db non pronta : ".$this->connection->getReady());
            return false;
        }
    }

    function updateSettings($key, $value)
    {
        if($this->connection->getReady())
        {
            $sql = new QueryBuilder($this -> updateSetting);

            $sql -> setTable($this -> tableName);

            $sql ->setString($value);
            $sql ->setString($key);

            Logger::log(Logger::$INFO,$sql -> toQuery());

            $query= $this->connection->query($sql->toQuery());

            if($query !== false)
            {
                Logger::log(Logger::$DEBUG, "Query eseguita correttamente!");
                return true;
            }
            else
            {
                Logger::log(Logger::$ERROR, "Errore durante l'esecuzione della query ".$this->connection->error);
                return false;
            }

        }
        else
        {
            Logger::log(Logger::$ERROR, "Connessione al db non pronta : ".$this->connection->getReady());
            return false;
        }

    }

}
?>