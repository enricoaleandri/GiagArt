<?php

date_default_timezone_set('UTC');

global $response;
$url =  $response -> getProperty("url");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <?php

    initConfig::getInstance() -> getIncluder() -> includePage("scripts");
    global $response;
    $base_path = $response -> getProperty("base_path");

    $admins =  $response -> getProperty("admins");
    ?>
</head>
<body>
<div id="background">
    <?php
        initConfig::getInstance() -> getIncluder() -> includePage("menu");
    ?>
    <div id="Livello4"><img src="<?php echo $url; ?>images/shaman2.jpg"></div>
    </div>


    <?php

    initConfig::getInstance() -> getIncluder() -> includePage("scripts_post");
    ?>
</body>
</html>