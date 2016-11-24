<?php
error_reporting(0);
session_start();
$sessionid = session_id();
$xml = simplexml_load_file('users/' . $sessionid . '.xml');
$phonenumber = $xml->phonenumber;
	
?>