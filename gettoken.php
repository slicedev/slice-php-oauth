<?php
require_once('auth-lib.php');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (!isset($_GET['env'])) {
  $env = "slicetest";
} else {
  $env = $_GET['env'];
}

$auth = new Authentication($env);
$url = $auth->RequestAccessCode();

header("Location: " . $url);
?>
