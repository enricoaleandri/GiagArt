<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 10/12/14
 * Time: 2.22
 * To change this template use File | Settings | File Templates.
 */

global $response;


$settings = initConfig::getInstance()->getSettings();
$url =  $response -> getProperty("url");
$host =  $response -> getProperty("host");
$base_path = $response -> getProperty("base_path");
$categorie = $response -> getProperty("categorie");

?>


<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <?php

    initConfig::getInstance() -> getIncluder() -> includePage("admin_scripts");

    ?>

    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- Generic page styles -->

    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="<?php echo $url;?>css/jquery.fileupload.css">
    <link rel="stylesheet" href="<?php echo $url;?>css/jquery.fileupload-ui.css"

</head>
<body>
<div id="background_lavoro_insert" class="background ">
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
                        <div class="wrapper">
                            <span class="pictures">
                                <div class="covers">
                                    <form id="uploadcover" action="<?php echo $host; ?>/lavori/uploadcover" method="POST" enctype="multipart/form-data">
                                        <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                        <div class="row fileupload-buttonbar" style="display:inline-block">
                                            <div>
                                                <!-- The fileinput-button span is used to style the file input field as button -->

                                                <span class="btn fileinput-button">
                                                    <div class="btn" id="addCoversButton">+ Add Cover...</div>
                                                    <input type="file" name="files">
                                                </span>

                                                <!-- The global file processing state -->
                                                <span class="fileupload-process" ></span>
                                            </div>
                                            <!-- The global progress state -->
                                            <div class=" fileupload-progress fade">
                                                <!-- The global progress bar -->
                                                <span class="col-lg-10 progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                                </span>
                                            </div>
                                        </div>
                                        <table role="presentation" class="table table-striped" style="margin-top: 20px;"><tbody class="files"></tbody></table>
                                        <!-- The table listing the files available for upload/download -->
                                    </form>


                                </div>
                                <div class="slider">
                                    <form id="uploadimages" action="<?php echo $host; ?>/lavori/uploadimages" method="POST" enctype="multipart/form-data">
                                        <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                        <div class="row fileupload-buttonbar">
                                            <div>
                                                <!-- The fileinput-button span is used to style the file input field as button -->
                                                <span class="btn  fileinput-button">
                                                    <div class="btn" id="addCoversButton">+ Add files...</div>
                                                    <input type="file" name="files[]" multiple>
                                                </span>
                                                <button type="submit" style="MARGIN-LEFT: 4%;" class="btn start">
                                                    <i class="glyphicon glyphicon-upload"></i>
                                                    <span>Start upload</span>
                                                </button>
                                                <button type="reset" class="btn btn-danger cancel">
                                                    <i class="glyphicon glyphicon-ban-circle"></i>
                                                    <span>Cancel upload</span>
                                                </button>
                                                <!-- The global file processing state -->
                                                <span class="fileupload-process"></span>
                                            </div>
                                            <!-- The global progress state -->
                                            <div class=" fileupload-progress fade">
                                                <!-- The global progress bar -->
                                                <span class="col-lg-10 progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                                </span>
                                                <!-- The extended global progress state -->
                                                <span class="col-lg-10 progress-extended">&nbsp;</span>
                                            </div>
                                        </div>
                                        <!-- The table listing the files available for upload/download -->
                                        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                                    </form>

                                </div>
                            </span>
                            <span class="details">
                                <form method="POST" name="details" id="details" action="<?php echo $host;?>/lavori/save">
                                    <div class="title">
                                        <label>Titolo</label>
                                        <input type="text" value="" name="titolo" id="titolo" />
                                    </div>
                                    <div class="description">
                                        <label>Descrizione</label>
                                        <textarea name="descrizione" id="descrizione" style="width: 100%; height:250px;"></textarea>
                                    </div>
                                    <div class="category">
                                        <label>Categoria</label>
                                            <select name="categoria" id="categoria" >
                                                <?php
                                                    while($riga = $categorie->fetch_assoc())
                                                    {
                                                        echo "<option value='".$riga['id_categoria']."'>".$riga['nome_categoria']."</option>";
                                                    }
                                                ?>
                                            </select>
                                    </div>
                                    <div class="tags">
                                        <label>Meta tags</label>
                                        <textarea name="tags" id="tags" style="width: 100%; height:160px;"></textarea>
                                    </div>
                                    <div class="status">
                                        <label>Stato</label>
                                        <select name="status" id="status">
                                            <option value="0"> Bozza</option>
                                            <option value="1"> Privato</option>
                                            <option value="2"> Pubblico</option>
                                        </select>
                                    </div>

                                    <div id="salva_lavoro" onclick="$('#details').submit();" class="buttonDiv"> Salva </div>
                                </form>
                            </span>
                        </div>
                    </span>
        </div>
    </center>



    <script id="template-upload-cover" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name" style="min-width:80px">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-success start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
                {% } %}
                {% if (!i) { %}
                <button class="btn btn-danger cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
                {% } %}
            </td>
        </tr>
        {% } %}
    </script>



    <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <p class="size">Processing...</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </td>
            <td>
                {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-success start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
                {% } %}
                {% if (!i) { %}
                <button class="btn btn-danger cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
                {% } %}
            </td>
        </tr>
        {% } %}
    </script>

    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade">
            <td>
                                                <span class="preview">
                                                    {% if (file.thumbnailUrl) { %}
                                                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                                                    {% } %}
                                                </span>
            </td>
            <td>
                <p class="name">
                    {% if (file.url) { %}
                    <a href="{%=file.url%}" target="_blank" title="{%=file.name%}"  >{%=file.name%}</a>
                    {% } else { %}
                    <span>{%=file.name%}</span>
                    {% } %}
                </p>
                {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                {% } %}
            </td>
            <td>
                <span class="size">{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td>
                {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="glyphicon glyphicon-trash"></i>
                <span>Delete</span>
                </button>

                {% } else { %}
                <button class="btn btn-danger cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
                {% } %}
            </td>
        </tr>
        {% } %}
    </script>


    <?php

    initConfig::getInstance() -> getIncluder() -> includePage("admin_scripts_post");
    ?>

    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="<?php echo $url; ?>js/lavori/vendor/jquery.ui.widget.js"></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>

    <!-- blueimp Gallery script -->
    <script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>


    <!-- The basic File Upload plugin -->
    <script src="<?php echo $url; ?>js/lavori/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="<?php echo $url; ?>js/lavori/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="<?php echo $url; ?>js/lavori/jquery.fileupload-image.js"></script>

    <!-- The File Upload user interface plugin -->
    <script src="<?php echo $url; ?>js/lavori/jquery.fileupload-ui.js"></script>
    <!-- The main application script -->
    <script src="<?php echo $url; ?>js/lavori/main.js"></script>
</div>
</body>
</html>