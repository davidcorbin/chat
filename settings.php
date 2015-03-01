<?php

require("config.php");

// Check for session vars but don't validate
if (!isset($_SESSION['un']) || !isset($_SESSION['pw'])) {
	header("Location: chat.php");
	die();
}

require_once('class.db.php');
$database = new db;

require_once('class.html.php');
$html = new html;

$user = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");

$content = "";

if (!empty($_POST) && $_POST['link']!="") {
	$database->query("UPDATE `logins` SET `avatar`='" .$_POST['link'] . "' WHERE username='" . $_SESSION['un'] . "'");
	$user = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");
	$content .= $html->alertsuccess("Updated avatar!");
}

$avatar = $user[0]['avatar']==""?"http://placehold.it/50/FA6F57/fff&text=ME":$user[0]['avatar'];

require_once("html/settings.inc");

$html->settings($content);
