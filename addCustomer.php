<?php
include('util.php');
begin();

make_head("Add Customer");
?>
  <body>
    <div class="container">
      <? include('navbar.html') ?>
      <h1>Add Customer</h1>
<?php
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
        $res = mysqli_query($db,'INSERT INTO people (firstname, lastname, email, address, cityid, phone) VALUES ("'.$_POST['firstname'].'","'.$_POST['lastname'].'","'.$_POST['email'].'","'.$_POST['address'].'",'.$_POST['city'].','.$_POST['phone'].');');
        if ($res) {
          $personid=mysqli_insert_id($db);
          $res2 = mysqli_query($db,'INSERT INTO customers (personid, contacttype) VALUES ('.$personid.','.$_POST['contacttype'].');');
          if ($res2) {
            echo '<div class="alert alert-success">Customer successfully created</div>';
          } else {
            echo '<div class="alert alert-error">Error creating customer</div>';
          }  
        } else {
          echo '<div class="alert alert-error">Error creating customer</div>';
        }
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
      <form method="post" action="addCustomer.php">
        <input type="hidden" name="submit">
        <input type="text" name="firstname" <? echo ((isset($_POST['firstname']) && $_POST['firstname'] != "") ? "value=".$_POST['firstname'] : "placeholder=\"First name\""); ?>><br/>
        <input type="text" name="lastname" <? echo ((isset($_POST['lastname']) && $_POST['lastname'] != "") ? "value=".$_POST['lastname'] : "placeholder=\"Last name\""); ?>><br/>
        <input type="text" name="email" <? echo ((isset($_POST['email']) && $_POST['email'] != "") ? "value=".$_POST['email'] : "placeholder=\"Email\""); ?>><br/>
        <input type="text" name="address" <? echo ((isset($_POST['address']) && $_POST['address'] != "") ? "value=".$_POST['address'] : "placeholder=\"Address\""); ?>><br/>
        <select name="city">
          <?
          $res3 = $db->query("SELECT * FROM cities c");
          while ($r = $res3->fetch_assoc()) {
            echo "<option value=".$r['cityid'].">" . $r["city"] . ", " . $r['state']  . "</option>\n";
          }
          ?>
        </select><br />
        <input type="text" name="phone" <? echo ((isset($_POST['phone']) && $_POST['phone'] != "") ? "value=".$_POST['phone'] : "placeholder=\"Phone\""); ?>><br/>
        <select name="contacttype">
          <?
          $res4 = $db->query("SELECT * FROM contacttypes c");
          while ($r = $res4->fetch_assoc()) {
            echo "<option value=".$r['contactid'].">" . $r["contact"] . "</option>\n";
          }
          ?>
        </select><br />
        <button class="btn btn-large btn-primary">Add Customer</button>
      </form>
    </div>
  </body>
</html> 
