<?php
// links start with a dot+slash (i.e. start from root)

$c['global_blockgrid'] = "Home";
$c['bgrid_effect'] = "effect-sadie";
$c['global_bgrid_list'] = array('effect-milo', 'effect-lily', 'effect-sadie', 'effect-roxy', 'effect-bubba', 'effect-romeo', 'effect-layla', 'effect-honey', 'effect-oscar', 'effect-marley', 'effect-ruby', 'effect-dexter', 'effect-sarah', 'effect-zoe', 'effect-chico');
$c['global_bgrid_functions'] = array('page-link', 'image-link');
$c['bgrid_function'] = 'image-link';
$c['bgrid_border'] = "0.5";

$hook['style'][] = "<link rel='stylesheet' type='text/css' href='./plugins/blockgrid/css/component.css' />";
$hook['css'][] = "plugins/blockgrid/css/component.css";





function generate_blockgrid() 
{
    global $c;

    $functionName = 'Blockgrid';
    CreateDirStructure('blockgrid'); //make files dir. 
    //CreateDirStructure('blockgrid/thumbs'); //make thumbs dir. 

    /* SETTINGS (no ROOT. Is http url!) */

    $images_dir = 'files/' . $c['page'] . '/blockgrid/';
    //$thumbs_dir = 'files/' . $c['page'] . '/blockgrid/thumbs/';
    
    //quallity (longest side of thumb in px)
    //$longest_side = 1040; 
    $tmb_w = 500; 
    $tmb_h = 500;
    $l_side = max($tmb_w,$tmb_h);
    
    //For evt pagination Rows 0 means (behave like inline-block)
    //$images_per_row = 0;
    $effect = $c['bgrid_effect'];
    $bo = $c['bgrid_border'].'em';
    
    // for fancybox grouping
    $pageArray = strtolower($c['global_blockgrid']);
    $pageArray = c_explode($pageArray);
    $nr = array_search($c['page'], $pageArray); //position of page in pages array
    
    if (folderExists($images_dir)) {
        $image_files = retrieve_files($images_dir);
        natcasesort($image_files);
    } else {
        $image_files = NULL;
    }
    echo '<section id="grid" class="grid" style="width: calc((100% + '.$bo.') + 1px);">';

    if(count($image_files)) {
        $index = 0;
        echo '      <div class="first" style="background-clip: padding-box; border-right:'.$bo.' solid rgba(255, 255, 255, 0); border-bottom:'.$bo.' solid rgba(255, 255, 255, 0);">
                        <div class="outline">
            ';
								pluginText('blockgrid');
        echo '      </div></div>
            ';
        foreach($image_files as $index=>$file) {
            $index++;
            $original_image = $images_dir.$file;
            //$thumbnail_image = $thumbs_dir.$file;
            $filename = $file; //Take the file name to extract the caption
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
            $gridlink = ($c['bgrid_function'] == 'page-link') ? '<a href="p/'.strtolower($imtitle).'">View</a>' : '<a href="'.$original_image.'" class="fancybox" rel="block'.$nr.'"></a>';
            
            echo '      <figure class="',$effect,'" style="background-clip: padding-box; border-right:'.$bo.' solid rgba(255, 255, 255, 0); border-bottom:'.$bo.' solid rgba(255, 255, 255, 0);">
							<img src="thumb/image.php?width='.$l_side.'&height='.$l_side.'&cropratio='.$tmb_w.':'.$tmb_h.'&image=/'.WFOLDER.$original_image.'" alt="php generated"/>
                            <figcaption>
								<h2><b>',$imtitle,'</b></h2>
								<p>',$imdescrip,'</p>
								'.$gridlink.'
                            </figcaption>           
                        </figure>
            ';
        
        }

    }
    else {
        echo "<div class='wbg'><br/><p>There are no images in ".$images_dir.".</p><br/>
            <p>Tip: The following file name structure is expected.</p><br/>
            <p>XX--PROJECTNAME_-_THE_TITLE.ext</p><br/>
            <p>Example:</p><br/>
			<p>05--Landscapes_-_Lovely_snowy_mountains.jpg</p><br/></div>";
    }

    echo '</section>';
}
?>
