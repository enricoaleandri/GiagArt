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
        $settings = initConfig::getInstance()->getSettings();

        ?>
	</head>
	<body>
		<div id="background">
            <?php
            initConfig::getInstance() -> getIncluder() -> includePage("menu");
            ?>
            <div id="contactArea">
                <span id="images">
                    <lu>
                        <li>
                            <img src="<?php echo $url; ?>images/icon_email.png"/>
                        </li>
                        <li>
                            <img src="<?php echo $url; ?>images/icon_tel.png"/>
                        </li>
                        <li>
                            <img src="<?php echo $url; ?>images/icon_page.png"/>
                        </li>
                    </lu>
                </span>
                <span id="text">
                    <lu>
                        <li>
                            <a href="mailto:<?php echo $settings['admin_mail']; ?>" ><?php echo $settings['admin_mail']; ?></a>
                        </li>
                        <li>
                            <?php echo $settings['admin_number']; ?>
                        </li>
                        <li>
                            <a href="<?php echo $settings['admin_page_fb']; ?>" style=""> <?php echo $settings['admin_page_fb_label']; ?></a>
                        </li>
                    </lu>
                </span>
            </div>
        </div>

    <?php

        initConfig::getInstance() -> getIncluder() -> includePage("scripts_post");
    ?>
 </body>
 </html>