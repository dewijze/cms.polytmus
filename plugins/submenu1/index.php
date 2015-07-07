<?php
// links start with a dot+slash (i.e. start from root)

$c['itm_submenu1'] = "Gallery<br />\nSubmenu<br />\nExample";
$c['global_submenu1'] = "Gallery";


$hook['style'][] = "<link rel='stylesheet' type='text/css' href='./plugins/submenu1/styles.css' media='screen'/>";
$hook['css'][] = "plugins/submenu1/styles.css";

function submenu1()
{
    global $c, $host;
	echo '<nav>';
    $mlist = c_explode($c['itm_submenu1']);

    foreach ($mlist as $cp){  
	    $item = getSlug($cp);
        if ($item == 'global') {
		    $cp = 'error_403';
		    $item = 'error_403';
	    }
		$active = ($c['page'] == $item) ? 'active' : '';
        echo '<a href="p/'.$item.'" class="mbtn '.$active.'">'.$cp.'</a>'; 
    }
    echo '</nav>';
}
?>
