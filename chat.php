<?php

require("config.php");

require_once('class.db.php');
$database = new db;

require_once('class.html.php');
$html = new html;

//Check for session vars
if (!isset($_SESSION['un']) || !isset($_SESSION['pw'])) {
	header("Location: login.php");
	die();
}

//Authorize session credentials
$check = $database->auth($_SESSION["un"], $_SESSION["pw"]);
if (!isset($check)) {
	header("Location: login.php");
	die();
}

$page = "";
if (!empty($_GET)) {
	$page = key($_GET);
	$_SESSION['chatkey'] = $page;
}

// New chat message sent
if (!empty($_POST) && isset($_POST['sendbutton'])) {
	$database->query("INSERT INTO `chat`(`data`, `user`, `date`) VALUES ('" . $database->escape($_POST['sendbutton']) . "','" . $_SESSION['un'] . "','" . time() . "')");
	$database->query("UPDATE logins SET `post_count` = post_count + 1 WHERE username = '" . $_SESSION['un'] . "'");
}

else {
	require("html/chat.inc");
	$html->chat($info);
}
