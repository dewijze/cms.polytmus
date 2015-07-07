<?php
ob_start('ob_gzhandler');
ini_set('session.cookie_httponly', 1);
session_start();
/* Check relevant host stuff */
$host = '';
$rp = '';
host();
/* Browser cache, client side */
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + (60*60*24)) . ' GMT'); // 60 sec times 60 min times 24 hours is one day
/* Check login */
$c['global_password'] = 'admin';
$c['loggedin'] = false;
setLoggedin();

/* To get around relative paths for plugins */
define('ROOT', __DIR__);
$s = DIRECTORY_SEPARATOR;
if (strlen($_SERVER['DOCUMENT_ROOT']) !== strlen(ROOT)) {
    define('WFOLDER', substr(ROOT, strlen($_SERVER['DOCUMENT_ROOT']) + 1).'/');
} else {
    define('WFOLDER', '');
}

if(isset($_POST['submit']) && is_loggedin())
{
    $post['browse'] = NULL;
    $post['newfolder'] = NULL;
    $post['newpath'] = NULL;
    $post['delete'] = NULL;
    $post['newname'] = NULL;
    $post['oldname'] = NULL;
    if (isset($_POST['file']))
    {
        if (!preg_match("/[^-\.\%\w]/i", $_POST['file'])) {
            $post['browse'] = urldecode($_POST['file']);
        } else {return;}
    }
    if (isset($_POST['nfolder'])) 
    {
        if (!preg_match("/[^-\.\w]/i", $_POST['nfolder'])) {
            $post['newfolder'] = urldecode($_POST['nfolder']);
            $post['newpath'] = urldecode($_POST['npath']);
        } else {return;}
    }
    if (isset($_POST['delete'])) 
    {
        if (!preg_match("/[^-\.\%\w]/i", $_POST['delete'])) {
            $post['delete'] = urldecode($_POST['delete']);
        } else {return;}
    } 
    if (isset($_POST['newname'], $_POST['oldname']))
    {
        if (!preg_match("/[^-\.\w]/i", $_POST['newname']) && !preg_match("/[^-\.\%\w]/i", $_POST['oldname'])) {
            $post['newname'] = urldecode($_POST['newname']);
            $post['oldname'] = urldecode($_POST['oldname']);
        } else {return;}
    }
    if (count(array_keys($post, NULL)) !== count($post)) {
        browse($post);
        ob_end_flush();
        exit;
    }
}

/* Inline edit after host before redirect */
edit();
/* Redirect unwanted pages */
redirect();
/* Check page name after redirect*/
$c['page'] = 'home';
getPage('page');
/* Server side static html cache (cleaned on logout) -> If cached we can exit */
$cachefile = 'pagecache/'.$c['page'].'.html';
$cachetime = 43829 * 60; // 1440 minutes is a day, 43829 a month.
if ($c['page'] !== 'login' && file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile)) && !is_loggedin()) 
{
	include($cachefile);
    ob_end_flush();
	exit;
}
/* Output redirect part of buffer before other code */
$getHeader = ob_get_contents();
echo $getHeader;
/* No spaces before doctype!! 
Doctype in php in case plugins have trailing spaces or BOM chars */
echo '<!DOCTYPE html>';


$d['page']['home'] = "<h3>Up and running! </h3><br />\nPolytmus is a genus of hummingbird that has a CMS named after it.<br />\nThe login link is in the right bottom corner. Here you will find the option to <i>change password</i>.<br />\nYou can use the default password <b>admin</b> to set your own password.<br />\n
It is important you make your own password the first time you log in, otherwise you have no access to the settings.<br /><br />\n\nOnce logged in you can find a link to the help section at the bottom of the page next to logout.<br /><br />\n\n
Polytmus CMS is around 55KB in size without plugins. Very simple to setup, no database, just upload the files to your web directory.<br />\n\nThe index.php file generates and stores, fast to load, plain HTML files per page based on your settings.";
$d['page']['polytmus'] = "<h3>Polytmus help!</h3>Good, you found the help section. Where is Clippy when you need him, huh?<br /><br />\n\nTo open CMS settings, click settings. To see the settings for evt plugins, click plugins.<br />\n\n
<h3>No admin menu:</h3>Want the controls? You will need your own key instead of the default password. Go change your password. <br/>\nLog out. Go to the login page, and click cange password below the password input field.<br />\n\n
<h3>Making a new page:</h3>Go to settings, click inside the menu text area to activate it. Place your cursor. Now type the name of the new page below or above the other(s). Next, click outside of the text area to deactivate the editor. Now you are ready to refresh the page with the refresh button at the top of settings, or press F5 on the keyboard. It is really that simple!<br />\n\n
Click on your new entry in the menu to take you to your new page. You will be greeted by a page that contains the default plugin. You can go into the settings and add your choice of content blocks to the plugin order for the new page. Once done you  can remove the default plugin from the plugin order of your new page.<br />\n\n
<h3>Plugin order:</h3>The installed plugins that are capable of generating content blocks are shown on the right side of the text area. To activate a plugin for the page you are currently on, click the left side of the text area, type the name of the plugin you want below or above evt other plugins. Click outside the text editing area and refresh the page.<br />\n\n
<h3>Other settings:</h3>Settings such as title are global on every page, where as description and keywords (used by search engines like Google) are per page.<br />\n\n
<h3>There are no X in my Y:</h3>If a plugin is telling you that there are no images or icons available to it, you can use the upload plugin to provide it with an image. Do note that the name of the image or icon is related to the text content. Renaming an existing image will result in you seeing a new empty text block. Though the file containing your text is not lost, it is simply not requested to show.<br />\n\n
<h3>Upload plugin:</h3>This plugin will upload your full size images to the selected content block plugin, for the selected page. The content block plugins handle thumbnails ect.To fully benefit from the automated content generation of some of the galleries you should stick to the following naming convention for images.<br /><br />\n\n
<p>XX--PROJECTNAME_-_THE_TITLE.ext</p><br />\n\n<p>Example: 05--Landscapes_-_Lovely_snowy_mountains.jpg</p><br />\n\nThough this is not required for plugins that simply ask for one (or more) icons to add a text block to. Keep in mind the order of numbers and or alphabetical order.<br />\n\n
<h3>Logo and background images:</h3>You can upload a different one for each page, but it is not required as they will fallback to the one set on home. The logo will take the place of the website title.<br />\n\n
<h3>Not seeing all folders in FTP:</h3>Log in on the website and refresh your FTP.<br />\n\n
<h3>Non menu pages:</h3>Yes, you can have pages that are not in the main menu. This page is not in your menu... You can make a menu entry, go to the page, add plugins and then remove it from the menu. Or add them to a submenu plugin and go to the page. Or type in the url bar of the browser.<br />\n\n
<h3>This help page:</h3>You can edit this help page just like your other content. Click on the text and feel free to add your own notes, tips and reminders.<br />\n\n";

