<?
if(isset($_POST['pass'])){
  echo "<h3>".sha1($_POST['pass'])."</h3><br />";
}
?>
<html>
<body>
<form method="post" action="genPassword.php" >
  <input type="text" name="pass">
  <input type="submit" value="Convert">
</form>
</body>
</html>
