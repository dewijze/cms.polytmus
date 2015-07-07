
<html class="no-js" lang="en">
<head>
<?php
	echo "	<meta charset='utf-8' />
	<meta http-equiv='X-UA-Compatible' content='IE=edge' />
	<title>".$c['global_title']." - ".$c['page']."</title>
	<base href='$host' />
	<meta name='viewport' content='width=device-width, target-densityDpi=device-dpi, initial-scale=0.8' />\n
	<link rel='icon' type='image/gif' href='animated_favicon1.gif'/>
	<link rel='shortcut icon' href='favicon.ico'/>
	<meta name='keywords' content='".$c['keywords']."'/>
	<meta name='description' content='".$c['description']."'/>
	<meta name='description' content='☃'/>\n";
    /* _snowman description force IE to use unicode */
    /* modernizr includes HTML5Shiv */
    /* css first */
	minCombine('css'); 
	/* font and jquery after css*/
	echo "\t<link href='https://fonts.googleapis.com/css?family=Lustria|Hind' rel='stylesheet' type='text/css' />\n
    <script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>\n
    <script async type='text/javascript' src='https://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false'></script>\n";
    /* Text edit functions after jQuery */
	editTags();
    /* dynamic css comes after plugin and theme css */
	themeFunc('themeColor');
    
?>
<meta name="google-site-verification" content="gHyuWe-MUM-GUTui8g2T77AT13G9T2kQcbHsDWCotsQ" />
</head>

<body >
    
    <input type="checkbox"  class="main-nav-check" id="main-nav-check" checked="checked" />

    <nav class="main-nav" id="main-nav">
    
        <div class="nav-scroll">
        <div class="nav-overflow">
        
            <div id="panel-spacer-top"></div>

            <?php adminFunc('adminMenu'); ?>

            <div id="panel-spacer">Menu</div>
            
            <?php themeFunc('panelMenu'); ?>

            <?php themeFunc('social'); ?>

            <?php themeFunc('insertQuote'); ?>
            
        </div>
        </div>
    
    </nav>

    <!-- <img src='./themes/g-white/img/white-trans.png' class='right-logo' /> -->
    <div class="rotate-right"></div>
    <div class="rotate-left"></div>    

    <?php adminFunc('settings'); ?>

    
    <div class="page-wrap"><!-- fake body -->

        <header class="main-header">
            
            <?php themeFunc('logo'); ?>
			
            
            <div id="trigger" class="toggle-menu" >
                <label for="main-nav-check" class="toggle-menu" onclick=""> </label>
                
                    <div class="white-background"></div>

                    <div class="stripes-container">
                        <div class="stripe stripe-top"></div>
                        <div class="stripe stripe-center"></div>
                        <div class="stripe stripe-bottom"></div>
                    </div>
                
                
            </div>

            <?php echo "$lbutton"; ?><div id="login">
                <div class="key-circle"></div>
                <div class="key-pin"></div>
                <div class="key-block"></div>
            </div></a>
            
        </header>


        <div class="main gpu" ><!-- main + padding -->

            <?php themeFunc('ShowPlugins'); ?>

        </div><!-- end main -->
      
    </div><!-- end page-wrap -->
    
    <div class="clear pusher"></div>
	<footer ><p><?php echo $c['global_copyright'] ." | $lstatus";?></p></footer>
   

<?php	
    /* Plugin js libraries just before closing body */
    minCombine('js');
    /* inline scripts after libraries */
    minCombine('script');
?>

</body>

   

</html>
