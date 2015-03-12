<?php

class db {
	public $dbh; // Database credentials
	
	public function __construct() {
		require_once("dbconf.php");
		$this->dbh = mysqli_connect($mysql_host, $mysql_user, $mysql_pass) or die("Cannot connect, try again later!");
		mysqli_select_db($this->dbh, $mysql_db) or die("Database doesn't exist");
		if (!$this->dbh->set_charset("utf8")) {
			printf("Error loading character set utf8: %s\n", $this->dbh->error);
		}
	}
	
	// MYSQL Escape input string
	public function escape($string) {
		return mysqli_real_escape_string($this->dbh, $string);
	}

	// MYSQL Query database
	public function query($sql) {
		return mysqli_query($this->dbh, $sql) or die("Query Error: " . mysqli_errno($this->dbh) . ": " . mysqli_error($this->dbh));
	}
	
	// MYSQL Fetch from database
	public function fetch($sql){
		$query = mysqli_query($this->dbh, $sql);
		$result = array();
		while ($record = mysqli_fetch_array($query, MYSQL_ASSOC)) {
			$result[] = $record;
		}
		return $result;
	}
	
	// MYSQL number of rows from database
	public function rows($sql) {
		$query = mysqli_query($this->dbh, $sql);
		return mysqli_num_rows($query);
	}
	
	// MYSQL check if table exists
	public function tableexists($table) {
		$rows = $this->rows("SHOW TABLES LIKE '" . $table . "'");
		if ($rows == 1) 
			return TRUE;
		else 
			return FALSE;
	}
	
	// Authorize user
	public function auth($un, $pw) {
		$query = $this->fetch("SELECT * FROM logins WHERE username ='" . mysqli_real_escape_string($this->dbh, $un) . "' AND password = PASSWORD('" . mysqli_real_escape_string($this->dbh, $pw) . "')");	
		if ($query) {
			return true;
		}
		else {
			return false;
		}
	}
}
