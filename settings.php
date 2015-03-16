<?php

require("config.php");

require_once('class.db.php');
$database = new db;

// Check for session vars but don't validate
if (!isset($_SESSION['un']) || !isset($_SESSION['pw'])) {
	header("Location: chat.php");
	die();
}

//Authorize session credentials
$check = $database->auth($_SESSION["un"], $_SESSION["pw"]);
if (!isset($check)) {
	header("Location: login.php");
	die();
}

$theme = $database->fetch("SELECT theme FROM `logins` WHERE username = '" . $_SESSION['un'] . "'");
$theme = $theme[0]['theme'];

require_once('class.html.php');
$html = new html($theme);

unset($theme);

$user = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");

$content = "";

// If new link for user image
if (!empty($_POST) && $_POST['link']!="") {
	$database->query("UPDATE `logins` SET `avatar`='" . $database->escape($_POST['link']) . "' WHERE username='" . $_SESSION['un'] . "'");
	$user = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");
	$content .= $html->alertsuccess("Updated avatar!");
}

// If new team number
if (!empty($_POST) && $_POST['teamnumber']!="" && $_POST['teamnumber']!=$user[0]['team_num']) {
	$database->query("UPDATE `logins` SET `team_num`='" . $database->escape($_POST['teamnumber']) . "' WHERE username='" . $_SESSION['un'] . "'");
	$user = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");
	$content .= $html->alertsuccess("Updated team number!");
}

// If new team position
if (!empty($_POST) && $_POST['teamposition']!="" && $_POST['teamposition']!=$user[0]['position']) {
	$database->query("UPDATE `logins` SET `position`='" . $database->escape($_POST['teamposition']) . "' WHERE username='" . $_SESSION['un'] . "'");
	$user = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");
	$content .= $html->alertsuccess("Updated team position!");
}

// If new user location
if (!empty($_POST) && $_POST['userlocation']!="" && $_POST['userlocation']!=$user[0]['location']) {
	$database->query("UPDATE `logins` SET `location`='" . $database->escape($_POST['userlocation']) . "' WHERE username='" . $_SESSION['un'] . "'");
	$user = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");
	$content .= $html->alertsuccess("Updated user location!");
}

// If user changed theme
if (!empty($_POST) && $_POST['theme']!="" && strtolower($_POST['theme'])!=$user[0]['theme']) {
	$database->query("UPDATE `logins` SET `theme`='" . strtolower($database->escape($_POST['theme'])) . "' WHERE username='" . $_SESSION['un'] . "'");
	$user = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");
	$content .= $html->alertsuccess("Changed theme!");
}

// If new user website
if (!empty($_POST) && $_POST['website']!="" && $_POST['website']!="http://" && $_POST['website']!=$user[0]['website']) {
    // Remove all illegal characters from a url
    $url = filter_var($_POST['website'], FILTER_SANITIZE_URL);

    // Validate url
    if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
    	// Update database
        $database->query("UPDATE `logins` SET `website`='" . $database->escape($_POST['website']) . "' WHERE username='" . $_SESSION['un'] . "'");
        $content .= $html->alertsuccess("Updated user website!");
    } else {
        $content .= $html->alertdanger("Website not valid! Are you missing http://");
    }
	$user = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");
}

// If account is to be deleted
if (key($_GET)=="delete") {
	$database->query("DELETE FROM `logins` WHERE `username`='" . $database->escape($_SESSION["un"]) . "'");
	// TODO: Add way to tell user that account was deleted, not just redirect
	header("Location: login.php");
}

$avatar = $user[0]['avatar']==""?"http://placehold.it/50/FA6F57/fff&text=ME":$user[0]['avatar'];
$teamnumber = $user[0]['team_num']==0?'placeholder="eg 1234"':'value='.$user[0]['team_num'];
$teamposition = $user[0]['position']==""?'placeholder="eg Build/Electrical"':'value="'.$user[0]['position'].'"';

$userlocation = $user[0]['location']==""?'placeholder="eg San Francisco, California"':'value="'.$user[0]['location'].'"';
$userwebsite = $user[0]['website']==""?'value="http://"':'value="'.$user[0]['website'].'"';
$theme=$user[0]['theme'];

require_once("html/settings.inc");

$html->settings($content);
