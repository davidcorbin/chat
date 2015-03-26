<?php

require("config.php");

require_once('class.db.php');
$database = new db;

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

$theme = $database->fetch("SELECT theme FROM `logins` WHERE username = '" . $_SESSION['un'] . "'");
$theme = $theme[0]['theme'];

require_once('class.html.php');
$html = new html($theme);
unset($theme);

$page = "";
if (!empty($_GET)) {
	$page = key($_GET);
	$_SESSION['chatkey'] = $page;
}

// New chat message sent
if (!empty($_POST) && isset($_POST['sendbutton'])) {

	// Do query
	$database->query("INSERT INTO `chat_" . $_POST['currentchat'] . "`(`data`, `user`, `date`) VALUES ('" . $database->escape($_POST['sendbutton']) . "','" . $_SESSION['un'] . "','" . time() . "')");
	
	// Increment user post count
	$database->query("UPDATE logins SET `post_count` = post_count + 1 WHERE username = '" . $_SESSION['un'] . "'");
	exit();
}

// Create new chat table
if (!empty($_POST) && isset($_POST['newchat'])) {

	// If no chat name 
	if (!isset($_POST['newchat']) || $_POST['newchat']=="") {
		echo "1";
		exit();
	}
	
	// Check that chat name has only letters and numbers
	if (preg_match('/[^A-Za-z0-9]/', $_POST['newchat'])) {
		echo "Invalid chars";
		exit();
	}

	// Do query
	$database->query("CREATE TABLE IF NOT EXISTS `chat_" . $database->escape($_POST['newchat']) . "` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `data` varchar(256) NOT NULL,
  `user` varchar(256) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;");
	echo "created";
	exit();
}

else {
	$page="#".$page;
	require("html/chat.inc");
	$html->chat($info);
}
