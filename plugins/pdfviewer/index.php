<?php
// links start with a dot+slash (i.e. start from root)

$c['global_pdfviewer'] = "Home";

$hook['style'][] = "<link rel='stylesheet' type='text/css' href='./plugins/pdfviewer/styles.css' media='screen'/>";
$hook['css'][] = "plugins/pdfviewer/styles.css";

CreateDirStructure('pdfviewer');

function generate_pdf() 
{
    global $c;
    $tmb_w = 150; 
    $tmb_h = 150;
    $l_side = max($tmb_w,$tmb_h);
    
    $pdfArray = glob(ROOT.'/files/'.$c['page'].'/pdfviewer/*.{pdf}', GLOB_BRACE);
    if ($pdfArray) {
        foreach($pdfArray as $pdf){
            $pdf = end((explode('/', $pdf)));
            $fieldname = pathinfo($pdf, PATHINFO_FILENAME);
            $base_link = 'files/'.$c['page'].'/pdfviewer/'.$fieldname;
            $original_image = ($base_link.'.jpg') ? $base_link.'.jpg' : $base_link.'.png';
            
            echo '
                <div class="pdf-bottom-margin">
                <div class="pdf-buttons">
                
                    <div class="pdf-circle">
                        <img src="thumb/image.php?width='.$l_side.'&height='.$l_side.'&cropratio='.$tmb_w.':'.$tmb_h.'&image=/'.WFOLDER.$original_image.'" alt="pdf thumbnail">
                        </div>
                    <a href="'.$base_link.'.pdf" target="_blank" class="a-button">
                        Open pdf in new tab
                    </a><br/><br/>

                    <a href="'.$base_link.'.pdf" class="a-button" download>
                        Save pdf
                    </a>
                </div>
                
                <div class="pdf-text">';
                    pluginText($fieldname);
            echo "</div></div>";

        }
    } else {
        echo "There are no pdf in files/".$c['page']."/pdfviewer/ <br/>";
        echo "example images are expected to be square and have the same name as the pdf";
    }
}
?>
