<?php

global $response;


$settings = $response -> getProperty("settings");
$url =  $response -> getProperty("url");
$host =  $response -> getProperty("host");
$base_path = $response -> getProperty("base_path");
$admins = $response -> getProperty("admins");

?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head><!-- Created by wiredlayer.com -->
    <?php

    initConfig::getInstance() -> getIncluder() -> includePage("admin_scripts");

    ?>

</head>
<body>
<div id="background_settings" class="background">
    <center>
        <div id="wrapper">
            <?php

            initConfig::getInstance() -> getIncluder() -> includePage("admin_menu");

            ?>
            <span class="Vdivider">
                    </span>
                    <span class="Odivider" style="display: none;">
                    </span>
                    <span id="admin_content" style="height: auto;">
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
                       <div style="width: 100%;padding: 25px;" >

                            <form action="<?php echo $host;?>/settings/update" id="settings_form"  enctype="multipart/form-data"  method="POST">
                                <table cellspacing="0" cellpadding="0" class="adapt">
                                    <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <div class="title"> <h3> Base </h3></div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="labels">
                                                Mail per i contatti
                                            </div>
                                        </td>
                                        <td>
                                            <div class="values">
                                                <input type="hidden" value="<?php echo "admin_mail"; ?>" name="keys[]" />
                                                <input size="30" type="text" value="<?php echo $settings['admin_mail'] ;?>" name="values[]" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="labels">
                                                Numero di telefono
                                            </div>
                                        </td>
                                        <td>
                                            <div class="values">
                                                <input type="hidden" value="<?php echo "admin_number"; ?>" name="keys[]" />
                                                <input size="30" type="text" value="<?php echo $settings['admin_number'] ;?>" name="values[]" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="labels">
                                                Label link FB Page
                                            </div>
                                        </td>
                                        <td>
                                            <div class="values">
                                                <input type="hidden" value="<?php echo "admin_page_fb_label"; ?>" name="keys[]" />
                                                <input size="30" type="text" value="<?php echo $settings['admin_page_fb_label'] ;?>" name="values[]" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="labels">
                                                Link FB Page
                                            </div>
                                        </td>
                                        <td>
                                            <div class="values">
                                                <input type="hidden" value="<?php echo "admin_page_fb"; ?>" name="keys[]" />
                                                <input size="30" type="text" value="<?php echo $settings['admin_page_fb'] ;?>" name="values[]" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <!--hr class="separetor" -->
                                            <br>
                                            <div class="title"><h3> Avanzate </h3> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p>
                                                <label>Meta-tag Principali<font size="1">(Separati da Comma ';')</font></label><br />
                                                <input type="hidden" value="<?php echo "meta_tag"; ?>" name="keys[]" />
                                                <input type="hidden" id="meta_tag_value" value="<?php echo $settings['meta_tag']; ?>" name="values[]" />
                                                <textarea name="meta_tag" id="meta_tag" cols="45" rows="5"> <?php echo $settings['meta_tag']; ?>"</textarea>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p>
                                                <label>Google Analytics<font size="1"></font></label><br />
                                                <input type="hidden" value="<?php echo "google_analytics_javascript"; ?>" name="keys[]" />
                                                <input type="hidden" id="google_analytics_javascript_value" value="<?php echo $settings['google_analytics_javascript']; ?>" name="values[]" />
                                                <textarea name="google_analytics_javascript" id="google_analytics_javascript" cols="45" rows="8"><?php echo $settings['google_analytics_javascript']; ?> </textarea>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <div style="text-align: right;">
                                                <input style="width: 60px;" type="submit" onClick="validateSettingsForm()" value="Salva" name="salva"/>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>

                            <form action="<?php echo $host;?>/settings/changepassword" method="POST">
                                <table border="0" class="adapt">
                                    <tboby>
                                        <tr>
                                            <td colspan="2">
                                                <br>
                                                <div class="title"><h3> Gestione utenti </h3> </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="title"> Cambia Password </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="170">
                                                <div class="labels">
                                                    User
                                                </div>
                                            </td>
                                            <td width="280">
                                                <div class="values">
                                                    <select name="username">
                                                        <option value="">Seleziona un utente</option>
                                                        <?php
                                                        while($riga = $admins->fetch_assoc())
                                                        {
                                                            echo "<option value='".$riga['username']."'>".ucfirst($riga['username'])."</option>";
                                                        }

                                                        ?>
                                                    </select>
                                                    <div class="suggest">*selezionare l'utente per cambiare la password</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="labels" style="margin-bottom: 0;">
                                                    Password
                                                </div>
                                            </td>
                                            <td>
                                                <div class="values" style="margin-bottom: 0;">
                                                    <input size="20" type="password" value="" name="password[]" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="labels">
                                                    Ripeti Password
                                                </div>
                                            </td>
                                            <td>
                                                <div class="values">
                                                    <input size="20" type="password" value="" name="password[]" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div style="text-align: right;">
                                                    <input style="width: 60px;" type="submit" value="Modifica" name="modifica"/>
                                                </div>
                                            </td>
                                        </tr>
                                    </tboby>
                                </table>
                            </form>

                            <form action="<?php echo $host;?>/settings/adduser" method="POST">
                                <table border="0" class="adapt">
                                    <tr>
                                        <td colspan="2">
                                            <div class="title"> Aggiungi Utente </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="170">
                                            <div class="labels">
                                                Username
                                            </div>
                                        </td>
                                        <td width="280">
                                            <div class="values">
                                                <input size="30" type="text" value="" name="username" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="labels" style="margin-bottom: 0;">
                                                Password
                                            </div>
                                        </td>
                                        <td>
                                            <div class="values" style="margin-bottom: 0;">
                                                <input size="20" type="password" value="" name="password[]" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="labels">
                                                Ripeti Password
                                            </div>
                                        </td>
                                        <td>
                                            <div class="values">
                                                <input size="20" type="password" value="" name="password[]" />

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div style="text-align: right;">
                                                <input style="width: 60px;" type="submit" value="Aggiungi" name="aggiungi"/>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </span>

            <br/>
            <br/>
            <br/>
            <br/>
        </div>
    </center>
</div>

<?php
    initConfig::getInstance() -> getIncluder() -> includePage("admin_scripts_post");
?>
</body>
</html>