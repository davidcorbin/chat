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

// If new link for user image
if (!empty($_POST) && $_POST['link']!="") {
	$database->query("UPDATE `logins` SET `avatar`='" . $database->escape($_POST['link']) . "' WHERE username='" . $_SESSION['un'] . "'");
	$user = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");
	$content .= $html->alertsuccess("Updated avatar!");
}

// If account is to be deleted
if (key($_GET)=="delete") {
	$database->query("DELETE FROM `logins` WHERE `username`='" . $database->escape($_SESSION["un"]) . "'");
	// TODO: Add way to tell user that account was deleted, not just redirect
	header("Location: login.php");
}

$avatar = $user[0]['avatar']==""?"http://placehold.it/50/FA6F57/fff&text=ME":$user[0]['avatar'];

require_once("html/settings.inc");

$html->settings($content);
