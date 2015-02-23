<?php

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

$lifetime=86400; //24 hours
session_start(); //Start session
setcookie(session_name(), session_id(), time() + $lifetime); //CORRECT  SESSION TIMING! The session will always reset the timing every time the page is refreshed or changes. 

