<?php

CreateDirStructure('blockgrid');

    echo "<div class='explain block'><b>[ blockgrid ] Picture gallery menu</b> <small>(Use to open pages or images with f.e. fancybox plugin)</small></div>
    <div class='change border block'>
    
	Effect: &nbsp;&nbsp;<span id='themeSelect'>";
    echo"<select name='bgrid_effect' onchange='fieldSave(\"bgrid_effect\",this.value);'>";
    effectSelect();
    function effectSelect() 
    {
        global $c;
        foreach($c['global_bgrid_list'] as $val) {
            $select = ($val == $c['bgrid_effect']) ? ' selected' : '';
            echo '<option value="'.$val.'"'.$select.'>'.$val."</option>\n";
        }
    }
    echo "</select>&nbsp;&nbsp;&nbsp;
    
    Opens: &nbsp;&nbsp;<span id='themeSelect'>";
    echo"<select name='bgrid_function' onchange='fieldSave(\"bgrid_function\",this.value);'>";
    multiSelect();
    function multiSelect() 
    {
        global $c;
        foreach($c['global_bgrid_functions'] as $val) {
            $select = ($val == $c['bgrid_function']) ? ' selected' : '';
            echo '<option value="'.$val.'"'.$select.'>'.$val."</option>\n";
        }
    }
    echo "</select><br/><br/>
    Space between images in em
    <div id='setaddr'><span id='bgrid_border' title='Border' class='editText'>".$c['bgrid_border']."</span></div></div>";


?>
