<?php


    echo "<div class='explain block'><b>Upload to the page's plugin folder</b> <small>(Upload to the plugin you want to update)</small></div>
    <div class='change border block'>
	<small><span id='themeSelect'>";
    
    
    echo"Page: &nbsp;&nbsp;/&nbsp;&nbsp;<select name='global_page' onchange='fieldSave(\"global_page\",this.value);'>";
    pageSelect();
    function pageSelect() 
    {
        global $c;
        foreach(dirArray('/files/') as $val) {
            if ($val != 'global' && $val != 'polytmus'){
                $select = ($val == $c['page']) ? ' selected' : '';
                echo '<option value="'.$val.'"'.$select.'>'.$val."</option>\n";
            }
        }
    }
    echo "</select>&nbsp;&nbsp;&nbsp;&nbsp;";
    
    
    echo"Plugin:&nbsp;&nbsp;/&nbsp;<select name='global_uploadSelect' onchange='fieldSave(\"global_uploadSelect\",this.value);'>";
    fieldSelect();
    function fieldSelect() 
    {
        global $c;
        foreach(dirArray('/files/'.$c['page'].'/') as $val) {
            $select = ($val == $c['global_uploadSelect']) ? ' selected' : '';
            echo '<option value="'.$val.'"'.$select.'>'.$val."</option>\n";
        }
    }
    echo "</select>&nbsp;&nbsp;";
    
    
    echo "</span></small><br/><br/>";  
    echo "<form id='upload' method='post' action='./plugins/upload/upload.php' enctype='multipart/form-data'>
            <div id='drop'><br/>
                <a>Browse</a>

                <p>Drop Here</p>
                <input type='file' name='upl' multiple />
            </div>

            <ul>
                <!-- The file uploads will be shown here -->
            </ul>

		</form></div>";
            
        
?>
