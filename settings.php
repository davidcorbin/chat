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

$all = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");

if ( !empty($_POST) ) {
	print_r($_POST);
	$database->query("UPDATE `logins` SET `avatar`='" .$_POST['link'] . "' WHERE username='" . $_SESSION['un'] . "'");
	
}

$html->settings($all);
