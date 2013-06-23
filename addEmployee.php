<?php
include('util.php');
begin();

make_head("Add Employee");
?>
  <body>
    <div class="container">
      <? include('navbar.html') ?>
      <h1>Add Employee</h1>
<?php
$basestatus = 1;
$db = connect_db();
if (isset($_POST['submit'])) {
  if ($_POST['firstname'] != "" && $_POST['lastname'] != "") {
    if ($_POST['email'] != "") {
      if ($_POST['address'] == "") {
        echo '<div class="alert alert-error">Please enter an address</div>';
      } else {
      if ($_POST['phone'] == "") {
        echo '<div class="alert alert-error">Please enter a phone number</div>';
      } else {
      if ($_POST['user'] == "") {
        echo '<div class="alert alert-error">Please enter a username</div>';
      } else {
      if ($_POST['pass'] == "" || $_POST['duppass'] == "") {
        echo '<div class="alert alert-error">Please enter and confirm password</div>';
      } else {
      if ($_POST['pass'] !=  $_POST['duppass']) {
        echo '<div class="alert alert-error">Passwords do not match</div>';
      } else {
        $res = mysqli_query($db,'INSERT INTO people (firstname, lastname, email, address, cityid, phone) VALUES ("'.$_POST['firstname'].'","'.$_POST['lastname'].'","'.$_POST['email'].'","'.$_POST['address'].'",'.$_POST['city'].','.$_POST['phone'].');');
        if ($res) {
          $personid=mysqli_insert_id($db);
          echo $personid." and ".$_POST['pass']." and ".$_POST['rank'];
          $res2 = mysqli_query($db,'INSERT INTO employees (personid, username, password, rankid, statusid) VALUES ('.$personid.',"'.$_POST['user'].'","'.sha1($_POST['pass']).'",'.$_POST['rank'].','.$basestatus.');');
          $_POST['firstname']="";
          $_POST['lastname']="";
          $_POST['email']="";
          $_POST['address']="";
          $_POST['phone']="";
          $_POST['user']="";
          if ($res2) {
            echo '<div class="alert alert-success">Employee successfully created</div>';
          } else {
            echo '<div class="alert alert-error">Error creating employee</div>';
          }  
        } else {
          echo '<div class="alert alert-error">Error creating employee</div>';
        }
      }//match error
      }//password error
      }//username error
      }//phone error
      }//address error
    } else {
      echo '<div class="alert alert-error">Please enter an email</div>';
    }
  } else {
    echo '<div class="alert alert-error">Please enter both a first and last name</div>';
  }
}
?>
      <form method="post" action="addEmployee.php">
        <input type="hidden" name="submit">
        <input type="text" name="firstname" <? echo ((isset($_POST['firstname']) && $_POST['firstname'] != "") ? "value=".$_POST['firstname'] : "placeholder=\"First name\""); ?>><br/>
        <input type="text" name="lastname" <? echo ((isset($_POST['lastname']) && $_POST['lastname'] != "") ? "value=".$_POST['lastname'] : "placeholder=\"Last name\""); ?>><br/>
        <input type="text" name="email" <? echo ((isset($_POST['email']) && $_POST['email'] != "") ? "value=".$_POST['email'] : "placeholder=\"Email\""); ?>><br/>
        <input type="text" name="address" <? echo ((isset($_POST['address']) && $_POST['address'] != "") ? "value=".$_POST['address'] : "placeholder=\"Address\""); ?>><br/>
        City:<br />
        <select name="city">
          <?
          $res3 = $db->query("SELECT * FROM cities c");
          while ($r = $res3->fetch_assoc()) {
            echo "<option value=".$r['cityid'].">" . $r["city"] . ", " . $r['state']  . "</option>\n";
          }
          ?>
        </select><br />
        <input type="text" name="phone" <? echo ((isset($_POST['phone']) && $_POST['phone'] != "") ? "value=".$_POST['phone'] : "placeholder=\"Phone\""); ?>><br/>
        <input type="text" name="user" <? echo ((isset($_POST['user']) && $_POST['user'] != "") ? "value=".$_POST['user'] : "placeholder=\"Username\""); ?>><br/>
        <input type="password" name="pass" placeholder="Password"><br/>
        <input type="password" name="duppass" placeholder="Confirm password"><br/>
        Rank:<br />
        <select name="rank">
          <?
          $res4 = $db->query("SELECT * FROM ranks r");
          while ($r = $res4->fetch_assoc()) {
            echo "<option value=".$r['rankid'].">" . $r["rank"] . "</option>\n";
          }
          ?>
        </select><br />
        <table name="buttontable"><tr><td>
        <button class="btn btn-large btn-primary">Add Employee</button>
      </form></td><td>
      <form action="employees.php"><br />
        <button class="btn btn-large">Cancel</button>
      </form>
        </td></tr></table>
    </div>
  </body>
</html> 
