<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 30/11/14
 * Time: 22.12
 * To change this template use File | Settings | File Templates.
 */

global $response;
$url =  $response -> getProperty("url");
$host =  $response -> getProperty("host");
$settings = initConfig::getInstance()->getSettings();

echo $settings['google_analytics_javascript'];
?>

<link href="<?php echo $url;?>css/styles.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $url;?>js/jquery.mask.js" async></script>
<script type="text/javascript" src="<?php echo $url;?>js/init.js" defer="defer"></script>

<script type="text/javascript">
    var host = '<?php echo $host; ?>';
    var url = '<?php echo $url; ?>';
</script>