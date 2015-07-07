<?php
// links start with a dot+slash (i.e. start from root)


$c['global_google'] = 'Google Plus link';
$c['global_facebook'] = 'Facebook link';
$c['global_linkedin'] = 'Linkedin link';
$c['global_twitter'] = 'Twitter link';
$c['global_github'] = 'Github link';


$hook['style'][] = "<link rel='stylesheet' type='text/css' href='./plugins/social/styles.css' media='screen' />";
$hook['css'][] = "plugins/social/styles.css";


function social()
{
    global $c;
    $AllValues = array('google', 'facebook', 'linkedin', 'twitter', 'github');
    echo "<div id='social'>";
    
    foreach($AllValues as $key){
        if (startsWith($c['global_'.$key], 'http')) {
            echo "<a href='".$c['global_'.$key]."' target='_blank'><img src='./plugins/social/img/".$key.".png' alt='".$key."' class='social' ></a>";
        }
    }
    echo "</div>";  
}

?>
