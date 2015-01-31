<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Manuel Zingaro
 * Date: 18/12/13
 * Time: 22.53
 * In questa classe, implementata con pattern singletton, sono istanziati, salvati in sessione e
 * ritornati tutti gli oggetti dedicati a lettura file di properties, configurazioni, puntamenti, credenziali db, lingua ...
 * In questo modo queste informazioni verranno caricate/instanziate una sola volta e recuperate in qualunque
 * parte del codice, ma se necessario sara' possibile
 * modificarle come previsto nel vecchio codice
 */


class initConfig {

    private static $inst = null;
    private static $settings;
    private static $config;
    private static $lang;
    private static $connect;
    private static $includer;

    /*
     * le operazioni devono essere eseguite nel load(), e il load deve essere chiamato solo dopo
     * che la classe è stata istanziata, in quanto alcuni oggetti potrebbero utilizzare
     *  a loro volta l'initConfig. E' importante quindi istanziare questa classe senza alcuna operazione,
     * nel construct, o quanto meno operazioni che non facciano riferimento alla medesima classe
     */
    private function __construct(){

    }

    private function load(){
        if(session_id() == '') {session_start();}
        self::$config = new Config();
        self::$config->loadProperties();
        self::$lang = new Lang(Lang::$defaultLang);
        self::$connect = new DBConnection(self::$config);
        self::$connect->DB_connect();

        if(!self::$connect){
            die();
        }
        $settingsDAO = new settingsDAO(self::$connect);
        self::$settings = $settingsDAO->getAllValues(1);
        self::$includer = new pageIncluder(self::$config);

        //$_SESSION['config']=self::$config;
        $_SESSION['lang']=self::$lang;
        //$_SESSION['connect']=self::$connect;
    }

    public static function getInstance(){
        if(self::$inst == null){
            $c = __CLASS__;
            self::$inst = new $c;
            self::$inst->load();
        }
           return self::$inst;
    }

    public function getLang($langStr = "")
    {

        $lang = &$_SESSION['lang'];
        if($langStr != "")
        {
            $lang->setLang($langStr);
        }
        return $lang;
    }

    public function getConfig(){
        //$config = &$_SESSION['config'];
        return self::$config;
    }


    public function getSettings()
    {
        return self::$settings;
    }
    public function updateSettings()
    {
        $settingsDAO = new settingsDAO(self::$connect);
        self::$settings = $settingsDAO->getAllValues(1);
    }

    public function getConnect(){
        //$connect =&$_SESSION['connect']; // TODECIDE - la salvo o no in sessione la connessione??'

        return self::$connect;
    }
    public function getIncluder(){
        //$connect =&$_SESSION['connect']; // TODECIDE - la salvo o no in sessione la connessione??'

        return self::$includer;
    }
}
?>