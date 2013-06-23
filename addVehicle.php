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
  if ($_POST['vin'] != "") {
    if ($_POST['year'] != "") {
        $res = mysqli_query($db,'INSERT INTO vehicles (vin, colorid, modelid, year, statusid, locationid) VALUES ("'.$_POST['vin'].'",'.$_POST['color'].','.$_POST['model'].','.$_POST['year'].','.$_POST['status'].','.$_POST['location'].');');
        $_POST['vin']="";
        $_POST['year']="";
      if ($res) {
        echo '<div class="alert alert-success">Vehicle successfully created</div>';
      } else {
        echo '<div class="alert alert-error">Error creating vehicle</div>';
      }
    } else {
      echo '<div class="alert alert-error">Please enter a year</div>';
    }
  } else {
    echo '<div class="alert alert-error">Please enter a VIN</div>';
  }
}
?>
      <form method="post" action="addVehicle.php">
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
            opt.value = value.split("l").pop();
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
        <select name="model" id="model">
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
      <form action="vehicles.php"><br />
        <button class="btn btn-large">Cancel</button>
      </form>
        </td></tr></table>
    </div>
  </body>
</html> 
