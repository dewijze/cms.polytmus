<?php

// links start with a dot+slash (i.e. start from root) and no double quotes.



$hook['style'][] = "<link rel='stylesheet' type='text/css' href='./plugins/fancybox/jquery.fancybox.css' media='screen' />";
$hook['css'][] = "plugins/fancybox/jquery.fancybox.css";

$hook['jslib'][] = "<script type='text/javascript' src='./plugins/fancybox/jquery.fancybox.js'></script>";
$hook['js'][] = "plugins/fancybox/jquery.fancybox.js";
//$hook['nogo'][] = "<script type='text/javascript' src='./plugins/jquery.easing-1.3.pack.js'></script>";



// Use margin to resize the whole popup function (for mobile)
// fancybox doesn't play nice with the escaping quotes in the php generated titles
// So letting it fuck up the alt instead so it can use the title attribute
$hook['script'][] = "

<script>
    $(document).ready(function() {

        $('a.fancybox').fancybox({
            beforeLoad: function() {
                this.title = $(this.element).attr('alt');
            },
            'openEffect'    : 'fade',
            'margin'        :   40,
            'padding'        :   0,
            helpers : {
                overlay : {
                    showEarly : false,
                    css : {
                        'background' : 'rgba(255, 255, 255, 0.8)'
                    }
                },
                title : {
                    type : 'over'
                }
            }
        });
    });
</script>";

?>
