<?php
include('util.php');
begin();

make_head("Admin");
?>
  <body>
    <div class="container">
      <? include('navbar.html') ?>
      <h1>Admin</h1>
<?php
if (isset($_POST['oldpass'])) {
  $db = connect_db();
  $res = $db->query('SELECT * FROM employees WHERE employeeid=' . $_SESSION['userid'] . ' AND password="' . sha1($_POST['oldpass']) . '"');
  if ($res->num_rows) {
    if ($_POST['newpass1'] == $_POST['newpass2']) {
      if ($_POST['newpass1'] == "") {
        echo '<div class="alert alert-error">Password cannot be blank</div>';
      } else {
        $res = $db->query('UPDATE employees SET password="' . sha1($_POST['newpass1']) . '" WHERE employeeid=' . $_SESSION['userid']);
        if ($db->affected_rows) {
          echo '<div class="alert alert-success">Password successfully changed</div>';
        } else {
          echo '<div class="alert alert-error">Error changing password</div>';
        }
      }
    } else {
      echo '<div class="alert alert-error">New passwords do not match</div>';
    }
  } else {
    echo '<div class="alert alert-error">Incorrect password</div>';
  }
}
?>
      <h2>Change Password</h2>
      <form method="post" action="admin.php">
        <input type="password" name="oldpass" placeholder="Old password"><br/>
        <input type="password" name="newpass1" placeholder="New password"><br/>
        <input type="password" name="newpass2" placeholder="Enter again"><br/>
        <button class="btn btn-large btn-primary">Change Password</button>
      </form>
    </div>
  </body>
</html> 
