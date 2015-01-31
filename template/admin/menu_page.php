<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 07/12/14
 * Time: 18.22
 * To change this template use File | Settings | File Templates.
 */


global $response;

$host =  $response -> getProperty("host");
$url =  $response -> getProperty("url");

?>

<span id="admin_menu">

    <div id="logo">
        <img src="<?php echo $url; ?>../images/logo.png"/>
    </div>


    <ul>
        <li>
            <a href="<?php echo $host;?>/lavori/list">PROGETTI</a>
        </li>
        <li>
            <a href="<?php echo $host;?>/settings/view">SETTINGS</a>
        </li>
        <li>
            <a href="<?php echo $host;?>/amministrazione/logout">LOGOUT</a>
        </li>
    </ul>
</span>