<?php
// https://gilbitron.github.io/Ideal-Image-Slider/
// links start with a dot+slash (i.e. start from root)

$c['global_slider'] = "Home";

$hook['style'][] = "<link rel='stylesheet' type='text/css' href='./plugins/slider/styles.css' media='screen'/>";
$hook['css'][] = "plugins/slider/styles.css";

$hook['jslib'][] = "<script type='text/javascript' src='./plugins/slider/ideal-image-slider.js'></script>";
$hook['jslib'][] = "<script type='text/javascript' src='./plugins/slider/iis-captions.js'></script>";
$hook['jslib'][] = "<script type='text/javascript' src='./plugins/slider/iis-bullet-nav.js'></script>";

$hook['js'][] = "plugins/slider/ideal-image-slider.js";
$hook['js'][] = "plugins/slider/iis-captions.js";
$hook['js'][] = "plugins/slider/iis-bullet-nav.js";

$hook['script'][] = "
<script>
    var slider = new IdealImageSlider.Slider({
        selector: '#slider',
        height: 400,
        disableNav: false,
        effect: 'fade',
        interval: 8000,
    });
    slider.addCaptions();
    slider.addBulletNav();
    slider.start();
</script>";


function generate_slider() 
{
    global $c;
    
    $functionName = 'Slider';
    CreateDirStructure('slider'); //make thumbs dir. Function available to all plugins
    //CreateDirStructure('slider/thumbs'); //make thumbs dir. Function available to all plugins

    /* SETTINGS (no ROOT. Is http url!) */

    $images_dir = 'files/' . $c['page'] . '/slider/';
    //$thumbs_dir = 'files/' . $c['page'] . '/slider/thumbs/';
    
    //quallity (longest side of thumb in px)
    //$longest_side = 700; 
    $tmb_w = 1080; 
    $tmb_h = 400;
    $l_side = max($tmb_w,$tmb_h);
    
    //For evt pagination Rows 0 means (behave like inline-block)
    //$images_per_row = 0;
    /*
    $pageArray = strtolower($c['global_slider']);
    $pageArray = c_explode($pageArray);
    $nr = array_search($c['page'], $pageArray); //position of page in pages array
    */
    //Fancybox Galleries are created from elements who have the same "rel" tag

    
    echo '<div id="slider">';

    if (folderExists($images_dir)) {
        $image_files = retrieve_files($images_dir);
        natcasesort($image_files);
    } else {
        $image_files = NULL;
    }
    
    if(count($image_files)) {
        $index = 0;
        $i = 0;
        $z = 0;
        foreach($image_files as $index=>$file) {
            $index++;
            $original_image = $images_dir.$file;
            //$thumbnail_image = $thumbs_dir.$file;
            $filename = $file; //Take the file name to extract the caption
            $id = preg_replace('/\\.[^.\\s]{2,5}$/', '', $filename);

            $caption = preg_replace(array('/^.+--/', '/\.(jpg|jpeg|gif|png|bmp)$/', '/_/'), array('','',' '), $filename); //Extracting the caption
            $imtitle = strtok($caption, " ");
            $imdescrip = substr(strstr($caption, ' '), 3);
            /*
            if(!file_exists($thumbnail_image)) {
                $extension = get_extension($thumbnail_image);
                if($extension) {
                    generate_thumb($original_image, $thumbnail_image, $longest_side,$functionName);
                }
            }*/
            if ($index === 1){
                echo '	<img src="thumb/image.php?width='.$l_side.'&height='.$l_side.'&cropratio='.$tmb_w.':'.$tmb_h.'&image=/'.WFOLDER.$original_image.'" 
                title="'.$imtitle.'" alt="'.$imdescrip.'" />'; // end echo
            } else {
                echo '	<img src="thumb/image.php?width='.$l_side.'&height='.$l_side.'&cropratio='.$tmb_w.':'.$tmb_h.'&image=/'.WFOLDER.$original_image.'" 
                data-src="thumb/image.php?width='.$l_side.'&height='.$l_side.'&cropratio='.$tmb_w.':'.$tmb_h.'&image=/'.WFOLDER.$original_image.'" 
                title="'.$imtitle.'" alt="'.$imdescrip.'" />'; // end echo
            }
            
        }

    }
    else {
        echo "
            <div class='notice'>
                <br/><p>There are no images in ".$images_dir.".</p><br/>
                <p>Tip: The following file name structure is expected.</p><br/>
                <p>XX--PROJECTNAME_-_THE_TITLE.ext</p><br/>
                <p>Example:</p><br/>
                <p>05--Landscapes_-_Lovely_snowy_mountains.jpg</p><br/>
            </div>
			";
    }

    echo '</div>';
}
?>
