<?php

//http://tutorialzine.com/2013/05/mini-ajax-file-upload-form/

fileUpload();

function fileUpload()
{
    
    $dir = 'home';
    $plugin = 'general';

    if (file_exists('../../files/global/global_page')) { $dir = file_get_contents('../../files/global/global_page'); 
    }
    if (file_exists('../../files/global/global_uploadSelect')) { $plugin = file_get_contents('../../files/global/global_uploadSelect'); 
    }

    $path = '../../files/'.$dir.'/'.$plugin.'/';
    //echo $path;
    // A list of permitted file extensions
    $allowed = array('png', 'jpg', 'gif', 'zip', 'pdf');

    if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0 && !empty($dir) && !empty($plugin)) {

        $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

        if(!in_array(strtolower($extension), $allowed)) {
            echo '{"status":"error"}';
            exit;
        }

        if(move_uploaded_file($_FILES['upl']['tmp_name'], '../../files/'.$dir.'/'.$plugin.'/'.$_FILES['upl']['name'])) {
            echo '{"status":"success"}';
            exit;
        }
    }

    echo '{"status":"error"}';
    exit;
}


?>
