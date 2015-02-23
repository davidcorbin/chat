<?php
$lifetime=86400; //24 hours
session_start(); //Start session
setcookie(session_name(), session_id(), time() + $lifetime); //CORRECT  SESSION TIMING! The session will always reset the timing every time the page is refreshed or changes. 

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

unset($_SESSION['un']);
unset($_SESSION['pw']);

require_once('class.db.php');
$database = new db;

require_once('class.html.php');
$html = new html;

if (isset($_POST["un"]) && isset($_POST["pw"])) {
	$check = $database->auth($_POST["un"], $_POST["pw"]);
	if ($check) {
		$_SESSION['un'] = $_POST["un"];
		$_SESSION['pw'] = $_POST["pw"];
		header("Location: chat.php");
	}
	else {		
		$options = array("incorrect" => "true");
		$html->login($options);
	}
}

else {
	$options = array();
	$html->login($options);
}
?>