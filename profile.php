<?php

require("config.php");

require_once('class.db.php');
$database = new db;

// Get first GET key and escape
$username = $database->escape(key($_GET));

require_once("class.user.php");

try {
    $user = new user($username);
}
catch (Exception $e) {
    if ($e->getMessage() == "User not found") {
        $error = array();
        $error['error'] = $e->getMessage();
        echo json_encode($error);
        exit();
    }
}

// Add profile view if not looking at my profile
if (!isset($_SESSION['un']) || $_SESSION['un']!=$username) {
    $database->query("UPDATE logins SET `profile_view_count` = profile_view_count + 1 WHERE username = '" . $username . "'");
}

// If logged in and looking at my profile
if (isset($_SESSION['un']) && $_SESSION['un']==$username) {
    $avatar = $user->getAvatar()!=""?$user->getAvatar():"http://placehold.it/50/FA6F57/fff&text=ME";
}
else {
    $avatar = $user->getAvatar()!=""?$user->getAvatar():"http://placehold.it/50/55C1E7/fff&text=U";
}

$values = array();
$values['un'] = $user->getUsername();
$values['avat'] = $avatar;
$values['team'] = $user->getTeam();
$values['pos'] = $user->getPosition();
$values['loc'] = $user->getLocation();
$values['site'] = $user->getWebsite();
$values['createat'] = timeconvert($user->getCreatedAt());
$values['views'] = $user->getProfileViews();
$values['posts'] = $user->getPostCount();

$content = json_encode($values);

echo $content;
