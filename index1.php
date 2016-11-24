<?php
echo $_POST['Event'];
exit;
session_start();
$sessionid = session_id();
$phonenumber=$_POST['Channel'];
$xml = new SimpleXMLElement('<user></user>');
$xml->addChild('sessionid', $sessionid);
$xml->addChild('phonenumber', $phonenumber);
$xml->asXML('users/' . $sessionid . '.xml');
if(file_exists('users/' . $sessionid . '.xml')){
	$xml = new SimpleXMLElement('users/' . $sessionid . '.xml', 0, true);
}

if($_POST['Event'] == "offered") {
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=customerlist.php">';    
	die;
} elseif($_POST['Event'] == "accepted") {
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=casedetail.php">';    
	die;
}

?>