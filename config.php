<?php
if (!session_id()) {
    session_start();
}
require_once('vendor/autoload.php');

$FBObject = new \Facebook\Facebook([
	'app_id' => '676863936570880',
	'app_secret' => '0af03d115098e9f6d7e8911eea9ed799',
	'default_graph_version' => 'v8.0'
]);

$handler = $FBObject -> getRedirectLoginHelper();
?>