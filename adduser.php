<?php
$lifetime=86400; //24 hours
session_start(); //Start session
setcookie(session_name(), session_id(), time() + $lifetime); //CORRECT  SESSION TIMING! The session will always reset the timing every time the page is refreshed or changes. 

/*
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
*/


require_once('class.db.php');
$database = new db;

require_once('class.html.php');
$html = new html;

//If there is form data being sent
if (!empty($_POST)) {
	$rows = $database->rows("SELECT * FROM logins WHERE username = '" . $_POST['username'] . "'");
	
	//If both forms aren't filled in
	if ($_POST['username'] == "" || $_POST['password'] == "") {
		$html->adduser('<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp; Please include both username and password.</div>');
		return false;
	}
	
	//If that username is already taken in the database
	if ($rows == 1) {
		$html->adduser('<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp; That username is already taken. Please choose another one.</div>');
	}
	
	//Do the database query
	else {
		$database->query("INSERT INTO `logins`(`username`, `password`) VALUES ('" .$_POST['username'] . "', PASSWORD('" . $_POST['password'] . "'))");
		$newuser = array("newuser" => "true");
		$html->login($newuser);
	}
}

else {
	$html->adduser("");
}

?>