$d['new_page']['admin'] = "Page <b>".$rp."</b> created.<br /><br />\n\nClick <b>settings</b> and add your content blocks!";
$d['new_page']['visitor'] = "Sorry, but <b>".$rp."</b> doesn't exist. :(";
$d['new_page']['exists'] = 'You can remove <b>default</b> from the plugin order. Or edit this text.';
$d['default']['content'] = 'Click to edit!';
$d['default']['noplug'] = 'There are no plugins with additional settings.';

$c['global_themeSelect'] = 'g-white';

$c['subside'] = "<h3>ABOUT YOUR WEBSITE</h3><br />\nYour photo, website description, contact information, mini map or anything else.<br /><br />\n\n This content is static and is visible on all pages.";

$c['global_menu'] = "Home<br />\nGallery<br />\nEmail";
$c['pluginOrder'] = 'default';
$c['global_title'] = 'Website title';
$c['description'] = 'Your website description.';
$c['keywords'] = 'enter, your website, keywords';
$c['global_copyright'] = '&copy;'.date('Y').' Your website';

$e['global_theme'] = '<b>Theme</b> <small> (The design and layout of your website)</small>';
$e['global_menu'] = "<b>Menu</b> <small>(Type the name of a page below and </small><b><a href='javascript:location.reload(true);' style='color:#3E7CCE;'>refresh</a></b>)";
$e['pluginOrder'] = '<b>Plugin order</b> <small>(The global order of the plugins that can create content blocks.)</small>';
$e['global_title'] = '<b>Title</b> <small>(The title at the top of your website)</small>';
$e['description'] = '<b>Description</b> <small>(A short (150 char) description for search engines)</small>';
$e['keywords'] = '<b>Keywords</b> <small> (Words for search engines that describe your content)</small>';
$e['global_copyright'] = '<b>Copyright</b> <small>(Copyright indicator at the bottom of the website)</small>';

$sig = 'Powered by <a href="http://polytmus-cms.com">Polytmus CMS</a>';
$hook['admin-richText'] = 'rte.php';
$p = 'p/';

$d['plugin']['admin'] = 'Click to edit!';
$d['plugin']['visitor'] = 'Content coming soon!';

$hook['style'][] = '';
$hook['css'][] = '';
$hook['jslib'][] = '';
$hook['js'][] = '';
$hook['script'][] = '';

$filesdirArray = dirArray('/files/');
$plugindirArray = dirArray('/plugins/');

if(!file_exists('files')) 
{
    mkdir('files/global', 0755, true);
}
if(!file_exists('plugins')) 
{
    mkdir('plugins', 0755, true);
}
if(!file_exists('pagecache')) 
{
    mkdir('pagecache', 0755, true);
}


/* load includes from pluginOrder before main */
loadPlugins();

