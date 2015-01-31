<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 10/12/14
 * Time: 1.40
 * To change this template use File | Settings | File Templates.
 */
    global $response;


    $settings = initConfig::getInstance()->getSettings();
    $url =  $response -> getProperty("url");
    $host =  $response -> getProperty("host");
    $base_path = $response -> getProperty("base_path");
    $lavoro = $response -> getProperty("lavoro");

?>


<!DOCTYPE html>
<html dir="ltr" lang="en-US">
    <head>
        <?php

        initConfig::getInstance() -> getIncluder() -> includePage("admin_scripts");

        ?>


    </head>
    <body>
        <div id="background_lavoro_view" class="background ">
            <center>
                <div id="wrapper">
                    <?php

                    initConfig::getInstance() -> getIncluder() -> includePage("admin_menu");

                    ?>
                    <span class="Vdivider">
                    </span>
                    <span class="Odivider" style="display: none;">
                    </span>
                    <span id="admin_content">
                        <div class="buttonWrap" onclick="window.location = '<?php echo $host; ?>/lavori/update/?id_lavoro=<?php echo $lavoro->getIdLavoro();?>';"><div class="addLavoro"> Modifica </div></div>

                        <div class="wrapper">
                            <span class="pictures">
                                <div class="covers">
                                    <?php
                                    $id = $lavoro->getIdLavoroParent() != "-1"  ? $lavoro->getIdLavoroParent() : $lavoro->getIdLavoro();
                                    if(file_exists('./data/images/lavori/'.$id."/cover"))
                                    {
                                        if ($handle = opendir('./data/images/lavori/'.$id."/cover"))
                                        {
                                            while (false !== ($entry = readdir($handle)))
                                            {
                                                if ($entry != "." && $entry != ".." && !is_dir('./data/images/lavori/'.$id."/cover/".$entry))
                                                {
                                                   echo '<img src="'.$url.'../../data/images/lavori/'.$id.'/cover/'.$entry.'" width=100% />';
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                         Nessuna Cover
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="slider">
                                    <div>
                                        <?php
                                        if(file_exists('./data/images/lavori/'.$id))
                                        {
                                            if ($handle = opendir('./data/images/lavori/'.$id))
                                            {
                                                while (false !== ($entry = readdir($handle)))
                                                {
                                                    if ($entry != "." && $entry != ".." && !is_dir('./data/images/lavori/'.$id."/".$entry))
                                                    {

                                                        echo '<img src="'.$url.'../../data/images/lavori/'.$id.'/'.$entry.'" style="float:left;" />';
                                                    }
                                                }
                                            }

                                        }

                                        ?></div>
                                </div>
                            </span>
                            <span class="details">
                                <div class="title">
                                    <h1><?php echo $lavoro->getTitolo(); ?></h1>
                                </div>
                                <div class="description">
                                    <b><?php echo $lavoro->getDescrizione(); ?></b>
                                </div>
                                <div class="category">
                                    <b><?php echo $lavoro->getCategorie(); ?></b>
                                </div>
                                <div class="tags">
                                    <?php
                                        $tags = explode(" ",$lavoro->getTags());
                                        for($i = 0 ; $i < count($tags) ; $i++)
                                        {
                                            echo "<div class='tagsRow'>";
                                            if($tags[$i])
                                            {
                                                echo "<span class='tag'>";
                                                echo $tags[$i];
                                                echo "</span>";
                                            }

                                             echo "</div>";
                                        }
                                    ?>
                                </div>
                            </span>
                        </div>
                    </span>
                </div>
            </center>

            <?php

            initConfig::getInstance() -> getIncluder() -> includePage("admin_scripts_post");
            ?>
        </div>
    </body>
</html>