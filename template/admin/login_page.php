<?php

global $response;
$url =  $response -> getProperty("url");
$host =  $response -> getProperty("host");

?>



<div  id="loginDiv">

<center><a class="titoli_login"> AREA AMMINISTRATIVA</a></center>
<br />
<div id="logoapp">
</div>
<center>
  <form action="<?php echo $host;?>/amministrazione/login"  method="POST">

        <table class="loginTable">
            <tr>
                <td>
                    <?php

                    echo "<div class='errorMessage'><b>".$response -> getError("error_login")."</b></div>";


                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <a class="testoadmin"> Username :</a>
                <input id="login-input2" type="text" alt="username" required="required" name="username" size="43" /></td>
            </tr>
            <tr>
                <td>
                    <a class="testoadmin"> Password  :</a>
                <input id="login-input" type="password" alt="password"  required="required" value="" name="password" size="43" /></td>
            </tr>
            <tr>
                <td>

                    <button type=”submit” id="button-login">
                        LOGIN
                    </button>

                </td>
            </tr>
        </table>
    </form>
</center>
</div>
<br/><br/>