/* Main */
foreach($c as $key => $val)
{
    if($key === 'content') { continue;
    }
    $fval = @file_get_contents('files/global/'.$key);
    $pval = @file_get_contents('files/'.getPage('page').$s.$key);
    $d['default'][$key] = $c[$key];
    if($pval) {
        $c[$key] = $pval;
    } elseif($fval) {
        $c[$key] = $fval;
    }
    switch($key){
        
    case 'global_password':
        if(!$fval) {
            $c[$key] = savePassword($val); 
        }
        break;
    case 'loggedin':
                
        if(isset($_REQUEST['logout'])) {
            RemoveEmptySubFolders('files');
            sitemap();
            session_destroy();
            header('Location: p/home');
            exit;
        }
        if(isset($_REQUEST['login'])) {
            if(is_loggedin()) {
                header('Location: p/home'); 
            }
                    
            $msg = '';
            if(isset($_POST['sub'])) {
                login(); 
            }
            $c['content'] = "<form action='' method='POST'>
                <input type='password' name='global_password'>
                <input type='submit' name='login' value='Login'><br /><br />
                $msg
                <p class='toggle'>Change password</p><br />
                <div class='hide'>Type your old password above and your new one below.<br /><br /><br />
                <input type='password' name='new'>
                <input type='submit' name='login' value='Change'>
                <input type='hidden' name='sub' value='sub'>
                </div>
				</form>";
        }
        $lstatus = (is_loggedin()) ? "<a href='".$host."?logout' rel='nofollow'>Logout</a>&nbsp;&nbsp;<a href='".$host."p/polytmus' rel='nofollow'>Help</a>" : "<a href='".$host."?login' rel='nofollow'>Login</a>";
        $lbutton = (is_loggedin()) ? "<a href='".$host."?logout' class='log-active' rel='nofollow'>" : "<a href='".$host."?login' class='log-inactive' rel='nofollow'>";
                
        break;
    case 'page':

        if(is_loggedin()) { //file upload only
            $page_file = @fopen('files/global/global_page', "w");
            fwrite($page_file, $c[$key]);
            fclose($page_file);
        }
        if(isset($_REQUEST['login'])) { continue; 
        }
            
        /* Only for page specific CMS error handling and login */
        $c['content'] = @file_get_contents("files/".$c['page'].$s.$c[$key]);
        $plug_check = @file_get_contents('files/'.$c['page'].'/pluginOrder');
        if(!$c['content']) {
            if (!empty($plug_check)) {
                $c['content'] = $d['new_page']['exists'];
            } elseif(!isset($d['page'][$c[$key]])) {
                header('HTTP/1.1 404 Not Found');
                $c['content'] = (is_loggedin()) ? $d['new_page']['admin'] : $c['content'] = $d['new_page']['visitor'];
            } 
            else{ $c['content'] = $d['page'][$c[$key]]; }
        }
        break;
    default:
        break;
    }
}

/* Load theme */
require "themes/".$c['global_themeSelect']."/theme.php";


function redirect() 
{
    global $rp;
    if (empty($rp) && !strrpos($_SERVER['REQUEST_URI'], '?login') && !strrpos($_SERVER['REQUEST_URI'], '?logout')) {
        header('Location: p/home', true, 301);
        exit;
    } elseif ($rp === 'global' || $rp === 'error_403') {
        header('Location: ./home');
        exit;
    }
}

function getPage($key)
{
    global $c, $rp;
    $uri = $_SERVER['REQUEST_URI'];
    $c[$key] = (strrpos($uri, '?login') !== false) ? 'login' : $rp;
    $c[$key] = getSlug($c[$key]);
    return $c[$key];
}

function setLoggedin ()
{
    global $c;
    $pass = @file_get_contents('files/global/global_password');
    if (!$pass) {$pass = $c['global_password'];}
    if(isset($_SESSION['l']) and $_SESSION['l'] === $pass) {
        $c['loggedin'] = true; 
    }
}

/* If not loggedin only load non-block plugins and user selected blocks */
function loadPlugins()
{
    global $hook, $c;

    if(is_loggedin()) {
        $load = dirArray('/plugins/');
    } else {
        $load = array();
        $a = dirArray('/plugins/');
        $b = explode("<br />", availableBlocks());
        $diff = array_diff($a, $b);
        
        $c['page'] = getPage('page');
        $plugins = @file_get_contents('files/'.$c['page'].'/pluginOrder');
        if (empty($plugins)) {$plugins = $c['pluginOrder'];}
        $plugins = c_explode($plugins);
        $plugins = array_intersect($a, $plugins);

        $load = array_merge($diff, $plugins);
        $load = array_unique ($load);
    }
    foreach($load as $dir) {
        include_once ROOT.'/plugins/'.$dir.'/index.php';
    }
    include_once "themes/".$c['global_themeSelect']."/scripts.php";
    $hook['admin-head'][] = "\n	<script type='text/javascript' src='./js/editInplace.php?hook=".$hook['admin-richText']."'></script>";
}

function loadHooks($hookName)
{
    global $hook, $c;
    foreach($hook[$hookName] as $h){
        if (isset($h)) {
            echo "\t".$h."\n";
        }
    }
    if ($hookName === 'script' && is_loggedin()) {
        include_once 'js/browse.php';
		echo "\t".$hook['admin-script'][0]."\n";
	}
}

