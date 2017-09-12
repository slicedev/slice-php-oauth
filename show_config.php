<?php
if (isset($_POST["env"])) {
  $env = $_POST["env"];
} else {
  $env = "slicetest";
}

$inifile = $env . ".ini";
$ini = parse_ini_file($inifile);

?>
<html>
<body>
<pre>
  client_id     : <?php echo $ini['client_id']; ?> <br/>
  client_secret : <?php echo $ini['client_secret']; ?> <br/>
  redirect_uri  : <?php echo $ini['redirect_uri']; ?> <br/>
  authorize_url : <?php echo $ini['authorize_url']; ?> <br/>
  base_api_url  : <?php echo $ini['base_api_url']; ?> <br/>
  token_url     : <?php echo $ini['token_url']; ?> <br/>
  use_proxy     : <?php echo $ini['use_proxy'] ? 'true' : 'false'; ?> <br/>
</pre>
</body>
</html>
