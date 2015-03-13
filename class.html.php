<?php

class html {

	private $theme; // Theme variable

	function __construct($theme="default") {
		$this->theme = $theme;
	}

	// Default HTML template for content
	private function main($content) {
		$theme_url = $this->theme($this->theme);
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
	
	public function error($content) {
		$this->main($content);
	}

	public function alertdanger($content) {
		return '<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>' . $content . '</div>';
	}
	
	public function alertsuccess($content) {
		return '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>' . $content . '</div>';
	}
	
	private function theme($name="default") {
		switch ($name) {
			case "cerulean": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/cerulean/bootstrap.min.css";
				break;
			case "cosmo": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/cosmo/bootstrap.min.css";
				break;
			case "cyborg": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/cyborg/bootstrap.min.css";
				break;
			case "darkly": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/darkly/bootstrap.min.css";
				break;
			case "flatly": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/flatly/bootstrap.min.css";
				break;
			case "journal": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/journal/bootstrap.min.css";
				break;
			case "lumen": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/lumen/bootstrap.min.css";
				break;
			case "paper": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/paper/bootstrap.min.css";
				break;
			case "readable": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/readable/bootstrap.min.css";
				break;
			case "sandstone": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/sandstone/bootstrap.min.css";
				break;
			case "simplex": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/simplex/bootstrap.min.css";
				break;
			case "slate": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/slate/bootstrap.min.css";
				break;
			case "spacelab": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/spacelab/bootstrap.min.css";
				break;
			case "suberhero": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/superhero/bootstrap.min.css";
				break;
			case "united": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/united/bootstrap.min.css";
				break;
			case "yeti": 
				$theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/yeti/bootstrap.min.css";
				break;
			default: 
				$theme_url = "";
		}
		return $theme_url;
	}
}
