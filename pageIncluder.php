<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 08/03/13
 * Time: 23.26
 *
 */

class pageIncluder
{
    private $page_path;
    private $config;
    function __construct($config)
    {
        $this->page_path = $config->getProperty("page_path")."/";
        $this->config = $config;
    }

    function includePage($page)
    {

        Logger::log(Logger::$DEBUG, "Pagina in inclusione-- path : ".$this->page_path."    Property : ".$this->config->getProperty($page));
        include($this->page_path.$this->config->getProperty($page));
    }
}


?>