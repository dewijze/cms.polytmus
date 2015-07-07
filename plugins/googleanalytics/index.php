<?php
// links start with a dot+slash (i.e. start from root)


if (file_exists('files/global/global_googleanal')) {
    $c['global_googleanal'] = @file_get_contents('files/global/global_googleanal');
} else {
    $c['global_googleanal'] = "UA-12345678-9";
}

$hook['scriptzzz'][] = "
<!-- Google Analytics -->
<script>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', ".$c['global_googleanal']."]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";

$hook['script'][] = "
<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '".$c['global_googleanal']."', 'auto');
  ga('send', 'pageview');

</script>";

?>
