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
	
	// Update last post date
	$database->query("UPDATE chats SET `last_update` = " . time() . " WHERE name = '" . $_POST['currentchat'] . "'");
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
  `data` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY `id` (`id`),
  KEY `user` (`user`),
  FOREIGN KEY (`user`) REFERENCES `logins` (`username`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;");

	// Insert new chat into index of chats
	$database->query("INSERT INTO `chats`(`name`, `creator`, `time_created`, `last_updated`) VALUES ('" . $database->escape($_POST['newchat']) . "','" . $_SESSION['un'] . "'," . time() . ",0)");

	echo "created";
	exit();
}

else {

	require_once("class.user.php");
	$me = new user($_SESSION["un"]);

    $myprofile = '
<div class="col-md-12 col-lg-12">
    <div class="panel panel-primary">
        <!--<div class="panel-heading">Heading</div>//-->
        <div class="panel-body nopadding">

        <img class="img-circle avatar-lg" src="' . $me->getAvatar() . '" style="display: block; margin: 30px auto;">
       
        <hr style="margin:0px;">

            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="col-sm-6 col-md-6 col-lg-6" style="padding-bottom: 10px; padding-top: 10px">
                    <a style="margin:auto; text-align:center; color:inherit;">
                        <h4 style="margin:0px;">' . $me->getPostCount() . '</h4>
                        <h6 style="margin:0px;">posts</h6>
                    </a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6" style="padding-bottom: 10px; padding-top: 10px">
                    <a style="margin:auto; text-align:center; color:inherit;">
                        <h4 style="margin:0px;">' . $me->getProfileViews() . '</h4>
                        <h6 style="margin:0px;">views</h6>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
    ';

	$page="#".$page;
	$trends = "";
	$html->chat($page, $trends, $myprofile);
}
