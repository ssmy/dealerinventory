<?php
include('util.php');
begin();
$db = connect_db();
make_head("Vehicles");
?>
<body>
  <div class="container"/>
    <?php include('navbar.html'); ?>
    <h1>Vehicles</h1>
    <table class="table table-striped table-bordered table-hover">
      <tr>
        <td>VIN</td>
        <td>Year</td>
        <td>Color</td>
        <td>Make</td>
        <td>Model</td>
        <td>Location</td>
<? // TODO: Add status ?>
      </tr>
<?php
$res = $db->query("SELECT * FROM vehicles v, colors c, models m, makes ma, locations l, cities ci WHERE v.colorid=c.colorid AND v.modelid=m.modelid AND m.makeid=ma.makeid AND v.locationid=l.locationid AND l.cityid=ci.cityid");
while ($r = $res->fetch_assoc()) {
  echo "<tr>";
  echo "<td>" . $r["vin"] . "</td>";
  echo "<td>" . $r["year"] . "</td>";
  echo "<td>" . $r["color"] . "</td>";
  echo "<td>" . $r["make"] . "</td>";
  echo "<td>" . $r["model"] . "</td>";
  echo "<td>" . $r["city"] . ", " . $r['state'] . "</td>";
  echo "</tr>";
  }
  ?>
    </table>
<?if(is_manager()){?>
  <form action=addVehicle.php>
    <input type="submit" value="Add Vehicle" class="btn btn-primary">
  </form>
<?}?>
  </div>
</body>
</html>
