<?php
include('util.php');
begin();
if (!is_manager()) {
  header('Location: parts.php');
  die();
}

make_head("Add Part");
?>
  <body>
    <div class="container">
      <? include('navbar.html') ?>
      <h1>Add Part</h1>
<?php
$db = connect_db();
if (isset($_POST['newsubmit'])) {
  if ($_POST['newpartname'] != "") {
    if ($_POST['newpartquantity'] != "") {
      if ($_POST['newpartcost'] == "") {
        echo '<div class="alert alert-error">Please enter a cost</div>';
      } else {
        $res = mysqli_query($db,'INSERT INTO parts (cost, quantity, name) VALUES ('.$_POST['newpartcost'].','.$_POST['newpartquantity'].',"'.$_POST['newpartname'].'");');
        $_POST['newpartname']="";
        $_POST['newpartquantity']="";
        $_POST['newpartcost']="";
        if ($res) {
          echo '<div class="alert alert-success">Part successfully created</div>';
        } else {
          echo '<div class="alert alert-error">Error creating part</div>';
        }
      }//cost error
    } else {
      echo '<div class="alert alert-error">Please enter a quantity</div>';
    }
  } else {
    echo '<div class="alert alert-error">Please enter a part name</div>';
  }
}
if (isset($_POST['addsubmit'])){
  if ($_POST['addpartquantity']==""){
    echo '<div class="alert alert-error">Please enter a quantity</div>';
  } else{
    $res2 = $db->query('UPDATE parts SET quantity=quantity+"' . $_POST['addpartquantity'] . '" WHERE partid=' . $_POST['addpartpart']);
    if ($db->affected_rows) {
      echo '<div class="alert alert-success">Part successfully updated</div>';
    } else {
      echo '<div class="alert alert-error">Error updating part</div>';
    }
  }
}
 ?>

      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li <?if(!isset($_POST['addsubmit'])) echo "class=\"active\"";?>><a href="#newpart" data-toggle="tab">New Part</a></li>
          <li <?if(isset($_POST['addsubmit'])) echo "class=\"active\"";?>><a href="#addpart" data-toggle="tab">Additional Parts</a></li>
        </ul>
        <div class="tab-content">
          <div id="newpart" <? echo (!isset($_POST['addsubmit'])) ? "class=\"tab-pane active\"" : "class=\"tab-pane\"";?>>
            <form method="post" action="addPart.php">
              <input type="hidden" name="newsubmit">
              <input type="text" name="newpartname" <? echo ((isset($_POST['newpartname']) && $_POST['newpartname'] != "") ? "value=".$_POST['newpartname'] : "placeholder=\"Part name\""); ?>><br/>
              <input type="text" name="newpartquantity" <? echo ((isset($_POST['newpartquantity']) && $_POST['newpartquantity'] != "") ? "value=".$_POST['newpartquantity'] : "placeholder=\"Quantity\""); ?>><br/>
              <input type="text" name="newpartcost" <? echo ((isset($_POST['newpartcost']) && $_POST['newpartcost'] != "") ? "value=".$_POST['newpartcost'] : "placeholder=\"Cost\""); ?>><br/>
              <table name="buttontable"><tr><td>
                <button class="btn btn-large btn-primary">Add Part</button>
            </form></td><td>
            <form action="parts.php"><br />
              <button class="btn btn-large">Cancel</button>
            </form>
              </td></tr></table>
          </div>
          <div id="addpart" <? echo (isset($_POST['addsubmit'])) ? "class=\"tab-pane active\"" : "class=\"tab-pane\"";?>>
            <form method="post" action="addPart.php">
              <input type="hidden" name="addsubmit">
              Part:<br />
              <select name="addpartpart">
                <?
                  $res3 = $db->query("SELECT * FROM parts p");
                  while ($r = $res3->fetch_assoc()) {
                    echo "<option value=".$r['partid'].">" . $r["name"] . "</option>\n";
                  }
                ?>
              </select><br />
              <input type="text" name="addpartquantity" placeholder="Quantity to add"><br/>
              <table name="buttontable"><tr><td>
                <button class="btn btn-large btn-primary">Update Part</button>
            </form></td><td>
            <form action="parts.php"><br />
              <button class="btn btn-large">Cancel</button>
            </form>
              </td></tr></table>
          </div>
        </div><!--tab content-->
      </div><!--tabbable-->
    </div><!--container-->
  </body>
</html> 