function minCombine($key)
{
    global $hook, $c;
    switch($key){
        case 'css':
            $multiPath = 'js/normalize.css,';
            foreach($hook[$key] as $h){
                if (isset($h) && !empty($h)) {
                    $multiPath .= $h.',';
                }
            }
            $multiPath .= 'themes/'.$c['global_themeSelect'].'/style.css';
            $multiPath = rtrim($multiPath, ',');
            echo "\t<link rel='stylesheet' type='text/css' href='min/f=".$multiPath."' media='screen'/>\n";
        break;
        case 'js':
            $multiPath = 'js/modernizr-2.8.3.min.js,';
            foreach($hook[$key] as $h){
                if (isset($h) && !empty($h)) {
                    $multiPath .= $h.',';
                }
            }
            $multiPath = rtrim($multiPath, ',');
            echo "<script type='text/javascript' src='min/f=".$multiPath."'></script>";
        break;
        case 'script':
            foreach($hook[$key] as $h){
                if (isset($h)) {
                    echo "\t".$h."\n";
                }
            }
            if (is_loggedin()) {
                include_once 'js/browse.php';
                echo "\t".$hook['admin-script'][0]."\n";
            }
        break;
        default:
        break;
    }
}

function availableBlocks ()
{
    global $s;
    $arrayBlocks = array();
    $dirArray = dirArray('/plugins/');
    foreach($dirArray as $dir){
        if (file_exists('plugins/'.$dir.'/template.php')) {
            $arrayBlocks[] = $dir;
        }
    }
    $list = implode("<br />", $arrayBlocks);
    return $list;
}

function dirArray($path) 
{
    $dirArray = array();
    foreach(glob(ROOT.$path.'*', GLOB_ONLYDIR) as $dir) {
        $tmp = (explode('/', $dir));
        $dir = end($tmp);
        $dirArray[] = $dir;
    }
    return $dirArray;
}



/* Load plugins into theme page by plugin order */
function ShowPlugins() 
{
    global $c, $s;
    $plugins = @file_get_contents(ROOT.'/files/'.$c['page'].'/pluginOrder'); 
    if (!$plugins) {
        $plugins = $c['pluginOrder'];
    }
    $plugins = c_explode($plugins);
    $dirArray = dirArray('/plugins/');
    foreach($plugins as $key){
        if (in_array($key, $dirArray)) { 
            include_once ROOT.'/plugins/'.$key.'/template.php';  
        } 
    }
}

/* Generate content by unique name (for plugins) */
function pluginText($id)
{
    global $c, $d, $s;
    $c['plugin'] = $c['page'].'-'.getSlug($id);
    $c['content'] = @file_get_contents(ROOT.'/files/'.$c['page'].$s.$c['plugin']);
    if(!$c['content']) {
        $c['content'] = (is_loggedin()) ? $d['plugin']['admin'] : $c['content'] = $d['plugin']['visitor'];
    }
    content($c['plugin'], $c['content']);
}

function content($id, $content)
{
    global $d;
    echo (is_loggedin()) ? "<span title='".$d['default']['content']."' id='".$id."' class='editText richText'>".$content."</span>" : $content;
}

/* Gallery plugins: if no folder then exit() or return */
function folderExists($folder)
{
    $path = realpath($folder);
    if($path !== false AND is_dir($path)) {
        return true;
    }
    else {
        return false;
    }
}
    
function getSlug($p)
{
    return trim(mb_convert_case(str_replace(' ', '-', $p), MB_CASE_LOWER, "UTF-8"));
}

function is_loggedin()
{
    global $c;
    return $c['loggedin'];
}

function editTags()
{
    global $hook;
    if(!isset($_REQUEST['login']) && !is_loggedin()) {
        return; 
    }
    foreach($hook['admin-head'] as $o){
        echo "\t".$o."\n";
    }
}

/* search backwards starting from haystack length characters from the end */
function startsWith($haystack, $needle) 
{
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}
/* search forward starting from end minus needle length characters */
function endsWith($haystack, $needle) 
{
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

function edit()
{
    global $c,$s,$rp;

    if(isset($_REQUEST['fieldname'], $_REQUEST['content'], $_REQUEST['fullurl'])) {
        $tmp = (explode('/', $_REQUEST['fullurl']));
        $dir = end($tmp);
        $fieldname = $_REQUEST['fieldname'];
        $content = trim(rtrim(stripslashes($_REQUEST['content'])));
        //prevent demo js code from running in pre or code tag while keeping it readable
        $content = preg_replace('#(&lt;|<).?script(.+?)?(&gt;|>)#', '&lsaquo;&#33;script&rsaquo;', $content);
        if(!isset($_SESSION['l'])) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }
        if (startsWith($fieldname, 'global')) {
            $file = @fopen("files/global/".$fieldname, "w");
        } else {
            $file = @fopen("files/".$dir.'/'.$fieldname, "w");
        }
        if(!$file) {
            echo 'Set 755 permission to the files folder.';
            exit;
        }
        fwrite($file, $content);
        fclose($file);
        echo $content;
        exit;
    }
}

CreateDirStructure('general');

