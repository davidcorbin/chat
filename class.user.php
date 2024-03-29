<?php

require_once("class.db.php");

class user extends db {

    private $username;

	function __construct($username) {
		$this->username = $username;
		parent::__construct();
		if (!$this->userexists($username)) {
			throw new Exception("User not found");
		}
	}
	
	private function userexists($username) {
		if ($this->rows("SELECT * FROM logins WHERE username='$username'") == 0) {
			return FALSE;
		}
		return TRUE;
	}
	
	public function getUsername() {
		return $this->username;
	}	
	public function getEmail() {
		return $this->get("email");
	}
	public function getAvatar() {
		return $this->get("avatar");
	}
	public function getTeam() {
		return $this->get("team_num");
	}
	public function getType() {
		return $this->get("type");
	}
	public function getPosition() {
		return $this->get("position");
	}
	public function getProfileViews() {
		return $this->get("profile_view_count");
	}
	public function getPostCount() {
		return $this->get("post_count");
	}
	public function getCreatedAt() {
		return $this->get("created_at");
	}
	public function getLocation() {
		return $this->get("location");
	}
	public function getWebsite() {
		return $this->get("website");
	}
	public function getTheme() {
		return $this->get("theme");
	}
	
	private function get($column) {
		$result = $this->fetch("SELECT `$column` FROM logins WHERE username='$this->username'");
		if (empty($result)) {
			echo "Error in user: get() had empty result";
			die();
		}
		return $result[0][$column];
	}
}
