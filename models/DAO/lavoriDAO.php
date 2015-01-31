<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Manuel Zingaro
 * Date: 18/12/13
 * Time: 13.04
 * To change this template use File | Settings | File Templates.
 */


class lavoriDAO extends AbstractDAO
{


    //private $getAllLavori = "SELECT * FROM ! WHERE deleted <> 1";
   // private $getAllLavori = "CALL lavori_da_visualizzare()";
    private $getAllLavori = "select * from ! as g inner join ( select max(id_lavoro ) as id, id_lavoro_parent as idp from ga_lavori as f 	where f.deleted = 0 	and f.id_lavoro_parent <> -1 	group by f.id_lavoro_parent union select id_lavoro as id, id_lavoro_parent as idp  from ga_lavori as f  where f.deleted = 0  and f.id_lavoro_parent = -1 and id_lavoro not in ( select id_lavoro_parent from ga_lavori where id_lavoro_parent <> -1)) as h on h.id = g.id_lavoro";
    private $getLavoroById = "SELECT * FROM ! WHERE deleted <> 1 and id_lavoro = !";
    private $deleteLavoroById = "UPDATE ! SET deleted = 1 WHERE id_lavoro = !";
    private $publishLavroById = "UPDATE ! SET status = 2 WHERE id_lavoro = !";
    private $insertLavoro = "INSERT INTO ! (`titolo`, `descrizione`, `categorie`, `tags`, `autore`, url_cover, `id_autore`, status, id_lavoro_parent, data_inserimento) VALUES (!, !, !, !, !, !, !, !, -1, NOW())";
    private $updateLavoroByID = "UPDATE ! SET `titolo`=!, `descrizione`=!, `categorie`=!, `tags`=!, `autore`=!, url_cover=!, `id_autore`=!, status=!, data_ultima_modifica=NOW() WHERE  `id_lavoro`=!";
    private $updateLavoro = "INSERT INTO ! (`titolo`, `descrizione`, `categorie`, `tags`, `autore`, url_cover, `id_autore`, status, id_lavoro_parent, data_ultima_modifica) VALUES (!, !, !, !, !, !, !, !, !, NOW())";


    function __construct()
    {
        $this -> initDAO(__CLASS__);
        $this->tableName = "ga_lavori";
    }


    function getAllLavori()
    {
        if($this->connection->getReady())
        {
            $sql = new QueryBuilder($this -> getAllLavori);

            $sql -> setTable($this -> tableName);

            Logger::log(Logger::$DEBUG, "getAllLavori: query = ".$sql->toQuery());
            $query = $this->connection->query($sql->toQuery());
            if($query !== false)
            {
                $num_results = $query->num_rows;
                if($num_results)
                {
                    $lavori = array();
                    while($riga = $query->fetch_assoc())
                    {

                        $lavoro = new lavoriBean($this -> settings);
                        $lavoro ->setIdLavoro($riga['id_lavoro']);
                        $lavoro ->setTitolo($riga['titolo']);
                        $lavoro ->setDescrizione($riga['descrizione']);
                        $lavoro ->setCategorie($riga['categorie']);
                        $lavoro ->setTags($riga['tags']);
                        $lavoro ->setUrlCover($riga['url_cover']);
                        $lavoro ->setAutore($riga['autore']);
                        $lavoro ->setIdAutore($riga['id_autore']);
                        $lavoro ->setStatus($riga['status']);
                        $lavoro ->setIdLavoroParent($riga['id_lavoro_parent']);
                        $lavoro ->setDataInserimento($riga['data_inserimento']);
                        $lavoro ->setDataUltimaModifica($riga['data_ultima_modifica']);
                        $lavoro ->setDataEliminazione($riga['data_eliminazione']);
                        $lavoro ->setDeleted($riga['deleted']);
                        $lavori[] = $lavoro;
                    }
                    return $lavori;

                }
                else
                {
                    Logger::log(Logger::$ERROR,"getAllLavori - Errore in recupero lavori. Non sono presenti record: error =".$this -> connection ->error . " numero di righe : ".$num_results);
                    return false;
                }
            }
            else
            {
                Logger::log(Logger::$ERROR,"getAllLavori - Errore in esecuzione query : error = ".$this -> connection ->error);
                return false;
            }

        }
        else
        {
            Logger::log(Logger::$ERROR,"getAllLavori - Attenzione errore in connessione al Database : error = ".$this -> connection ->error . " Connessione db non pronta : ".$this -> connection -> getReady());
            return false;
        }
    }

