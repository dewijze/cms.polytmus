<?php
// links start with a dot+slash (i.e. start from root)

$c['global_basecolor'] = "0, 172, 191";
$c['global_lightcolor'] = "251, 104, 52";

function themeColor() 
{
    global $c;
    echo "\t<meta name='theme-color' content='rgba(  ".$c['global_basecolor'].", 1)'>\n";
    echo "\t<style type='text/css'>";
        include_once ROOT.'/themes/'.$c['global_themeSelect'].'/accent-color.css.php';
    echo "\t</style>";
}
?>
