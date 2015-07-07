<?php
// links start with a dot+slash (i.e. start from root)

//If your server only allows sending from root, uncomment below to move the mailer.

//if (!file_exists(ROOT.'/processForm.php')) {
//  copy(ROOT.'/plugins/contact/processForm.php', ROOT.'/processForm.php');
//}

$c['global_email'] = 'example@mywebsite.com';
$c['global_contact'] = "Email<br />\nContact";
$c['static_form'] = 'We will contact you as soon as possible';
$c['contact'] = 'page(s) your contact form is on';

$hook['style'][] = "<link rel='stylesheet' type='text/css' href='./plugins/contact/styles.css' media='screen' />";
$hook['css'][] = "plugins/contact/styles.css";

$hook['jslib'][] = "<script type='text/javascript' src='./plugins/contact/jquery.validate.min.js'></script>";
$hook['jslib'][] = "<script type='text/javascript' src='./plugins/contact/jquery.form.js'></script>";
$hook['jslib'][] = "<script type='text/javascript' src='./plugins/contact/contact.js'></script>";

$hook['js'][] = "plugins/contact/jquery.validate.min.js";
$hook['js'][] = "plugins/contact/jquery.form.js";
$hook['js'][] = "plugins/contact/contact.js";

?>
