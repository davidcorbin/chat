<?php
class db {
	public $dbh;
	public function __construct() {
		$this->dbh = mysqli_connect("localhost", "leapctf3_chat", "chat7") or die("Cannot connect, try again later!");
		mysqli_select_db($this->dbh, "leapctf3_chat") or die("Database doesn't exist");
	}

	//MYSQL Query database
	public function query($sql) {
		return mysqli_query($this->dbh, $sql) or die("Query Error: " . mysqli_errno($this->dbh) . ": " . mysqli_error($this->dbh));
	}
	
	//MYSQL Fetch from database
	public function fetch($sql){
		$query = mysqli_query($this->dbh, $sql);
		$result = array();
		while ($record = mysqli_fetch_array($query, MYSQL_ASSOC)) {
			$result[] = $record;
		}
		return $result;
	}
	
	//MYSQL number of rows from database
	public function rows($sql) {
		$query = mysqli_query($this->dbh, $sql);
		return mysqli_num_rows($query);
	}
	
	//Authorize user
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
?>