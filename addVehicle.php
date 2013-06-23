<?php
include('util.php');
begin();

make_head("Add Vehicle");
?>
  <body>
    <div class="container">
      <? include('navbar.html') ?>
      <h1>Add Vehicle</h1>
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
          $_POST['firstname']="";
          $_POST['lastname']="";
          $_POST['email']="";
          $_POST['address']="";
          $_POST['phone']="";
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

        <input type="text" name="vin" <? echo ((isset($_POST['vin']) && $_POST['vin'] != "") ? "value=".$_POST['vin'] : "placeholder=\"VIN\""); ?>><br/>
        Color:<br />
        <select name="color">
          <?
          $res2 = $db->query("SELECT * FROM colors c");
          while ($r = $res2->fetch_assoc()) {
            echo "<option value=".$r['colorid'].">" . $r["color"] . "</option>\n";
          }
          ?>
        </select><br />
        <script type="text/javascript">
          
          function configureDropDownLists() {
            var modelcount=document.getElementById("modelcount").value;
            document.getElementById("model").options.length = 0;
            var make=document.getElementById("make").value;
            for(var i=0;i<modelcount;i++){
              var curmodel=document.getElementById("model"+(i+1));
              if (curmodel.value==make){
                createOption(document.getElementById("model"), curmodel.name, curmodel.id);
              }
            }
          }
          function createOption(ddl, text, value) {
            var opt = document.createElement('option');
            opt.value = value;
            opt.text = text;
            ddl.options.add(opt);
          }
        </script>
        Make:<br />
        <select id="make" onchange="configureDropDownLists()">
          <?
          $res3 = $db->query("SELECT * FROM makes m");
          while ($r = $res3->fetch_assoc()) {
            echo "<option value=".$r['makeid'].">" . $r["make"] . "</option>\n";
          }
          ?>
        </select><br />
          <?
          $res4 =$db->query("SELECT * FROM models m");
          $modelcount=0;
          while ($r = $res4->fetch_assoc()) {
            echo "<input type=\"hidden\" id=\"model".$r['modelid']."\" value=\"" . $r["makeid"] . "\" name=\"" . $r['model']  . "\">\n";
            $modelcount++;
          }
          echo "<input type=\"hidden\" id=\"modelcount\" value=" . $modelcount . ">\n";
          ?>
        Model:<br />
        <select name="model" id="model" onclick="configureDropDownLists()">
        </select><br />
        <input type="text" name="year" <? echo ((isset($_POST['year']) && $_POST['year'] != "") ? "value=".$_POST['year'] : "placeholder=\"Year\""); ?>><br/>
        Status:<br />
        <select name="status">
          <?
          $res5 = $db->query("SELECT * FROM statuses s");
          while ($r = $res5->fetch_assoc()) {
            echo "<option value=".$r['statusid'].">" . ucwords(strtolower($r["status"])) . "</option>\n";
          }
          ?>
        </select><br />
        Location:<br />
        <select name="location">
          <?
          $res6 = $db->query("SELECT * FROM locations l");
          while ($r = $res6->fetch_assoc()) {
            echo "<option value=".$r['locationid'].">" . $r["name"] . "</option>\n";
          }
          ?>
        </select><br />
        <table name="buttontable"><tr><td>
        <button class="btn btn-large btn-primary">Add Vehicle</button>
      </form></td><td>
      <form action="vehicless.php"><br />
        <button class="btn btn-large">Cancel</button>
      </form>
        </td></tr></table>
    </div>
  </body>
</html> 
