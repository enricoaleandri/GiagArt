<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 06/04/13
 * Time: 16.37
 * To change this template use File | Settings | File Templates.
 */
class Logger
{
    static $logPath = "./log";
    // TODO - aggiornare le variabili DEBUG,ERROR,INFO con i valori numerici memorizzati nell'array MODE
    //          Per risparmiare un giro inutile di variabili, la variabile poi una volta che verra passata
    //          al metodo log andra a interagire direttamente con la condizione di selezione dei log in base
    //          alla modalità
    static $PROFILING = "PROFILING";
    static $DEBUG = "DEBUG";
    static $ERROR = "ERROR";
    static $INFO = "INFO";

    static private $MODE  = array ("PROFILING" => 0, "DEBUG" => 1,"ERROR" => 2, "INFO" => 3);

    function __construct(){}
    static function logSUPER($log)
    {
        if(session_id() == '') {
            session_start();
        }
        date_default_timezone_set('UTC');

        $user = $_SERVER['REMOTE_ADDR'];

        $contenuto = "$user - ".date("d/n/Y H:i:s")." - SUPER MODE - $log \n";
        Logger::writeLog($contenuto);
    }
    static function log($logMode, $log)
    {

        if(session_id() == '') {
            session_start();
        }
        date_default_timezone_set('UTC');

        //TODO - Come si puo fare per utilizare la classe di log dentro la classe di caricamento delle configurazioni?
        //Gia verificato che va in errore se venisse chiamata la classe di logger dentro Config.lib
        //ps modificare l'else d'errrore nella classe config poiche in quella situazionr andrebbe a schiantare
        //tutto il sito per causa di ciclo infinito.
        $config = initConfig::getInstance()->getConfig();
        $debugMode = $config -> getProperty("debug_mode");
        $mode = Logger::$MODE[$debugMode];
        if(Logger::$MODE[$logMode] >= $mode)
        {
            $user = $_SERVER['REMOTE_ADDR'];

            $contenuto = "$user - ".date("d/n/Y H:i:s")." - $logMode - $log \n";
            Logger::writeLog($contenuto);
        }
    }
    static private function writeLog($contenuto)
    {
        $filename = Logger::$logPath.'/LOG_'.date("Ymd").".txt";


        // Let's make sure the file exists and is writable first.
        if(!file_exists($filename))
        {
            $fp = fopen($filename, 'w');
            fputs($fp, '');
            fclose($fp);
        }
        if (is_writable($filename))
        {

            // In our example we're opening $filename in append mode.
            // The file pointer is at the bottom of the file hence
            // that's where $somecontent will go when we fwrite() it.
            if (!$handle = fopen($filename, 'a'))
            {
                echo "Cannot open file ($filename)";
                exit;
            }

            // Write $somecontent to our opened file.
            if (fwrite($handle, mb_convert_encoding($contenuto,'iso-8859-2')) === FALSE)
            {
                echo "Cannot write to file ($filename)";
                exit;
            }

            //echo "Success, wrote to file ($filename)";
            fclose($handle);

        }
        else
        {
            echo "The file $filename is not writable";
        }
    }
    public static function setLogPath($logPath)
    {
        self::$logPath = $logPath;
    }

    public static function getLogPath()
    {
        return self::$logPath;
    }
}
?>