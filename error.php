<?php
	
require("config.php");

require_once('class.html.php');
$html = new html;

switch ($_GET["error"]) {
	case "404":
		$html->error("<h1>404 Error. Page not found ;-(</h1>", "Page not found");
		break;
		
	case "500";
		$html->error("<h1>500 Error. That's an error on our part. This has been reported to the administrator and will be fixed as soon as possible.</h1>", "Server error");
}
