<?php
include('util.php');
session_start();
if (isset($_SESSION['userid'])) {
  header("Location: " . "menu.php");
  die();
} elseif (isset($_POST['username'])) {
  $db = connect_db();
  $res = $db->query('SELECT * FROM employees WHERE username="' . $_POST['username'] . '" AND PASSWORD="' . sha1($_POST['password']) . '"');
  if ($res->num_rows) {
    $return = $res->fetch_row();
    $_SESSION['userid'] = $return[0];
    header("Location: " . "menu.php");
    die();
  }
}
make_head("Login");
?>
    <style>
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 20px;
        margin: 0 auto 20px;
        border: 1px solid #e5e5e5;
        background-color: #fff;
      }
    </style>
  <body>
    <h1 class="text-center">Chicago Cars Inventory Management</h1>
    <div class="container">
      <form action="index.php" method="post" class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="input-block-level" placeholder="Username" name="username">
        <input type="password" class="input-block-level" placeholder="Password" name="password">
        <button class="btn btn-large btn-primary">Sign In</button>
      </form>
  </body>
</html>
