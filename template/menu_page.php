<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 30/11/14
 * Time: 22.44
 * To change this template use File | Settings | File Templates.
 */

global $response;
$url =  $response -> getProperty("url");
$host =  $response -> getProperty("host");
?>


<div id="logo">
    <img src="<?php echo $url; ?>images/logo.png"/>
</div>



<div id="menu">
    <span id="PORTFOLIO"><a href="<?php echo $host;?>/public/portfolio">PORTFOLIO</a></span>
    <span id="ABOUT"><a href="<?php echo $host;?>/public/about/">ABOUT</a></span>
    <span id="CONTACT"><a href="<?php echo $host;?>/public/contact">CONTACT</a></span>
</div>
