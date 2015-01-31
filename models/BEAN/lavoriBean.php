<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 30/11/2014
 * Time: 13.38
 * To change this template use File | Settings | File Templates.
 */
class lavoriBean extends AbstractBean
{
    private $id_lavoro;
    private $titolo;
    private $descrizione;
    private $categorie;
    private $tags;
    private $url_cover;
    private $autore;
    private $id_autore;
    private $status;
    private $id_lavoro_parent;
    private $data_inserimento;
    private $data_ultima_modifica;
    private $data_eliminazione;
    private $deleted;


    public function __construct()
    {
        $this->initBean();
    }

    public function setAutore($autore)
    {
        $this->autore = $autore;
    }

    public function getAutore()
    {
        return $this->autore;
    }

    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
        return true;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setDataEliminazione($data_eliminazione)
    {
        $this->data_eliminazione = $data_eliminazione;
        return true;
    }

    public function getDataEliminazione()
    {
        return $this->data_eliminazione;
    }

    public function setDataInserimento($data_inserimento)
    {
        $this->data_inserimento = $data_inserimento;
        return true;
    }

    public function getDataInserimento()
    {
        return $this->data_inserimento;
    }

    public function setDataUltimaModifica($data_ultima_modifica)
    {
        $this->data_ultima_modifica = $data_ultima_modifica;
        return true;
    }

    public function getDataUltimaModifica()
    {
        return $this->data_ultima_modifica;
    }

    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return true;
    }

    public function getDeleted()
    {
        return $this->deleted;
    }

    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
        return true;
    }

    public function getDescrizione()
    {
        return $this->descrizione;
    }

    public function setIdAutore($id_autore)
    {
        $this->id_autore = $id_autore;
        return true;
    }

    public function getIdAutore()
    {
        return $this->id_autore;
    }

    public function setIdLavoro($id_lavoro)
    {
        $this->id_lavoro = $id_lavoro;
        return true;
    }

    public function getIdLavoro()
    {
        return $this->id_lavoro;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
        return true;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTitolo($titolo)
    {
        $this->titolo = $titolo;
        return true;
    }

    public function getTitolo()
    {
        return $this->titolo;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return true;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setIdLavoroParent($id_lavoro_parent)
    {
        $this->id_lavoro_parent = $id_lavoro_parent;
        return true;
    }

    public function getIdLavoroParent()
    {
        return $this->id_lavoro_parent;
    }

    public function setUrlCover($url_cover)
    {
        $this->url_cover = $url_cover;
        return true;
    }

    public function getUrlCover()
    {
        return $this->url_cover;
    }



}
?>