<?php

require_once("config.php");

require_once('class.db.php');
$database = new db;

require_once('class.html.php');
$html = new html;

//Check for session vars
if (!isset($_SESSION['un']) || !isset($_SESSION['pw'])) {
	echo "Error in your session! Try refreshing.<script>window.location.replace(window.location.pathname);</script>";
	die();
}

//Authorize session credentials
$check = $database->auth($_SESSION["un"], $_SESSION["pw"]);
if (!isset($check)) {
	echo "Error in your session! Try refreshing.<script>window.location.replace(window.location.pathname);</script>";
	die();
}

$chat = key($_GET);
$chat = "chat_".$chat;

// Exit if table doesn't exist
if (!$database->tableexists($chat)) {
	echo "No";
	exit();
}


// Fetch database values for latest comments and user data
$chat = $database->fetch("SELECT * FROM " . $chat ." ORDER BY date DESC LIMIT 50");

$me = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");


// Create html 
for ($i = 0; $i < count($chat); $i++) {
	// If post is my me
	if ($chat[$i]['user'] == $_SESSION['un']) {
	
		if ($me[0]['avatar']=="") {
			$avatar = "http://placehold.it/50/FA6F57/fff&text=ME";
		}
		else {
			$avatar = $me[0]['avatar'];
		}
		echo '<li class="right clearfix"><span class="chat-img pull-right"><a target="_blank" href="profile/' . $chat[$i]['user'] . '"><img src="' . $avatar . '" alt="User Avatar" class="img-circle avatar" /></a></span><div class="chat-body clearfix"><div class="header"><strong class="primary-font">';
		
		// If admin, show icon in front of name
		echo $me[0]['type']=="admin"?'<span class="glyphicon glyphicon-flash" style="color:black;"></span>':'';
		echo $chat[$i]['user'];
		echo '</strong><small class="pull-right text-muted"> <span class="glyphicon glyphicon-time"></span>';
		echo timeconvert($chat[$i]['date']);
		echo '</small></div><p>';
		echo htmlspecialchars($chat[$i]['data']);
		echo '</p></div></li>';
	}
	
	// If post is by anyone else
	else {
	
		$chat_user = $database->fetch("SELECT * FROM `logins` WHERE username='" . $chat[$i]['user'] . "'");
	
		if (empty($chat_user) || $chat_user[0]['avatar']=="") {
			$avatar = "http://placehold.it/50/55C1E7/fff&text=U";
		}
		else {
			$avatar = $chat_user[0]['avatar'];
		}
		
		echo '<li class="left clearfix"><span class="chat-img pull-left"><a target="_blank" href="profile/' . $chat[$i]['user'] . '"><img src="' . $avatar . '" alt="User Avatar" class="img-circle avatar" /></a></span><div class="chat-body clearfix"><div class="header"><small class="text-muted"><span class="glyphicon glyphicon-time"></span>';
		echo timeconvert($chat[$i]['date']);
		echo '</small><strong class="pull-right primary-font">';
		
		// If admin show icon in front of name
		echo !empty($chat_user) && $chat_user[0]['type']=="admin"?'<span class="glyphicon glyphicon-flash" style="color:black;"></span>':'';
		echo $chat[$i]['user'];
		echo '</strong></div><p>';
		echo htmlspecialchars($chat[$i]['data']);
		echo '</p></div></li>';
	}		
}
