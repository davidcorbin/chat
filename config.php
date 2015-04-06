<?php

// Attempt to disable caching
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$lifetime=86400; // 24 hours
session_start(); // Start session
setcookie(session_name(), session_id(), time() + $lifetime); // CORRECT  SESSION TIMING! The session will always reset the timing every time the page is refreshed or changes. 

$debug = true;
if ($debug) {
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
}

// Function for converting chat message time to "minutes ago"
function timeconvert($utc) {
	$etime = time() - $utc;
	if ($etime < 1) {
		return 'Just now';
	}
	$a = array(12 * 30 * 24 * 60 * 60 => 'year',
			30 * 24 * 60 * 60 => 'month',
			24 * 60 * 60 => 'day',
			60 * 60 => 'hour',
			60 => 'minute',
			1 => 'second'
	);
	foreach ($a as $secs => $str) {
		$d = $etime / $secs;
		if ($d >= 1) {
			$r = round($d);
			return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
		}
	}
}
	