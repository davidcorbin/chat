<?php

class mail {

	// Send mail
	public function sendmail($to, $subject, $message) {
		$headers = 'From: noreply@leapctf.siteground.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
		mail($to, $subject, $message, $headers);
	}
	
	// Signup mail from template
	public function signupmail($email, $username) {
		include "mail/signup.inc";
		$this->sendmail($email, $subject, $mail);
	}
}