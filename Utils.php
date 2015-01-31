<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 08/06/14
 * Time: 20.28
 * To change this template use File | Settings | File Templates.
 */
class Utils
{

    static function ridimensionaFile($form_data, $ext, $newWidth)
    {


        // Salviamo le dimensioni originali dell’immagine
        list($width,$height)=getimagesize($form_data);

        // Passiamo alla creazione di un’altra immagine che diventerà quella BIG
        switch($ext)
        {
            case "jpg":
            case "jpeg":{$src = imagecreatefromjpeg($form_data);break;}
            case "gif":{$src = imagecreatefromgif($form_data);break;}
            case "png":{$src = imagecreatefrompng($form_data);break;}
            case "gif":{$src = imagecreatefromgif($form_data);break;}
            default: $src="";
        }

        $newHeight=($height/$width)*$newWidth;
        $tmp=imagecreatetruecolor($newWidth,$newHeight);

        // Creiamo l’immagine ridimensionata (solita procedura di sopra)
        imagecopyresampled($tmp,$src,0,0,0,0,$newWidth,$newHeight,$width,$height);

        // Salviamo l’immagine  sul server web
        $milliseconds = round(microtime(true) * 1000);
        $filename = "./temp/temp_". $milliseconds .".$ext";
        switch($ext)
        {
            case "pjpeg":
            case "jpg":
            case "jpeg":{imagejpeg($tmp,$filename,100);break;}
            case "x-png":
            case "png":{imagepng($tmp,$filename,9);break;}
            case "gif":{imagegif($tmp,$filename);break;}
        }

        // Cancelliamo adesso dalla memoria le immagini temporanee precedentemente create
        imagedestroy($src);
        imagedestroy($tmp);
        return $filename;
    }
    static function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++)
        {
            foreach ($file_keys as $key)
            {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }
    static function backwardStrpos($haystack, $needle, $offset = 0)
    {
        $length = strlen($haystack);
        $offset = ( $offset > 0 )? ( $length - $offset ): abs( $offset );
        $pos = strpos( strrev( $haystack ) , strrev( $needle ), $offset );
        return ( $pos === false ) ? false : ( $length - $pos - strlen( $needle ) );
    }

    static function isAPageException($array, $page)
    {
        for($i = 0; $i < count($array);$i++)
        {
            if($array == $page)
            {
                return true;
            }
        }
        return false;
    }

    static function getURLPathAdmin()
    {
        $sefl = substr($_SERVER['PHP_SELF'], 0 ,Utils::backwardStrpos($_SERVER['PHP_SELF'],"/",0));
        Logger::log(Logger::$DEBUG, "getURLPathAdmin() - sefl : $sefl");
        if(substr($_SERVER['PHP_SELF'], strlen($_SERVER['PHP_SELF'])-1 ,strlen($_SERVER['PHP_SELF'])) == "/"||
            strtolower(substr($sefl, strlen($sefl)-10 ,strlen($sefl))) == "/index.php")
            $sefl = substr($sefl, 0 ,Utils::backwardStrpos($sefl,"/",0));
        Logger::log(Logger::$DEBUG,"getURLPathAdmin() - sefl : $sefl   - $-SERVER[PHP_SELF] ".$_SERVER['PHP_SELF']);
        $path = initConfig::getInstance()->getConfig()->getProperty("page_path")."/";
        Logger::log(Logger::$DEBUG,"getURLPathAdmin() - page_path : ".initConfig::getInstance()->getConfig()->getProperty("page_path"));
        Logger::log(Logger::$DEBUG,"getURLPathAdmin() - return :  http://".$_SERVER['HTTP_HOST'].$sefl."/".$path."admin/");
        return  "http://".$_SERVER['HTTP_HOST'].$sefl."/".$path."admin/";
    }

    static function getURLPath()
    {
        $sefl = substr($_SERVER['PHP_SELF'], 0 ,Utils::backwardStrpos($_SERVER['PHP_SELF'],"/",0));
        Logger::log(Logger::$DEBUG, "getURLPath() - sefl : $sefl");
        if(substr($_SERVER['PHP_SELF'], strlen($_SERVER['PHP_SELF'])-1 ,strlen($_SERVER['PHP_SELF'])) == "/"||
            strtolower(substr($sefl, strlen($sefl)-10 ,strlen($sefl))) == "/index.php")
            $sefl = substr($sefl, 0 ,Utils::backwardStrpos($sefl,"/",0));
        Logger::log(Logger::$DEBUG,"getURLPath() - sefl : $sefl   - $-SERVER[PHP_SELF] ".$_SERVER['PHP_SELF']);
        $path = initConfig::getInstance()->getConfig()->getProperty("page_path")."/";
        Logger::log(Logger::$DEBUG,"getURLPath() - page_path : ".initConfig::getInstance()->getConfig()->getProperty("page_path"));
        Logger::log(Logger::$DEBUG, "getURLPath() - return : http://".$_SERVER['HTTP_HOST'].$sefl."/".$path);

        Logger::log(Logger::$DEBUG,"getURLPath() - return :  http://".$_SERVER['HTTP_HOST'].$sefl."/".$path);
        return  "http://".$_SERVER['HTTP_HOST'].$sefl."/".$path;
    }

    static function getHost()
    {
        $sefl = substr($_SERVER['PHP_SELF'], 0 ,Utils::backwardStrpos($_SERVER['PHP_SELF'],"/",0));
        Logger::log(Logger::$DEBUG, "getHost() - test : $sefl");
        if(substr($_SERVER['PHP_SELF'], strlen($_SERVER['PHP_SELF'])-1 ,strlen($_SERVER['PHP_SELF'])) == "/"||
            strtolower(substr($sefl, strlen($sefl)-10 ,strlen($sefl))) == "/index.php")
            $sefl = substr($sefl, 0 ,Utils::backwardStrpos($sefl,"/",0));
        Logger::log(Logger::$DEBUG,"getHost() -  sefl : $sefl   - $-SERVER[PHP_SELF] ".$_SERVER['PHP_SELF']);
        $path = initConfig::getInstance()->getConfig()->getProperty("page_path")."/";
        Logger::log(Logger::$DEBUG,"getHost() -  page_path : ".initConfig::getInstance()->getConfig()->getProperty("page_path"));
        Logger::log(Logger::$DEBUG, "getHost() - HTTP_HOST :".$_SERVER['HTTP_HOST']);
        Logger::log(Logger::$DEBUG, "getHost() - return : http://".$_SERVER['HTTP_HOST'].$sefl);

        return  "http://".$_SERVER['HTTP_HOST'].$sefl;
    }

    static function getHostAdmin()
    {
        $sefl = substr($_SERVER['PHP_SELF'], 0 ,Utils::backwardStrpos($_SERVER['PHP_SELF'],"/",0));
        Logger::log(Logger::$DEBUG, "getHostAdmin() - test : $sefl");
        if(substr($_SERVER['PHP_SELF'], strlen($_SERVER['PHP_SELF'])-1 ,strlen($_SERVER['PHP_SELF'])) == "/"||
            strtolower(substr($sefl, strlen($sefl)-10 ,strlen($sefl))) == "/index.php")
            $sefl = substr($sefl, 0 ,Utils::backwardStrpos($sefl,"/",0));
        Logger::log(Logger::$DEBUG,"getHostAdmin() - sefl : $sefl   - $-SERVER[PHP_SELF] ".$_SERVER['PHP_SELF']);
        $path = initConfig::getInstance()->getConfig()->getProperty("page_path")."/";
        Logger::log(Logger::$DEBUG,"getHostAdmin() - page_path : ".initConfig::getInstance()->getConfig()->getProperty("page_path"));
        Logger::log(Logger::$DEBUG, "getHostAdmin() - HTTP_HOST :".$_SERVER['HTTP_HOST']);

        Logger::log(Logger::$DEBUG,"getHostAdmin() - return :  http://".$_SERVER['HTTP_HOST'].$sefl."/admin");
        return  "http://".$_SERVER['HTTP_HOST'].$sefl."/admin";
    }
    static function clearUserValue($value)
    {
        if (get_magic_quotes_gpc())
        {
            $value = stripslashes($value);
        }
        $value = str_replace("\n", '', trim($value));
        $value = str_replace("\r", '', trim($value));
        return $value;

    }

    static function checkExtension($nome){
        //estraggo l'estensione dal nome del file
        $estensione = substr($nome, Utils::backwardStrpos($nome, ".",0)+1, strlen($nome));
        $estensione = strtolower($estensione);
        //recupero da properties le estensioni autorizzate all'upload e
        //le metto in un array per scorrerle tutte
        $ext = explode(",",  initConfig::getInstance()-> getSettings()['file_allowed_ext']);

        for($i = 0; $i < count($ext) ; $i++)
        {
            //se trovo l'estensione da controllare tra le estensioni autorizzare all'upload ritorno true
            //echo "estensione : ".$ext[$i]."   ".$estensione."<br>";
            if($ext[$i] == $estensione)
            {
                return true;
            }
        }
        //se non la trovo ritorno false
        return false;

    }
    static function checkType($type){

        $type = strtolower($type);
        //le metto in un array per scorrerle tutte
        $ext = explode(",",  initConfig::getInstance()-> getSettings()['file_allowed_ext']);

        for($i = 0; $i < count($ext) ; $i++)
        {
            //se trovo l'estensione da controllare tra le estensioni autorizzare all'upload ritorno true
            if("image/".$ext[$i] == $type)
            {
                return true;
            }
        }
        //se non la trovo ritorno false
        return false;
    }




     static function escape_data($data){
        if(ini_get('magic_quotes_gpc')){
            $data=stripslashes($data);
        }
        return mysql_real_escape_string(trim($data));
    }

    static function calcolaPrezzo($idConcorso,  $classe, $isSocio,$isCoppia, $nGruppo)
    {
        Logger::log(Logger::$INFO,"idConcorso : $idConcorso   classe : $classe     isSocio : $isSocio    isCoppia : $isCoppia    nGroppo : $nGruppo ");
        $connect = initConfig::getInstance()->getConnect();
        //$connect->DB_connect();

        $prezziDAO = new prezziDAO($connect);
        $concorsiDAO = new concorsiDAO($connect);

        $prezziVal = $prezziDAO->getAllPrezziByIdConcorso($idConcorso, $classe);
        $concorso = $concorsiDAO->getConcorsoById($idConcorso);

        if($prezziVal)
        {
            $today = new DateTime();
            if($today <= new DateTime($concorso -> getDataFine2()))
            {
                $prezzi = $prezziVal -> getPrezzi();
                if($today <= new DateTime($concorso -> getDataFine1()))
                {
                    $indexSocio = "1_".($isSocio == "true" || $isSocio == "1" ? "socio" :"non_socio");
                    Logger::log(Logger::$INFO, "[function] calcolaPrezzo() -  Iscrizione entro dataFine1,  Richiedente = $indexSocio");
                    $prezzo = $prezzi[$classe][$indexSocio];
                    if($isCoppia == "true" || $isCoppia == "1")
                    {
                        $prezzo+=$prezzi['coppia'][$indexSocio];
                    }
                    if($nGruppo > 0)
                    {
                        $prezzo += ($nGruppo * $prezzi['gruppo'][$indexSocio] );
                    }

                    return $prezzo;

                }
                else
                {
                    $indexSocio = "2_".($isSocio == "true" || $isSocio == "1" ? "socio" :"non_socio");
                    Logger::log(Logger::$INFO, "[function] calcolaPrezzo() -  Iscrizione entro dataFine2, Richiedente = $indexSocio");
                    $prezzo = $prezzi[$classe][$indexSocio];
                    if($isCoppia == "true" || $isCoppia == "1")
                    {
                        $prezzo += $prezzi['coppia'][$indexSocio];
                    }
                    if($nGruppo > 0)
                    {
                        $prezzo += ($nGruppo * $prezzi['gruppo'][$indexSocio] );
                    }
                    return $prezzo;


                }
            }
            else
            {
                Logger::log(Logger::$INFO, "[function] calcolaPrezzo - Concorso scaduto");
                return false;
            }
        }
        else
        {
            Logger::log(Logger::$ERROR, "[function] calcolaPrezzo -   Non ho trovato alcun prezzo per il concorso : ".$idConcorso);
            return false;
        }
    }


    static function getValueFromSession($value, $index = 0)
    {
        if(isset($_SESSION[$value]) )
            if(is_array($_SESSION[$value]))
                return $_SESSION[$value][$index];
            else
                return $_SESSION[$value];

        return "";
    }
}
