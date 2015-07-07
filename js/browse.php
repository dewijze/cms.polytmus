<?php
    
$hook['admin-script'][] = '
<script>
$(document).ready(
    function($){

        $(".showsettings").click(
            function(){
                $("#settingContent").removeClass("smooth");
                if ($(".hide").is(":hidden")) {
                    $(".hide").show("200");
                }
                else if ($("#settingContent").is(":visible")) {
                    $(".hide").hide("200");
                } 
                $("#settingContent").show("200");
                $(".showsettings").addClass("active");
                $(".showplugins").removeClass("active");
                $("#settingContent1").removeClass("smooth");
                $("#settingContent1:visible").hide();
                setTimeout(function(){$("#settingContent").addClass("smooth");}, 400);
        });
        $(".showplugins").click(
            function(){
                $("#settingContent1").removeClass("smooth");
                if ($(".hide").is(":hidden")) {
                    $(".hide").show();
                }
                else if ($("#settingContent1").is(":visible")) { 
                    $(".hide").toggle("200");
                } 
                $("#settingContent1").show("200");
                $(".showplugins").addClass("active");
                $(".showsettings").removeClass("active");
                $("#settingContent").removeClass("smooth");
                $("#settingContent:visible").hide();
                setTimeout(function(){$("#settingContent1").addClass("smooth");}, 400);
        });
    }
);
</script>

<script>
function browseIt(key)
{
    $.post("index.php", {file: key,submit:"submit"} ).done(function(data){
                   //alert( "Data Loaded: " + data );
        if (data) {
            document.getElementById("output").innerHTML = data;
        }
    });

}
function makeNew()
{
    var key = document.getElementById("newfolder").value;
    var pat = document.getElementById("newpath").value;
    $.post("index.php", {nfolder: key,npath: pat,submit:"submit"} ).done(function(data){
                   //alert( "Data Loaded: " + data );
        if (data) {
            document.getElementById("output").innerHTML = data;
        }
    });

}
function renameIt(key)
{
    var oname = key.split("%2F").pop();
    var val = prompt("New file or folder name", oname);
    if (val) {
        $.post("index.php", {oldname: key,newname: val,submit:"submit"} ).done(function(data){
                       //alert( "Data Loaded: " + data );
        if (data) {
            document.getElementById("output").innerHTML = data;
        }
        });
    }
}
function deleteIt(key)
{
    var x = confirm("Delete can not be undone! Sure?");
    if (x) {
        $.post("index.php", {delete: key,submit:"submit"} ).done(function(data){
                       //alert( "Data Loaded: " + data );
        if (data) {
            document.getElementById("output").innerHTML = data;
        }
        });
    }
}
</script>';
    
    
    
    
?>