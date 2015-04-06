<?php

require("config.php");

// Logout by deleting session username and password
unset($_SESSION['un']);
unset($_SESSION['pw']);

require_once('class.db.php');
$database = new db;

require_once('class.html.php');
$html = new html;

if (isset($_POST["un"]) && isset($_POST["pw"])) {
	$check = $database->auth($_POST["un"], $_POST["pw"]);

    // Username and password correct
	if ($check) {
		// Set session vars
		$_SESSION['un'] = $_POST["un"];
		$_SESSION['pw'] = $_POST["pw"];

        $database->query("UPDATE logins SET `logins` = logins + 1 WHERE username = '" . $_SESSION['un'] . "'");

		// Redirect 
		header("Location: chat.php");
	}

    // Username and password incorrect
	else {		
		$html->login("incorrect");
	}
}

else {
	$html->login("");
}
