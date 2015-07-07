<?php
$hook['script'][] = '
<script>
$(document).ready(
    function($){
        $(".toggle").click(
            function () {
                $(".hide").toggle("200");
                if (!$("#main-nav-check").is(":checked")) { $("#main-nav-check").trigger("click"); } 
            }
        );
           
        setTimeout(function () {
            var width = $(window).width();
            if (width <= 1250) {    
                $(".main-nav-check").prop("checked", false);
            }
        }, 700);

    }
);
</script>';

$hook['script'][] = '
<script>
$(".mbtn").mousedown(function (e) {
    var target = e.target;
    var rect = target.getBoundingClientRect();
    var ripple = target.querySelector(".ripple");
    $(ripple).remove();
    ripple = document.createElement("span");
    ripple.className = "ripple";
    ripple.style.height = ripple.style.width = Math.max(rect.width, rect.height) + "px";
    target.appendChild(ripple);
    var top = e.pageY - rect.top - ripple.offsetHeight / 2 -  document.body.scrollTop;
    var left = e.pageX - rect.left - ripple.offsetWidth / 2 - document.body.scrollLeft;
    ripple.style.top = top + "px";
    ripple.style.left = left + "px";
    return false;

});
</script>';

?>