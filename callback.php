<?php
require_once('auth-lib.php');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (!isset($_GET["code"])) {
	echo "Error : " . $_GET["error"] . "</p>";
	echo "Error description : " . $_GET["error_description"] . "</p>";
} else {
	if (isset($_GET["state"])) {
		$state = explode("=", urldecode($_GET["state"]));
		$env = $state[1];
	} else {
		$env = "slicetest";
	}

	$auth = new Authentication($env);
	$json = $auth->GetAccessToken($_GET["code"]);

	$access_token = $json->access_token;
	$access_token_expires_in = $json->expires_in;
	$refresh_token = $json->refresh_token;

	$json = $auth->GetUserInfo($access_token);
	$email_address = $json->result->userEmail;
}
?>
<html>
<body>
env : <?php echo $env; ?></br>
Access Token : <?php echo $access_token; ?></br>
Expires in   : <?php echo $access_token_expires_in; ?></br>
Refresh Token : <?php echo $refresh_token; ?></br>
Email address of user : <?=$email_address?></br>
<form method="get" action="revoke_token.php">
	<input type="hidden" name="env" value="<?=$env?>" />
	<input type="hidden" name="token" value="<?=$access_token?>" />
	<input type="submit" value="Revoke access token" />
</form>
<form method="get" action="revoke_token.php">
	<input type="hidden" name="env" value="<?=$env?>" />
	<input type="hidden" name="token" value="<?=$refresh_token?>" />
	<input type="submit" value="Revoke refresh token" />
</form>
<form method="get" action="refresh_token.php">
	<input type="hidden" name="env" value="<?=$env?>" />
	<input type="hidden" name="token" value="<?=$refresh_token?>" />
	<input type="submit" value="Refresh token" />
</form>
</body>
</html>
