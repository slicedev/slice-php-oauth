<?php
 
require_once('auth-lib.php');
 
error_reporting(E_ALL);
 
$auth = new Authentication();
$url = $auth->RequestAccessCode($auth->ClientId);
 
header("Location: " . $url);
 
?>
