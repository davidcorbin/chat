<?php

	// Force redirect to chat
	header("Location: chat.php");
	
	// Kill the process (forcing immediate redirect)
	die();
