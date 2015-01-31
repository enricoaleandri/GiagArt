<?php
require_once("system/AbstractDAO.php");
require_once("system/AbstractBean.php");
require_once("import.php");


error_reporting(E_ALL ^ E_NOTICE);
session_start();

date_default_timezone_set('UTC');

function autoload($class_name)
{
    // Pre callback
    $time_start = microtime(true);


    $autoloadDirs = array('models', 'classes', 'controllers','system','config', 'language', 'lib');

    foreach($autoloadDirs as $dir)
    {
        if(file_exists($dir.'/'.$class_name.'.php'))
        {
            require_once($dir.'/'.$class_name.'.php');
        }
    }

    if(file_exists($class_name.'.php'))
    {
        require_once($class_name.'.php');
    }
    Logger::log(Logger::$DEBUG, "autoloaded className $class_name");

    // Post callback
    $time_end =microtime(true);
    $time = $time_end - $time_start;
    Logger::log(Logger::$PROFILING,"Function : autoload - execution time : $time s");
}
spl_autoload_register('autoload');
Logger::log(Logger::$INFO, "Framework started! I'm gona register autoload");


Dispatcher::Run(initConfig::getInstance()->getConfig()->getProperty('base_path'));
?>