    function getLavoroById($idLavoro)
    {
        if($this->connection->getReady())
        {
            $sql = new QueryBuilder($this -> getLavoroById);

            $sql -> setTable($this -> tableName);

            $sql -> setInt($idLavoro);
            Logger::log(Logger::$DEBUG, "Sto per recuperare un lavoro by ID : query = ".$sql->toQuery());

            $lavoro = new lavoriBean($this -> settings);
            if($lavoro -> setIdLavoro($idLavoro))
            {

                $query = $this->connection->query($sql->toQuery());

                if($query !== false)
                {
                    $num_results = $query->num_rows;
                    if($num_results)
                    {
                        while($riga = $query->fetch_assoc())
                        {
                            $lavoro = new lavoriBean($this -> settings);
                            $lavoro ->setIdLavoro($riga['id_lavoro']);
                            $lavoro ->setTitolo($riga['titolo']);
                            $lavoro ->setDescrizione($riga['descrizione']);
                            $lavoro ->setCategorie($riga['categorie']);
                            $lavoro ->setTags($riga['tags']);
                            $lavoro ->setUrlCover($riga['url_cover']);
                            $lavoro ->setAutore($riga['autore']);
                            $lavoro ->setIdAutore($riga['id_autore']);
                            $lavoro ->setStatus($riga['status']);
                            $lavoro ->setIdLavoroParent($riga['id_lavoro_parent']);
                            $lavoro ->setDataInserimento($riga['data_inserimento']);
                            $lavoro ->setDataUltimaModifica($riga['data_ultima_modifica']);
                            $lavoro ->setDataEliminazione($riga['data_eliminazione']);
                            $lavoro ->setDeleted($riga['deleted']);
                        }
                        return $lavoro;

                    }
                    else
                    {
                        Logger::log(Logger::$ERROR,"getLavoroById - Errore in recupero lavoro. Non sono presenti record: error =".$this -> connection ->error . " numero di righe : ".$num_results);
                        return false;
                    }
                }
                else
                {
                    Logger::log(Logger::$ERROR,"getLavoroById - Errore in esecuzione query : error = ".$this -> connection ->error);
                    return false;
                }
            }
            else
            {
                Logger::log(Logger::$ERROR,"getLavoroById - Attenzione errore in setting idLavoro : id =".$idLavoro);
                return false;
            }

        }
        else
        {
            Logger::log(Logger::$ERROR,"getLavoroById - Attenzione errore in connessione al Database : error = ".$this -> connection ->error . " Connessione db non pronta : ".$this -> connection -> getReady());
            return false;
        }
    }


    function updateLavoroByID(LavoroBean $lavoroBean)
    {

        if($this->connection->getReady())
        {
            $sql = new QueryBuilder($this -> updateLavoroByID);

            $sql -> setTable($this -> tableName);

            $sql -> setString($lavoroBean -> getTitolo());
            $sql -> setString($lavoroBean -> getDescrizione());
            $sql -> setString($lavoroBean -> getCategorie());
            $sql -> setString($lavoroBean -> getTags());
            $sql -> setString($lavoroBean -> getUrlCover());
            $sql -> setString($lavoroBean -> getAutore());
            $sql -> setInt($lavoroBean -> getIdAutore());
            $sql -> setInt($lavoroBean -> getStatus());
            $sql -> setInt($lavoroBean -> getIdLavoro());
            $query = false;
            try
            {
                Logger::log(Logger::$DEBUG, "updateLavoroByID - Query update: ".$sql->toQuery());
                $query= $this->connection->query($sql->toQuery());

            }catch (Exception $e)
            {
                Logger::log(Logger::$ERROR, "updateLavoroByID  - Eccezione in  : $e\n");
            }

            if($query !== false)
            {
                Logger::log(Logger::$DEBUG, "updateLavoroByID - Query eseguita correttaente");

                return  true;
            }
            else
            {
                Logger::log(Logger::$ERROR, "updateLavoroByID - Query non eseguita");
                return false;
            }

        }
        else
        {
            return false;
        }
    }


    function deleteLavoroById($id){
        if($this->connection->getReady())
        {
            $sql = new QueryBuilder($this -> deleteLavoroById);

            $sql -> setTable($this -> tableName);
            $sql -> setInt($id);
            $query = false;
            try
            {
                Logger::log(Logger::$DEBUG, "deleteLavoroById - Query update: ".$sql->toQuery());
                $query = $this -> connection->query($sql->toQuery());

            }
            catch (Exception $e)
            {
                Logger::log(Logger::$ERROR, "deleteLavoroById - Eccezione in deleteLavoroById : $e\n");
            }

            if($query !== false)
            {
                Logger::log(Logger::$DEBUG, "deleteLavoroById - Query eseguita correttaente");
                return  true;
            }
            else
            {
                Logger::log(Logger::$ERROR, "deleteLavoroById - Query non eseguita");

                return false;
            }
        }
        else
        {
            return false;
        }
    }

