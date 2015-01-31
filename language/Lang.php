<?php
class Lang
{

    private $langFilePath = "Language/lang/";
    static  $defaultLang = "IT";
    private $lang="";

    private $suffixLangFile = "_language.properties";
    private $properties;

    function __construct($lang){
        $this->lang = $lang;
        $this->loadProperties();
    }

    public function loadProperties()
    {
        $this -> properties = array();
        //TODO- aggiorna il controlo mettendolo prima, se la lingua passata nel costruttore non ha un file di properties
        //      corrispondente, bisognerebbe caricare la lingua di default che sicuramente dovrebbe essere presente
        if (!file_exists($this->getLanguageFile())){
            $this->langFilePath = "../" . $this->langFilePath;
            Logger::logSUPER("Loading lang properties from file by admin : ".$this->langFilePath);
        }
        if (file_exists($this->getLanguageFile()))
        {
            //Apro in lettura il file delle properties
            $leggi_file = fopen($this->getLanguageFile(),"r");

            while(!feof($leggi_file))
            {
                $row = fgets($leggi_file);
                //Verifica che la riga attuale non sia vuota o commentata con il carattere  '#'
                if(substr($row,0,1) != "#" && substr($row,0,1) != "" && substr($row,0,1) != " ")
                {
                    //Faccio uno split della riga con il carattere '='
                    $riga = explode("=",$row);
                    //Memorizzo il tutto in un bell'array. ps facendo particolare attenzione ai caratteri accapo o
                    //altro (non so di preciso quali) che vengono appesi alla fine della stringa di valore,
                    //piu precisamente sono due valori che io accuratamente rimuovo per una corretta stringa

                    //TODO - Verifica quali caratteri vengono appesi dall'explode
                    $this->properties[$riga[0]] = substr($riga[1],0,strlen($riga[1])-2);
                }
            }
            fclose($leggi_file);


        }
        else
        {
            Logger::log(Logger::$ERROR, " File di properties mancante : ".$this->getLanguageFile()." !!!");
        }
    }

    private function getLanguageFile()
    {
        if($this->lang != "")
        {
            Logger::log(Logger::$DEBUG, " File language :  ".$this->langFilePath.$this->lang.$this->suffixLangFile." !!!");
            return $this->langFilePath.$this->lang.$this->suffixLangFile;
        }
        else
        {
            Logger::log(Logger::$DEBUG, " File language :  ".$this->langFilePath.$this->lang.$this->suffixLangFile." !!!");
            return $this->langFilePath.$this::defaultLang.$this->suffixLangFile;
        }
    }


    public function getValue($key)
    {
        return $this->properties[$key];
    }


    public function getProperties()
    {
        return $this->properties;
    }

    /*
     * setto nuovamente la ligua solo se diversa da quella attualmente configurata
     */
    public function setLang($lang)
    {
        if($this->lang != $lang){
            $this->lang = $lang;
            $this->loadProperties();
        }
    }

    public function getLang()
    {
        return $this->lang;
    }
}

?>