Style and animation
http://tympanus.net/codrops/2014/06/19/ideas-for-subtle-hover-effects/

Basis for gallery generation
http://davidwalsh.name/generate-photo-gallery


The following line goes in theme.php

<?php if ( CheckPage('global_blockgrid') ) { include_once(ROOT."/plugins/blockgrid/template.php"); }  ?>

Log into settings and set the page where you want to see the gallery