    function publishLavoroById($id){
        if($this->connection->getReady())
        {
            $sql = new QueryBuilder($this -> publishLavroById);

            $sql -> setTable($this -> tableName);
            $sql -> setInt($id);
            $query = false;
            try
            {
                Logger::log(Logger::$DEBUG, "publishLavroById - Query update: ".$sql->toQuery());
                $query = $this -> connection->query($sql->toQuery());

            }
            catch (Exception $e)
            {
                Logger::log(Logger::$ERROR, "publishLavroById - Eccezione in publishLavroById : $e\n");
            }

            if($query !== false)
            {
                Logger::log(Logger::$DEBUG, "publishLavroById - Query eseguita correttaente");
                return  true;
            }
            else
            {
                Logger::log(Logger::$ERROR, "publishLavroById - Query non eseguita");

                return false;
            }
        }
        else
        {
            return false;
        }
    }
    //private $insertConcorso = "INSERT INTO ! (nome,descrizione, data_creazione, data_inizio, data_fine1, data_fine2, cover_url, giuria_url, deleted) VALUES (!, !, now(), !, !, !, !, !, !)";
    function insertLavoro(lavoriBean $lavoroBean){
        if($this->connection->getReady())
        {
            $sql = new QueryBuilder($this -> insertLavoro);

            $sql -> setTable($this -> tableName);

            $sql -> setString($lavoroBean -> getTitolo());
            $sql -> setString($lavoroBean -> getDescrizione());
            $sql -> setString($lavoroBean -> getCategorie());
            $sql -> setString($lavoroBean -> getTags());
            $sql -> setString("");
            $sql -> setString($lavoroBean -> getAutore());
            $sql -> setInt($lavoroBean -> getIdAutore());
            $sql -> setInt($lavoroBean -> getStatus());

            try
            {
                $this->connection->autocommit(false);
                Logger::log(Logger::$INFO," Query sto per inserire un lavoro : ".$sql->toQuery());
                $query = $this->connection->query($sql->toQuery());

                if($query !== false)
                {
                    $id_query  = $this->connection->query("SELECT LAST_INSERT_ID() as ID");
                    $id  = $id_query->fetch_assoc()['ID'];
                    Logger::log(Logger::$DEBUG," Memorizzo l'id che è stato generato :  ".$id);
                    $lavoroBean -> setIdLavoro($id);
                    $this->connection->autocommit(true);
                    $this->connection->commit();
                    return $lavoroBean;
                }
                else
                {
                    Logger::log(Logger::$ERROR,"Attenzione errore in esecuzione query : ".$this->connection->error);
                    $this->connection->rollback();
                    $this->connection->autocommit(true);
                    return false;
                }
            }
            catch (Exception $e)
            {
                $this->connection->rollBack();
                $this->connection->autocommit(true);
                Logger::log(Logger::$ERROR,"Errore in esecuzione query : " . $e->getMessage());
            }
        }

    }
    function updateLavoro(lavoriBean $lavoroBean){
        if($this->connection->getReady())
        {
            $sql = new QueryBuilder($this -> updateLavoro);

            $sql -> setTable($this -> tableName);

            $sql -> setString($lavoroBean -> getTitolo());
            $sql -> setString($lavoroBean -> getDescrizione());
            $sql -> setString($lavoroBean -> getCategorie());
            $sql -> setString($lavoroBean -> getTags());
            $sql -> setString("");
            $sql -> setString($lavoroBean -> getAutore());
            $sql -> setInt($lavoroBean -> getIdAutore());
            $sql -> setInt($lavoroBean -> getStatus());
            $sql -> setInt($lavoroBean -> getIdLavoroParent());

            try
            {
                $this->connection->autocommit(false);
                Logger::log(Logger::$INFO," Query sto per inserire un lavoro : ".$sql->toQuery());
                $query = $this->connection->query($sql->toQuery());

                if($query !== false)
                {
                    $id_query  = $this->connection->query("SELECT LAST_INSERT_ID() as ID");
                    $id  = $id_query->fetch_assoc()['ID'];
                    Logger::log(Logger::$DEBUG," Memorizzo l'id che è stato generato :  ".$id);
                    $lavoroBean -> setIdLavoro($id);
                    $this->connection->autocommit(true);
                    $this->connection->commit();
                    return $lavoroBean;
                }
                else
                {
                    Logger::log(Logger::$ERROR,"Attenzione errore in esecuzione query : ".$this->connection->error);
                    $this->connection->rollback();
                    $this->connection->autocommit(true);
                    return false;
                }
            }
            catch (Exception $e)
            {
                $this->connection->rollBack();
                $this->connection->autocommit(true);
                Logger::log(Logger::$ERROR,"Errore in esecuzione query : " . $e->getMessage());
            }
        }

    }
}
?>