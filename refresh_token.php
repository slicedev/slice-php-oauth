<?php
require_once('auth-lib.php');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (!isset($_GET["token"])) {
	echo "<h3>Refresh token not provided as token parameter!</h3>";
  $json = "{}";
} else {
  if (isset($_GET["env"])) {
		$env = $_GET["env"];
	} else {
		$env = "slicetest";
	}
	$token = $_GET["token"];
	$auth = new Authentication($env);

	# Provide authorization code to Slice to get a set of access and refresh tokens
	$json = $auth->RefreshToken($token);
}
?>
<html>
<body>
Revoke Token response :
<pre>
<?php echo json_encode($json, JSON_PRETTY_PRINT); ?>
</pre>
</body>
</html>
