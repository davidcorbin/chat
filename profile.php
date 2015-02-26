<?php

require("config.php");

require_once('class.db.php');
$database = new db;

require_once('class.html.php');
$html = new html;

print_r($_GET);