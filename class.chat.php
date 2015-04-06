<?php

require_once("class.db.php");

class chat extends db {

    private $chat, $fetched_data;

    function __construct($chat) {
        $this->chat = $chat;
        parent::__construct();
	if (!$this->tableexists($chat)) {
		throw new Exception("Table not found");
	}
    }

    public function getPosts($numofposts) {
        // Fetch database values for latest comments and user data
        $this->fetched_data = $this->fetch("SELECT * FROM " . $this->chat ." ORDER BY date DESC LIMIT $numofposts");
    }

    public function getPostsAfterId($id, $numofposts) {
        $this->fetched_data = $this->fetch("SELECT * FROM $this->chat WHERE id > $id ORDER BY date ASC LIMIT $numofposts");
    }

    public function getJson() {
        return json_encode($this->fetched_data);
    }

}
