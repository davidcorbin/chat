<?php
	
require("config.php");

require_once('class.html.php');
$html = new html;

switch ($_GET["error"]) {
	case "404":
		$html->error("<h1>404 Error. Page not found.</h1>");
		break;
		
	case "500";
		$html->error("<h1>500 Error. Internal server error. This has been reported to the administrator.</h1>");
}