/* Remove empty folders on logout (including evt temp new ones) */
function RemoveEmptySubFolders($path)
{
    global $s;
    $empty=true;
    foreach (glob($path.$s."*") as $file) {
        $empty &= is_dir($file) && RemoveEmptySubFolders($file);
    }
    return $empty && rmdir($path);
}


/* Function available to plugins for making image folder(s) */
/* Make sure PHP makes the folders, so she is owner */
function CreateDirStructure($folder)
{
    global $c, $s, $rp;
    if(!empty($rp) && is_loggedin()) {
        $page = c_explode($c['page']); //easy for making new pages
        $m_items = c_explode($c['global_menu']);
        $all_items = array_merge($m_items, $page);
		$folder = strtolower($folder);
        foreach ($all_items as $dir){
		    $dir = str_replace(' ', '-', strtolower($dir));
			$path = "files/".$dir."/".$folder;
            if (!file_exists($path)) { mkdir($path, 0777, true); 
            }
        }
    }
}

function c_explode($arr)
{
    $arr = array_map('trim', explode("<br />", preg_replace("/[\n]/","",$arr)));
	return $arr;
}

function logo() 
{
    global $c;
    CreateDirStructure('logo');
    $dir = $c['page'];
    $imageArray = glob('./files/'.$dir.'/logo/*.{jpg,png}', GLOB_BRACE);
    if (count($imageArray) === 0) {
        $dir = 'home';
        $imageArray = glob('./files/'.$dir.'/logo/*.{jpg,png}', GLOB_BRACE);
    } 
    if (count($imageArray) !== 0) {
        $tmp = (explode('/', $imageArray[0]));
        $logoImg = end($tmp);
        $logoUrl = './files/'.$dir.'/logo/'.$logoImg;
    }
    if (empty($logoUrl)) {
        echo '<a href="p/home"><h1>'.$c['global_title'].'</h1></a>';
    } else {
        echo '<a href="p/home"><img src="'.$logoUrl.'" class="theme-logo" /></a>';
    }
}

function panelMenu()
{
    global $c;
    echo '<div id="panel-menu" >';
    $mlist = c_explode($c['global_menu']);
	
    foreach ($mlist as $cp){  
	    $item = getSlug($cp);
        if ($item === 'global') {
		    $cp = 'error_403';
		    $item = 'error_403';
	    }
		$active = ($c['page'] === $item) ? 'active' : '';
        echo '<a href="p/'.$item.'" class="mbtn '.$active.'" >'.$cp.'</a> '; 
    }
    echo '</div>';
}

function adminMenu()
{
    global $c;
    if(!validate_pw('admin', $c['global_password'])) {
        echo '
            <div id="panel-spacer">Admin</div>

            <div id="admin">
                <a class="mbtn fake-a one action pointer showsettings active" >Settings</a>
                <a class="mbtn fake-a action pointer showplugins" >Plugins</a>
            </div>
        ';
    }
}

function themeFunc($funcName)
{
    if(function_exists($funcName)) { call_user_func($funcName); }
}
function adminFunc($funcName)
{
    if(is_loggedin() && function_exists($funcName)) { call_user_func($funcName); }
}

function login()
{
    global $c, $msg, $dom;
    if ( preg_match("/[^-\w]/i", $_POST['global_password']) ) {
        $msg = 'illegal character';
        return;
    }
    if(!validate_pw($_POST['global_password'], $c['global_password'])) {
        $msg = 'wrong password';
        return;
    }
    /*
    if(validate_pw($dom, '$2y$11$/gXO4tQV8nLNlSioWj9zPOvujxXWl6wPMkb12yDFUPviKt63uIVPa')) {
        return;
    }
    */
    if($_POST['new']) {
        if ( preg_match("/[^-\w]/i", $_POST['new']) ) {
            $msg = 'illegal character';
            return;
        }
        $pwlenght = strlen($_POST['new']);
        if ($pwlenght < 8 || $pwlenght > 56){
            $msg = 'minimum password length is 8 characters';
            return;
        }
        savePassword($_POST['new']);
        $msg = 'password changed, please login with your new password.';
        return;
    }
    $_SESSION['l'] = $c['global_password'];
    SureRemoveDir('pagecache', false);
    header('Location: p/home');
    exit;
}

function savePassword($p)
{
    $file = @fopen('files/global/global_password', 'w');
    if(!$file) {
        echo 'Set 644 permission to the password file.';
        exit;
    }
    fwrite($file, generate_hash($p));
    fclose($file);
    return generate_hash($p);
}

function generate_hash($password, $cost=11)
{
	$salt=substr(base64_encode(openssl_random_pseudo_bytes(17)), 0, 22);
	$salt=str_replace("+", ".", $salt);
	$param='$'.implode(
		'$', array(
			"2y", 
			str_pad($cost, 2, "0", STR_PAD_LEFT), 
			$salt 
		)
	);
	return crypt($password, $param);
}

function validate_pw($password, $hash)
{
    return crypt($password, $hash) === $hash;
}

function phpAlert($function, $e_note)
{
	if (!isset($_SESSION["alerts"]))
		$_SESSION["alerts"] = Array();
		
	if (is_loggedin() && !in_array($function, $_SESSION["alerts"]))
	{		
		echo sprintf('<script type="text/javascript">alert("%s: %s")</script>', $function, $e_note);
		$_SESSION["alerts"][] = $function;
	}
}


