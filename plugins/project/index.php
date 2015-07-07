<?php
// links start with a dot+slash (i.e. start from root)

$c['global_project'] = "Home";
$c['default_project'] = 'Click to edit! Change this project description.';

$hook['style'][] = "<link rel='stylesheet' type='text/css' href='./plugins/project/styles.css' />";
$hook['css'][] = "plugins/project/styles.css";



function generate_project() 
{
    global $c;
    
    $functionName = 'Project';
    CreateDirStructure('project'); //make thumbs dir. Function available to all plugins
    //CreateDirStructure('project/thumbs'); //make thumbs dir. Function available to all plugins

    /* SETTINGS (no ROOT. Is http url!) */

    $images_dir = 'files/' . $c['page'] . '/project/';
    //$thumbs_dir = 'files/' . $c['page'] . '/project/thumbs/';
    
    //quallity (longest side of thumb in px)
    //$longest_side = 1040; 
    $tmb_w = 500; 
    $tmb_h = 500;
    $l_side = max($tmb_w,$tmb_h);
    
    //For evt pagination Rows 0 means (behave like inline-block)
    //$images_per_row = 0;
    
    // for fancybox grouping
    $pageArray = strtolower($c['global_project']);
    $pageArray = c_explode($pageArray);
    $nr = array_search($c['page'], $pageArray); //position of page in pages array
    //Fancybox Galleries are created from elements who have the same "rel" tag

    
    echo '<div>';

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
            echo '			<div class="fullw-container' , ($i++ % 2) , ' block animated fadeInRight' , ($z++ % 2) , '">
                        
                        <div class="pimageblock">
                            <div class="ichild grow">
								<a href="',$original_image,'" alt="',$imdescrip,'" title="',$imdescrip,'" class="fancybox" rel="group',$nr,'"><img src="thumb/image.php?width='.$l_side.'&height='.$l_side.'&cropratio='.$tmb_w.':'.$tmb_h.'&image=/'.WFOLDER.$original_image.'"  /></a>
                            </div>
                        </div>
                        
                        <div class="ptextblock">
                        <div class="vchild">
		'; // end echo
                                pluginText($id);

            echo '          </div>
                        </div>
                            <div class="box-bottom"></div>
                        </div>

		'; //end echo
        
        }

    }
    else {
        echo "<div class='fullw-container0 box animated fadeInRight' style='text-align: center;'>
			<br/><p>There are no images in ".$images_dir.".</p><br/>
            <p>Tip: The following file name structure is expected.</p><br/>
            <p>XX--PROJECTNAME_-_THE_TITLE.ext</p><br/>
            <p>Example:</p><br/>
            <p>05--Landscapes_-_Lovely_snowy_mountains.jpg</p><br/>
			</div>";
    }

    echo '</div>';
}
?>
