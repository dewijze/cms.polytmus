<?php
// links start with a dot+slash (i.e. start from root)

$c['global_icontext'] = "Home";

$hook['style'][] = "<link rel='stylesheet' type='text/css' href='./plugins/icontext/styles.css' media='screen'/>";
$hook['css'][] = "plugins/icontext/styles.css";

CreateDirStructure('icontext');

function generate_blocks() 
{
    global $c;
    $tmb_w = 150; 
    $tmb_h = 150;
    $l_side = max($tmb_w,$tmb_h);
    
    
    $iconArray = glob(ROOT.'/files/'.$c['page'].'/icontext/*.{jpg,png,gif}', GLOB_BRACE);
    if ($iconArray) {
        foreach($iconArray as $icon){
            $icon = end((explode('/', $icon)));
            $fieldname = pathinfo($icon, PATHINFO_FILENAME);
            $original_image = 'files/'.$c['page'].'/icontext/'.$icon;
            
            echo '
            <div class="block-bottom-margin">
                <div class="deco-circle"></div>
                <div class="iconblock">
                    <div class="iconcircle">
                        <img src="thumb/image.php?width='.$l_side.'&height='.$l_side.'&cropratio='.$tmb_w.':'.$tmb_h.'&image=/'.WFOLDER.$original_image.'" alt="icon" />
                    </div>
                </div>
            
            <div class="icontextblock">';
            
        pluginText($fieldname);
        
            echo "\n\t    </div>\n\t</div>";

        }
    } else {
        echo "There are no icons in files/".$c['page']."/icontext/ ";
    }
}
?>
