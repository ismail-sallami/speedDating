<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

/*********** SOME DEFINES **************/
define('USERSIMAGEPATH', '../images/profiles/');
date_default_timezone_set('Europe/Berlin');
/***************************************/

require_once("db-settings.php"); //Require DB connection

//Retrieve settings
$stmt = $mysqli->prepare("SELECT id, name, value
	FROM ".$db_table_prefix."configuration");	
$stmt->execute();
$stmt->bind_result($id, $name, $value);

while ($stmt->fetch()){
	$settings[$name] = array('id' => $id, 'name' => $name, 'value' => $value);
}
$stmt->close();


//Language
//detect language
preg_match('~^/[a-z]{2}(?:/|$)~', $_SERVER['REQUEST_URI'], $match);

if(isSet($match) && !empty($match))
{
	$lang = str_replace('/', '', $match);
	$lang = $lang[0];

// register the session and set the cookie
	$_SESSION['lang'] = $lang;

	setcookie('lang', $lang, time() + (3600 * 24 * 30));
}
else if(isSet($_SESSION['lang']))
{
	$lang = $_SESSION['lang'];
}
else if(isSet($_COOKIE['lang']))
{
	$lang = $_COOKIE['lang'];
}
else
{
	$lang = 'en';
}
switch ($lang) {
	case 'en':
		$lang_file = 'en.php';
		setlocale(LC_ALL, "en_EN.utf8");
		break;

	default:
		$lang_file = 'de.php';
		setlocale(LC_ALL, "de_DE.utf8");
}

//Set Settings
$emailActivation = $settings['activation']['value'];
$mail_templates_dir = "../models/mail-templates-".$lang."/";
$websiteName = $settings['website_name']['value'];
$websiteUrl = $settings['website_url']['value'];
$emailAddress = $settings['email']['value'];
$resend_activation_threshold = $settings['resend_activation_threshold']['value'];
$emailDate = date('dmy');
$language = $settings['language']['value'];
$template = $settings['template']['value'];

$master_account = -1;

$default_hooks = array("#WEBSITENAME#","#WEBSITEURL#","#DATE#");
$default_replace = array($websiteName,$websiteUrl,$emailDate);


include_once 'languages/'.$lang_file;

//Pages to require
require_once("class.mail.php");
require_once("class.user.php");
require_once("class.newuser.php");
require_once("funcs.php");

/******************************/
/* Dont forget to add/delete this line for iPage server */
/******************************/
session_save_path('/home/users/web/b2874/ipg.hitchmede/cgi-bin/tmp');
session_start();

//Global User Object Var
//loggedInUser can be used globally if constructed
if(isset($_SESSION["userCakeUser"]) && is_object($_SESSION["userCakeUser"]))
{
	$loggedInUser = $_SESSION["userCakeUser"];
}

?>