/* function: returns files from dir */
function retrieve_files($images_dir) 
{
    $files = array();
    $exts = array('jpg', 'png');
    if($handle = opendir($images_dir)) {
        while(false !== ($file = readdir($handle))) {
            $extension = strtolower(get_extension($file));
            if($extension && in_array($extension, $exts)) {
                $files[] = $file;
            }
        }
        closedir($handle);
    }
    return $files;
}

/* function: returns a file's extension */
function get_extension($file_name) 
{
    //return substr(strrchr($file_name, '.'), 1);
    return pathinfo($file_name, PATHINFO_EXTENSION);
}


/* Add empty index files to all dir in files */
addIndex();
function addIndex() 
{
    if(is_loggedin()) {
        $dirArray = array_merge(dirArray('/files/'), array(''));
        foreach($dirArray as $dir){
            if ($dir == '' || $dir === 'global' || file_exists('files/'.$dir.'/pluginOrder')) {
                $path = preg_replace('~/+~', '/', 'files/'.$dir.'/index.php');
                $FileHandle = fopen($path, 'w') or die('Error: Incorrect folder permissions in /files/ or subfolders');
                fclose($FileHandle);
            }
        }
    }
}

function host()
{
    global $host, $rp;
    $rp = preg_replace(array('#p\/#', '#/+#'), '', (isset($_REQUEST['page'])) ? urldecode($_REQUEST['page']) : '');
    $host = $_SERVER['HTTP_HOST'];
    $dom = explode('.', $host, 3);
    $uri = preg_replace(array('#\/p\/#', '#/+#'), '/', urldecode($_SERVER['REQUEST_URI']));
    $host = (strrpos($uri, $rp) !== false) ? $host.'/'.substr($uri, 0, strlen($uri) - strlen($rp)) : $host.'/'.$uri;
    $host = explode('?', $host);
    $host = '//'.str_replace('//', '/', $host[0]);
    $strip = array('index.php','?','"','\'','>','<','=','(',')','\\');
    $rp = strip_tags(str_replace($strip, '', $rp));
    $scheme = $_SERVER['REQUEST_SCHEME'].':';
    $dom = $dom[count($dom) - 1];
    $host = $scheme.strip_tags(str_replace($strip, '', $host));
}


function settings()
{
    global $c, $d, $e;
    echo "<div class='settings'>
    <!-- <h4 class='toggle'>↕ Settings ↕</h4> -->

    <div class='hide'><br/>
    <a href='javascript:void(0)' onclick='window.document.body.blur();setTimeout(function(){window.location.reload();}, 200);return false;' class='a-button'>Refresh</a><br/>
    <div class='content default' id='settingContent'><!-- start content 1 -->
	<div class='explain block'>".$e['global_theme']."</div>
	<div class='change border block'>Theme select &nbsp;&nbsp;<small><span id='themeSelect'><select name='global_themeSelect' onchange='fieldSave(\"global_themeSelect\",this.value);'>";
    foreach(dirArray('/themes/') as $val) {
        $select = ($val === $c['global_themeSelect']) ? ' selected' : '';
        echo '<option value="'.$val.'"'.$select.'>'.$val."</option>\n";
    }
    echo "</select></span></small></div>";
    foreach(array('global_menu','global_title','description','keywords','global_copyright') as $key){
        echo "<div class='explain block'>".$e[$key]."</div><div class='change border block'><span title='".$key."' id='".$key."' class='editText'>".$c[$key]."</span></div>";
    }
    echo "<div class='explain block'>".$e['pluginOrder']."</div><div class='change border block'>
            <span title='pluginOrder' id='pluginOrder' class='editText' style='display: table-cell; width:84%; '>".$c['pluginOrder']."</span>
          <div class='available-plugins' ><b>Available:</b><br/><br/>"; 
    echo availableBlocks(); 
    echo "</div></div>";
    echo "<div class='explain block'><b>File browser</b> (Browse and edit your files.)</div><div class='change border block'>";

    echo '<br><div id="output">';

    browse(NULL); 

    echo '</div>';
 
 
    echo "</div>";
    echo "</div><!-- end content 1 -->";
    echo "<div class='content' id='settingContent1'><!-- start content 2 -->";
    $i = 0;
    foreach(glob(ROOT.'/plugins/*', GLOB_ONLYDIR) as $pdir) {
        if (file_exists($pdir.'/settings.php')) {
            $i++;
            include_once $pdir.'/settings.php';
        }
    }
    if ($i === 0) {include_once 'plugins/default/empty.php';}
    echo "</div><!-- end content 2 -->";
    echo "<div class='explain'><small>&nbsp;</small></div>";
    echo "</div></div>";
}



/* The below code will restore the default plugin if lost or deleted */


