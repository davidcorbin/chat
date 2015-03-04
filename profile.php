<?php

require("config.php");

require_once('class.db.php');
$database = new db;

require_once('class.html.php');
$html = new html;

// Get first GET key and escape
$user = $database->escape(key($_GET));

$userdata = $database->fetch("SELECT * FROM `logins` WHERE username = '" . $user . "'");

// Check if user exists
if (empty($userdata)) {
	$html->profile("Username doesn't exist. The account must have been deleted or removed.");
}

// Add profile view
if (!isset($_SESSION['un']) || $_SESSION['un']!=$userdata[0]['username']) {
	$database->query("UPDATE logins SET `profile_view_count` = profile_view_count + 1 WHERE username = '" . $userdata[0]['username'] . "'");
	// Reupdate user database data
	$userdata = $database->fetch("SELECT * FROM `logins` WHERE username = '" . $user . "'");
}

// If logged in and looking at my profile
if (isset($_SESSION['un']) && $_SESSION['un']==$userdata[0]['username']) {
	$avatar = $userdata[0]['avatar']!=""?$userdata[0]['avatar']:"http://placehold.it/50/FA6F57/fff&text=ME";
}
else {
	$avatar = $userdata[0]['avatar']!=""?$userdata[0]['avatar']:"http://placehold.it/50/55C1E7/fff&text=U";
}

$user = '

<div class="col-md-8 col-lg-6 col-centered">
    <div class="list-group">
        <a class="list-group-item active">' . $userdata[0]['username'] . '</a>
        <div class="list-group-item">
            <img src="' . $avatar . '" class="img-circle" style="width:100px; margin: auto; display:block;">';

$user .= $userdata[0]['team_num']!="0"?'
        <br>
        Team: ' . $userdata[0]['team_num']:"";

$user .= $userdata[0]['position']!=""?'
        <br>
        Position: ' . $userdata[0]['position']:"";

$user .= $userdata[0]['location']!=""?'
        <br>
        Location: ' . $userdata[0]['location']:"";

$user .= $userdata[0]['website']!=""?'
        <br>
        Site: <a href="' . $userdata[0]['website'] . '">' . $userdata[0]['website'] . '</a>':"";

$user .= '
        <br>
        Created: ' . timeconvert($userdata[0]['created_at']) . '
        <br>
        Profile views: ' . $userdata[0]['profile_view_count'] . '
        <br>
        Number of posts: ' . $userdata[0]['post_count'] . '
        </div>
    </div>
</div>

';

$html->profile($user);
