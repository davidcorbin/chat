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
        <a class="list-group-item">
            <img src="' . $avatar . '" class="img-circle" style="width:100px; margin: auto; display:block;">
        <br>
        Team: ' . $userdata[0]['team_num'] . '
        </a>
    </div>
</div>

';

$html->profile($user);
