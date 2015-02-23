<?php

require("config.php");

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
		$html->login("incorrect");
	}
}

else {
	$html->login("");
}
?>