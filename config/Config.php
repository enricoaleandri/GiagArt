<?php

class Config
{


    private $configFile = "config/properties/config.properties";
    private $properties;

    function __construct(){

        $this->loadProperties();
        //$this->saveInSession();
        $this -> properties = array();

    }

    private function saveInSession()
    {
        $_SESSION['config'] = $this;
    }
    public function loadProperties()
    {
        $this->loadProperty();

        if(file_exists("config/properties/svil.properties")
            || file_exists("../config/properties/svil.properties"))
        {
            $this->configFile = "config/properties/svil.properties";
            $this->loadProperty();
            $this->configFile = "config/properties/config.properties";
        }

        if(file_exists("config/properties/page.properties")
            || file_exists("../config/properties/page.properties"))
        {
            $this->configFile = "config/properties/page.properties";
            $this->loadProperty();
            $this->configFile = "config/properties/config.properties";
        }

    }
    public function loadProperty()
    {

        Logger::logSUPER("Loading properties from file : ".$this->configFile);

        //se il file non esiste, potrebe non riconoscere il path perche' il flusso è partito da un percorso
        //differente al root, in questo caso root/admin, allora si aggiunge ../ in testa al path del configFile
        //per riportarlo alla root
        if (!file_exists($this->configFile)){
            $this->configFile = "../" . $this->configFile;
            Logger::logSUPER("Loading properties from file by admin : ".$this->configFile);
        }
        if (file_exists($this->configFile))
        {
            //Apro in lettura il file delle properties
            $leggi_file = fopen($this->configFile,"r");

            while(!feof($leggi_file))
            {
                $row = fgets($leggi_file);
                //Verifica che la riga attuale non sia vuota o commentata con il carattere  '#'
                if(substr($row,0,1) != "#" && substr($row,0,1) != "" && substr($row,0,1) != " ")
                {
                    //Faccio uno split della riga con il carattere '='

                    $pos = stripos($row, '=');
                    if($pos !==false)
                    {

                        $key=substr ( $row , 0, $pos );
                        $value=substr ( $row , $pos+1, strlen($row) );
                        //Logger::logSUPER("'$key' = '$value'");
                        $this->properties[$key] = substr($value,0,strlen($value)-2);

                        //Memorizzo il tutto in un bell'array. ps facendo particolare attenzione ai caratteri accapo o
                        //altro (non so di preciso quali) che vengono appesi alla fine della stringa di valore,
                        //piu precisamente sono due valori che io accuratamente rimuovo per una corretta stringa

                        //TODO - Verifica quali caratteri vengono appesi dall'explode

                        //VECCHIA GESTIONE - BEGIN
                        //$riga = explode("=",$row);
                        //$this->properties[$riga[0]] = substr($riga[1],0,strlen($riga[1])-2);
                        //VECCHIA GESTIONE - END


                        //$this->saveInSession();
                    }
                }
            }
            fclose($leggi_file);


        }
        else
        {
            Logger::logSUPER(" File di properties mancante : ".$this->configFile." !!!");
        }
    }

    public function getConfigFile()
    {
        return $this->configFile;
    }
    public function setConfigFile($configFile)
    {
        $this->configFile = $configFile;
    }

    public function getProperty($key)
    {
        if(isset($this->properties[$key]))
        {
            return $this->properties[$key];
        }
        else
        {
            return "???".$key."???";
        }
    }
    public function isSetted($key)
    {
        if(isset($this->properties[$key]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function getProperties()
    {
        return $this->properties;
    }
}

?>