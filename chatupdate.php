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

// Convert get value from string to int
$_GET['latestpost'] = intval($_GET['latestpost']);

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