$d['default']['template'] = '
    <div id="wrapper" class="border animated fadeInRight0 block box">
        <div class="imgcont">
            <div class="polycircle">
                <?php defaultIcon(); ?>
            </div>
        </div>
        <div class="padwrap">
            <?php  content($c[\'page\'], $c[\'content\']); ?>
        </div>
     <div class="box-bottom"></div>
    </div>';
    
$d['default']['index'] = '
<?php
// links start with a dot+slash (i.e. start from root)
$c[\'global_default\'] = \'\';
$hook[\'style\'][] = \'<link rel="stylesheet" type="text/css" href="./plugins/default/styles.css" media="screen"/>\';
$hook[\'css\'][] = \'plugins/default/styles.css\';
?>';
    
$d['default']['styles'] = '
#wrapper {
    overflow:hidden;
    min-height:200px;
    font-size:0.857em;
    line-height:130%;
    background: #FCFCFC;
    padding:20px 20px 0px 20px;
    margin: 0px auto 25px auto;
}
#wrapper > * {
    vertical-align:top;
}
#wrapper a{
    color: #627E99;
    border-bottom: 1px dotted #627E99;
}
.padwrap{
    background:#FFFFFF;
    top:2%;
    float:right;
    display:block;
    padding: 20px;
    margin-right:2%;
    min-height:260px;

    border-left:1px solid #d7d7d7;
}
.padwrap input[type=password] {
    min-width:250px;
    margin-right:10px;
}
    .padwrap .hide{
    padding:0;
}
.imgcont {
    clear:both;
    display:block;
    float:left;
    border:0px solid red;
    padding:0 auto 0 auto;
    margin:0;
}
.polycircle {
    display:block;
    width:150px;
    height:150px;
    border-radius: 50%;
    overflow:hidden;
    border:1px solid #D7D7D7;
    margin:3% auto 30px auto;
    background:#fff;
}
.polycircle img {
    height:150px;
    margin:-1px 0 0 -1px;
}

@media screen and (min-width: 900px){
    .imgcont{
        width: 26%;
    }
    .padwrap {
        width: 70%;
    }
}
@media screen and (max-width: 899px){
    .imgcont{
        width: 99%;
    }
    .padwrap {
        width: 99%;
    }

}';

$d['default']['empty'] = '
<?php
echo \'<div class="change border block">
    \'.$d[\'default\'][\'noplug\'].\'
</div>\';
?>';
    
defaultPlugin();
function defaultPlugin ()
{
    global $d;
    if (!file_exists('plugins/default/index.php')){
        mkdir('plugins/default', 0755, true);
        $files = array('template.php', 'styles.css', 'empty.php', 'index.php');
        foreach($files as $file) {
            $name = explode('.', $file, 2);
            $path = 'plugins/default/'.$file;
            $current = $d['default'][$name[0]];
            file_put_contents($path, $current);
        }
        if (file_exists('plugins/default/index.php')){
            header('Location: ./home');
            exit;
        }
    }
}

CreateDirStructure('default');
function defaultIcon()
{
    global $c;
    $iconArray = glob('files/'.$c['page'].'/default/*.{jpg,png,gif}', GLOB_BRACE);
    if (array_key_exists(0, $iconArray)) {
        echo "<img src='".$iconArray[0]."' alt='icon' />";
    } else { 
        echo "<img src='data:image/png;base64,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' alt='icon' />";
    }
}

sitemap();
function sitemap() 
{
    global $c,$host;
    $filename = "sitemap.xml";
    $wdate = date("W");
    $fdate = "";
    if (file_exists($filename)) {
        $fdate = date ("W", filemtime($filename)); 
        //phpAlert(  "sitemap", "File was made in week: ".$fdate  );
    }
    if ($wdate !== $fdate) {
        $elements = c_explode($c['global_menu']);
        $date = date('c',time());
        $head = "<?xml version='1.0' encoding='UTF-8'?>\n<urlset\n      xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'\n      xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'\n      xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9\n            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd'>\n\n";
        $body = "";
        $foot = "</urlset>";
        foreach($elements as $value) {
            $priority = "1";
            if (!empty($body)) {$priority = "0.5";}
            if ($value !== null) {
                $value = strtolower($value);
                $body .= "<url>\n  <loc>".$host."p/".$value."</loc>\n  <lastmod>".$date."</lastmod>\n  <changefreq>weekly</changefreq>\n  <priority>".$priority."</priority>\n</url>\n";            
            }
        }
        $Contents = $head.$body.$foot;
        file_put_contents($filename, $Contents );
    }
}

function browse($post)
{
    if(!is_loggedin()) {
        return; 
    }
    
    $base = '/files';
    $root = ROOT.$base;
    
    
    $path = null;
    if ($post['browse'] !== NULL) {
        $path = $post['browse'];
        if (!is_in_dir($post['browse'], $root)) {
            $path = null;
        } else {
            $path = '/'.$path;
        }
    }

    if ($post['newfolder']  !== NULL && $post['newpath'] !== NULL) {
        $path = $post['newpath'];
        $newfolder = '/'.$post['newfolder'];
        if (!file_exists($root.$path.$newfolder)) {
            mkdir($root.$path.$newfolder, 0755, true);
        }
    }

    $new_n = '';
    $old_n = '';
    if ($post['oldname'] !== NULL && $post['newname'] !== NULL) {
        $old_n = $root.'/'.$post['oldname'];
        $path = '/'.substr(dirname($old_n), strlen($root) + 1);
        $tmp_n = pathinfo($root.$path.'/'.$post['newname'], PATHINFO_FILENAME);
        if (is_dir($old_n)) {
            $new_n = $root.$path.'/'.$tmp_n;
            if (!file_exists($new_n)) {
                sleep(1);
                rename($old_n, $new_n);
            } //not sure how to alert file exists error here.
        }
        elseif (is_file($old_n)) {
            $old_ext = pathinfo($old_n, PATHINFO_EXTENSION);
            $new_n = $root.$path.'/'.$tmp_n.'.'.$old_ext;
            if ($old_ext && !file_exists($new_n)) {
                sleep(1);
                rename ($old_n, $new_n);
            } 

        } 
  
    }
         
    if ($post['delete'] !== NULL) {
        $del_file = $root.'/'.$post['delete'];
        $path = substr(dirname($del_file), strlen($root));
        if (is_file($del_file)) {
            @unlink($del_file);
        }
        if (is_dir($del_file)) {
            SureRemoveDir($del_file, true);
        }
        sleep(1);
    }
    
    $back = urlencode(substr(dirname($root.$path), strlen($root) + 1));
    if (empty($back)) {
        $up = dirname($root);
        $back = urlencode(substr(dirname($root.$path), strlen($up) + 1));
    }

    $farr = glob($root.$path.'/*');
    $fileArray = folderSort($farr);

    $i = 0;
    
    echo '<form method="POST" onsubmit="makeNew();return false;" class="fileform">
        <input type="submit" value="new folder" />
        <input type="text" name="newfolder" id="newfolder" />
        <input type="hidden" name="newpath" id="newpath" value="'.urlencode($path).'">
    </form>';
    
    echo "<div class='browsetable'>";
    
        echo "<div class='filecell'>";
        if ($path) echo '<a href="javascript:void(0);" onclick="browseIt(\''.$back.'\');return false;" >..</a><br />';
        foreach ($fileArray as $file) {
            $file = realpath($file);
            $link = substr($file, strlen($root) + 1);
            $link = str_replace('\\', '/', $link);
            if (is_file($file)) {
                echo '<p class="bg' .($i++ % 2). '">'.basename($file).'</p>';
            } else {
                echo '<p class="bg' .($i++ % 2). '"><a href="javascript:void(0);" onclick="browseIt(\''.urlencode($link).'\');return false;">'.basename($file).'</a></p>';
            }
        }
        echo "</div>";
        
        echo "<div class='smallcell'>";
        if ($path) echo '<br />';
        foreach ($fileArray as $file) {
            $file = realpath($file);
            $link = substr($file, strlen($root) + 1);
            $link = str_replace('\\', '/', $link);
            echo '<p><a href="javascript:void(0);" onclick="renameIt(\''.urlencode($link).'\');return false;" >rename</a></p>';
        }
        echo "</div>";
        
        echo "<div class='smallcell'>";
        if ($path) echo '<br />';
        foreach ($fileArray as $file) {
            $file = realpath($file);
            $link = substr($file, strlen($root) + 1);
            $link = str_replace('\\', '/', $link);
            echo '<p><a href="javascript:void(0);" onclick="deleteIt(\''.urlencode($link).'\');return false;" >delete</a></p>';
        }
        echo "</div>";

            
    echo "</div><br>";
    echo '&nbsp;&nbsp;'.str_replace('\\', '/', $base.$path).'<br>';

}

function folderSort($array) 
{
    $dir = array();
    $file = array();

    foreach($array as $f) {
        if (is_file($f)) {
            $file[] = $f;
        } else {
            $dir[] = $f;
        }
    }
    natsort($dir);
    natsort($file);
    $combined = array_merge($dir, $file);
    $combined = array_values($combined);
    return $combined;
}

function is_in_dir($file, $directory, $recursive = true) {
    $limit = 1000;
    $directory = realpath($directory);
    $parent = realpath($directory.'/'.$file);
    $i = 0;
    while ($parent) {
        if ($directory === $parent) return true;
        if (!$recursive || $parent === dirname($parent)) break;
        $parent = dirname($parent);
    }
    return false;
}

function SureRemoveDir($dir, $DeleteMe) {
    if(!$dh = @opendir($dir)) return;
    while (false !== ($obj = readdir($dh))) {
        if($obj === '.' || $obj === '..') continue;
        if (!@unlink($dir.'/'.$obj)) SureRemoveDir($dir.'/'.$obj, true);
    }

    closedir($dh);
    if ($DeleteMe){
        @rmdir($dir);
    }
}

/* Write html output for cache, exits at the top if recent cache available */
if ($c['page'] !== 'login' && !is_loggedin() && file_exists('files/home/pluginOrder')) 
{
$fp = fopen($cachefile, 'w');
fwrite($fp, ob_get_contents());
fclose($fp);
}

ob_end_flush();
?>
