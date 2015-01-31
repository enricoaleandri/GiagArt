<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Manuel Zingaro
 * Date: 19/12/13
 * Time: 18.42
 * To change this template use File | Settings | File Templates.
 * importo tutte le classi in questo file in modo da includere solo import.php
 * in questo modo si e' ovviato al problema del path, differente se si proveniva dall'admin
 */
require_once("commonConstants.php");
require_once("Logger.php");
require_once("language/Lang.php");
require_once("config/Config.php");
require_once("models/DBConnection.php");
require_once("models/queryBuilder.lib.php");
require_once("pageIncluder.php");
require_once("initConfig.php");

require_once("models/BEAN/lavoriBean.php");

require_once("models/DAO/lavoriDAO.php");
require_once("models/DAO/categorieDAO.php");
require_once("models/DAO/settingsDAO.php");
require_once("models/DAO/adminDAO.php");

require_once('lib/Unirest.php');
require_once('Utils.php');
?>