<?php

class html {
	// Default HTML template for content
	private function main($content) {
		include("html/main.inc");
		exit();
	}
	
	public function login($options) {
		include("html/login.inc");
		
		if ($options == 'incorrect') {
			$this->main($this->alertdanger('Incorrect username and/or password!') . $form);
		}
		
		elseif ($options == 'newuser') {
			$this->main($this->alertsuccess('User successfully created! Now login!') . $form);
		}
		
		else {
			$this->main($form);
		}
	}
	
	
	public function chat($info) {	
		$this->main($info);
	}
	
	public function profile($user) {
		$this->main($user);
	}
		
	public function adduser($error) {
		include("html/adduser.inc");
		$this->main($error . $form);
	}
	
	public function settings($content) {
		$this->main($content);
	}

	public function alertdanger($content) {
		return '<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>' . $content . '</div>';
	}
	
	public function alertsuccess($content) {
		return '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>' . $content . '</div>';
	}
}
