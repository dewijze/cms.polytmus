<?php
// links start with a dot+slash (i.e. start from root)

$c['global_quoteroll'] = 'There are no quotes.';

$hook['style'][] = "<link rel='stylesheet' type='text/css' href='./plugins/quoteroll/styles.css' media='screen' />";
$hook['css'][] = "plugins/quoteroll/styles.css";

$hook['script'][] = "
<script>
    $(document).ready(function() {
        var div = document.getElementById('dom-quote');
        var roles = div.textContent.split('~');
		$('#role').html(roles[0]);
        var roleId = 1;

        window.setInterval(function () {
            $('#role').html(roles[roleId]);
            roleId = roleId + 1;
            if(roleId >= roles.length) { roleId = 0; }
        }, 10000);
    });
</script>";


function listQuotes()
{
    global $c;
    $qlist = c_explode($c['global_quoteroll']);
    $lastElement = end($qlist);
    foreach ($qlist as $quote){
        if($quote == $lastElement) {
            echo $quote;
        } else {
            echo $quote.'~';
        }
    }
}

function insertQuote()
{
    echo "\n\t    <div id='quote-text'>
                <H3>Quote:</H3>
                <p id='role' ></p>
            </div>
		\n\t    <div id='dom-quote' style='display: none;'>\n";
        
        listQuotes();
        
    echo "\n\t    </div>\n";  
}
?>
