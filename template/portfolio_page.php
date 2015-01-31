<?php

date_default_timezone_set('UTC');

global $response;
$url =  $response -> getProperty("url");
$lavori =  $response -> getProperty("lavori");
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


            <div class="portfolio">

                <?php
                    if($lavori != false)
                    {
                ?>

                        <div class="work">
                            <div class="gallery">
                                <?php
                                    //Add each column value a node of the XML object
                                    for ($i = 0 ; $i < count($lavori) ; $i++)
                                    {

                                ?>
                                            <?php
                                                if($lavori[$i] != null)
                                                {

                                                    ?>

                                                    <span class="pic<?php echo $i%4;?>">
                                                    <?php

                                                    $id = $lavori[$i]->getIdLavoroParent() != "-1"  ? $lavori[$i]->getIdLavoroParent() : $lavori[$i]->getIdLavoro();
                                                    if ($handle = opendir('./data/images/lavori/'.$id."/cover"))
                                                    {
                                                        while (false !== ($entry = readdir($handle)))
                                                        {
                                                            if ($entry != "." && $entry != ".." && !is_dir('./data/images/lavori/'.$id."/cover/".$entry))
                                                            {
                                                                echo '<img src="'.$url.'../../data/images/lavori/'.$id.'/cover/'.$entry.'" width="100%" />';
                                                            }
                                                        }
                                                    }

                                            ?>
                                                </span>
                                        <?php

                                                }
                                    }
                                        ?>

                            </div>
                        </div>
                <?php
                    }
                ?>
                <div class="work">
                    <div class="presentation">

                    </div>
                    <div class="gallery">

                    </div>
                </div>
            </div>
        </div>

    <?php

        initConfig::getInstance() -> getIncluder() -> includePage("scripts_post");
    ?>
 </body>
 </html>