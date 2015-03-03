<?php

require("config.php");

// Check for session vars but don't validate
if (isset($_SESSION['un']) || isset($_SESSION['pw'])) {
	header("Location: chat.php");
	die();
}

require_once('class.db.php');
$database = new db;

require_once('class.html.php');
$html = new html;

require_once('class.mail.php');
$mail = new mail;

// If there is form data being sent
if (!empty($_POST)) {
	$username_rows = $database->rows("SELECT * FROM logins WHERE username = '" . $database->escape($_POST['username']) . "'");
	$email_rows = $database->rows("SELECT * FROM logins WHERE email = '" . $database->escape($_POST['email']) . "'");

	// If both forms aren't filled in
	if ($_POST['username'] == "" || $_POST['password'] == "" || $_POST['email'] == "") {
		$html->adduser($html->alertdanger('<span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp; Please include username, email, and password.'));
		return false;
	}
	
	// If that username is already taken in the database
	if ($username_rows == 1) {
		$html->adduser($html->alertdanger('<span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp; That USERNAME is already taken. Please choose another one.'));
	}

	// If that email is already taken in the database
	if ($email_rows == 1) {
		$html->adduser($html->alertdanger('<span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp; That EMAIL is already taken. Please choose another one.'));
	}
	
	// Validate email
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$html->adduser($html->alertdanger('<span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp; Please use a valid email!'));
	}
	
	// Do the database query
	else {		
		$database->query("INSERT INTO `logins`(`username`, `password`, `email`, `type`, `post_count`, `profile_view_count`, `created_at`) VALUES ('" .$database->escape($_POST['username']) . "', PASSWORD('" . $database->escape($_POST['password']) . "'),'" . $database->escape($_POST['email']) . "', 'user', 0, 0, " . time() . ")");
		$mail->signupmail($database->escape($_POST['email']), $database->escape($_POST['username']));
		$html->login('newuser');
	}
}

else {
	$html->adduser("");
}
