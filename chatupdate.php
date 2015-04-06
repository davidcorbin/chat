<?php

require_once("config.php");

require_once('class.db.php');
$database = new db;

//Check for session vars
if (!isset($_SESSION['un']) || !isset($_SESSION['pw'])) {
	echo "Error in your session! Try refreshing";
	die();
}

//Authorize session credentials
$check = $database->auth($_SESSION["un"], $_SESSION["pw"]);
if (!isset($check)) {
	echo "Error in your session! Try refreshing";
	die();
}

$chatname = "chat_".$_GET['chatpage'];

if ($chatname == "chat_") {
    echo "no";
    exit();
}

require_once("class.user.php");

require_once("class.chat.php");

// Try to create chat object
try {
    $chat = new chat($chatname);
}
catch (Exception $e) {
    // If table doesn't exist
    if ($e->getMessage() == "Table not found") {
        echo "create";
        exit();
    }
}

$chat->getPostsAfterId($_GET['latestpost'], 50);
$resultjson = $chat->getJson();
$decoded = json_decode($resultjson, true);

// Parse each post in array
for ($i = 0; $i < count($decoded); $i++) {

    // Create json parameter to tell if the post is from the logged in user
    if ($decoded[$i]["user"] == $_SESSION["un"]) {
        $decoded[$i]["me"] = TRUE;
    }
    else {
        $decoded[$i]["me"] = FALSE;
    }

	// Change date from UTC int to "x days ago"
	$decoded[$i]["date"] = timeconvert($decoded[$i]["date"]);
	
	// Try to create user object from username 
	try {
		$user = new user($decoded[$i]["user"]);
	}
	catch (Exception $e) {
		
		// If user is not in database
		if ($e->getMessage() == "User not found") {
			$decoded[$i]["avatar"] = "/chat/images/NotFound-web.png";
			$decoded[$i]["user"] = $decoded[$i]["user"] . "(deleted)"; 
		}
		continue;
	}

	// Set user profile image from user object
	$decoded[$i]["avatar"] = $user->getAvatar();
	// If user is me
	if ($decoded[$i]["avatar"]=="" && $_SESSION["un"]==$user->getUsername()) {
		$decoded[$i]["avatar"] = "images/ME-web.png";
	}
	else if ($decoded[$i]["avatar"]=="" && $_SESSION["un"]!=$user->getUsername()) {
		$decoded[$i]["avatar"] = "images/U-web.png";
	}
}

print_r(json_encode($decoded));
exit();







// Fetch database values for latest comments and user data
$chat = $database->fetch("SELECT * FROM " . $chat ." ORDER BY date DESC LIMIT 50");

$me = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");

// If no posts in chat
if (count($chat)==0) {
	echo "No posts yet. Be the first!";
	exit();
}

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
		echo '<li class="right clearfix"><span class="chat-img pull-right"><a data-toggle="modal" data-target="#profileView" data-user="' . $chat[$i]['user'] . '"><img src="' . $avatar . '" alt="User Avatar" class="img-circle avatar" /></a></span><div class="chat-body clearfix"><div class="header"><strong class="primary-font">';
		
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
		
		echo '<li class="left clearfix"><span class="chat-img pull-left"><a data-toggle="modal" data-target="#profileView" data-user="' . $chat[$i]['user'] . '"><img src="' . $avatar . '" alt="User Avatar" class="img-circle avatar" /></a></span><div class="chat-body clearfix"><div class="header"><small class="text-muted"><span class="glyphicon glyphicon-time"></span>';
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
