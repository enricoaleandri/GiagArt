<?php

    global $response;


    $settings = initConfig::getInstance()->getSettings();
    $url =  $response -> getProperty("url");
    $host =  $response -> getProperty("host");
    $base_path = $response -> getProperty("base_path");
    $lavori = $response -> getProperty("lavori");

?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">
    <head>
        <?php

        initConfig::getInstance() -> getIncluder() -> includePage("admin_scripts");

        ?>


    </head>
    <body>
        <div id="background_home" class="background ">
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
                        <?php
                        if($response -> getError("errorMessage") != "" )
                        {
                            echo "  <article class='art-post art-article'>
                                        <div class='art-postmetadataheader'>
                                            <div class='message'>".$response -> getError("errorMessage")."</div>
                                        </div>
                                    </article>";
                        }
                        if($response -> getProperty("message") != "")
                        {
                            echo "  <article class='art-post art-article'>
                                        <div class='art-postmetadataheader''>
                                        <div class='message'>".$response -> getProperty("message")."</div>
                                        </div>
                                    </article>";
                        }
                        ?>
                        <div class="buttonWrap" onclick="window.location = '<?php echo $host;?>/lavori/insert';"><div class="addLavoro"> +</div></div>
                        <?php
                        if($lavori != false)
                        {
                            ?>


                            <table style="font-size: 13px;width: 100%;" cellspacing="0" cellpadding="0">
                                <tr style="background-color: #1B3542;height: 30px;vertical-align: middle;color: #FFF;">
                                    <td style=" width: 20%; ">
                                        <b>Titolo</b>
                                    </td>
                                    <td style=" width: 55%; ">
                                        <b>Descrizione</b>
                                    </td>
                                    <td style=" width: 15%; ">
                                        <b>Stato</b>
                                    </td>
                                    <td style=" width: 10%; ">
                                        <b>Azioni</b>
                                    </td>
                                </tr>
                                <?php
                                //Add each column value a node of the XML object
                                for ($i = 0 ; $i < count($lavori) ; $i++)
                                {

                                    if($i%2 == 1)
                                        echo "<tr data-id-lavoro='".$lavori[$i]->getIdLavoro()."'
                                                data-titolo='".$lavori[$i]->getTitolo()."' class='row row1' >";
                                    else
                                        echo "<tr data-id-lavoro='".$lavori[$i]->getIdLavoro()."'
                                                data-titolo='".$lavori[$i]->getTitolo()."' class='row row2' >";

                                    /*$keys = array_keys($iscrizioni[$i]);
                                    $iscrizioniNode = $xml->addChild('iscrizioni');
                                    for($y = 0; $y < count($keys) ; $y++)
                                    {
                                        $iscrizioniNode->addChild($keys[$y], $iscrizioni[$i][$keys[$y]]);
                                    }*/

                                    echo "<td class='clickable'>".(strlen($lavori[$i]->getTitolo()) < 20 ? $lavori[$i]->getTitolo() : substr($lavori[$i]->getTitolo(), 0, 20)."..." )."</td>";

                                    echo "<td class='clickable'>".(strlen($lavori[$i]->getDescrizione()) < 100 ? $lavori[$i]->getDescrizione() : substr($lavori[$i]->getDescrizione(), 0, 100)."..." )."</td>";

                                    if($lavori[$i]->getStatus() == 0)
                                    {
                                        echo "<td class='clickable'><font style='color:#c30700;font-weight: bold;'>Bozza</font></td>";
                                        echo "<td width='50'>
                                                <img title='Elimina Progetto' class='elimina_progetto' border='0' width='15' src='".$url."images/trash.gif' />
                                                <img title='Modfica Progetto' class='modifica_progetto' width='15' border='0' src='".$url."images/edit.gif' />
                                                <img title='Pubblica' class='pubblica' border='0' width='15' src='".$url."images/email-resend.png' />
                                             </td>";
                                    }
                                    else
                                        if($lavori[$i]->getStatus() == 1)
                                        {
                                            echo "<td colspan='1' class='clickable'><font style='color: #c8de3c;font-weight: bold;'> Privato </td>";
                                            echo "<td>
                                                    <img title='Elimina Progetto' class='elimina_progetto' border='0' width='15' src='".$url."images/trash.gif' />
                                                    <img title='Modfica Progetto' class='modifica_progetto' width='15' border='0' src='".$url."images/edit.gif' />
                                                    <img title='Pubblica' class='pubblica' border='0' width='15' src='".$url."images/email-resend.png' />
                                                 </td>";
                                        }
                                        else
                                            if($lavori[$i]->getStatus() == 2)
                                            {
                                                echo "<td class='clickable' style='color: #05A300;font-weight: bold;'> Pubblico </td>";
                                                echo "<td  width='50'>
                                                        <img title='Elimina Progetto' class='elimina_progetto' border='0' width='15' src='".$url."images/trash.gif' />
                                                        <img title='Modfica Progetto' class='modifica_progetto' width='15' border='0' src='".$url."images/edit.gif' />
                                                     </td>";
                                            }
                                            else
                                            {
                                                echo "<td class='clickable'> N/A </td>";
                                                echo "<td  width='50'>
                                                      </td>";
                                            }


                                    echo "</tr>";
                                }
                                ?>
                            </table>
                            <?php
                        }
                        else
                        {
                            echo "<h4> Non sono ancora presenti progetti!</h4>";

                        }
                        ?>
                    </span>
                </div>
            </center>
        </div>

        <?php

        initConfig::getInstance() -> getIncluder() -> includePage("admin_scripts_post");
        ?>
    </body>
</html>