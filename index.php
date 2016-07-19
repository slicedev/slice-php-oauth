<?php
$files = array();
$checked = "";

foreach (glob("*.ini") as $file) {
  $files[] = basename($file, ".ini");
}
if (!isset($_POST['env'])) {
  $msg = "Please choose the environment";
} else {
  $msg = "You chose : " . $_POST['env'];
  header('Location: /gettoken.php?env=' . $_POST['env']);
}
?>
<html>
<body>
  <h3><?php echo $msg; ?></h3>
  <label>Choose environment:</label></td>
  <form method="post" action="index.php">
    <?php foreach($files as $key=>$value){ ?>
      <?php
      if (strcmp($value, "prod") == 0) {
        $checked = "checked";
      } else {
        $checked = "";
      }
      ?>
      <input type="radio" name="env" value="<?=$value?>" <?=$checked?>> <?=$value?><br>
    <?php } ?>
    <input type="submit" value="choose" />
    <input type="submit" formaction="show_config.php" value="Show config">
  </form>
</body>
</html>
