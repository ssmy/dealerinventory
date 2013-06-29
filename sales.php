<?php
include('util.php');
begin();
$db = connect_db();
make_head("Sales");
?>
<html>
  <div class="container"/>
    <?php include('navbar.html'); ?>
    <h1>Vehicle Sales</h1>
    <table class="table table-striped table-bordered table-hover">
      <tr>
        <th>Sale #</th>
        <th>Customer #</th>
        <th>Employee #</th>
        <th>Vehicle #</th>
        <th>Date Sold</th>
        <th>Sale Price</th>
      </tr>
<?php
$res = $db->query("SELECT * FROM vehiclesales p");
while ($r = $res->fetch_assoc()) {
  echo "<td>" . $r["saleid"] . "</td>";
  echo "<td>" . $r["customerid"] . "</td>";
  echo "<td>" . $r["employeeid"] . "</td>";
  echo "<td>" . $r["vehicleid"] . "</td>";
  echo "<td>" . $r["datesold"] . "</td>";
  echo "<td>" . $r["saleprice"] . "</td>";
  }
  ?>
    </table>
    <h1>Part Sales</h1>
    <table class="table table-striped table-bordered table-hover">
      <tr>
        <th>Sale #</th>
        <th>Customer #</th>
        <th>Employee #</th>
        <th>Part #</th>
        <th>Date Sold</th>
        <th>Sale Price</th>
        <th>Quantity</th>
      </tr>
<?php
$res = $db->query("SELECT * FROM partsales p");
while ($r = $res->fetch_assoc()) {
  echo "<td>" . $r["saleid"] . "</td>";
  echo "<td>" . $r["customerid"] . "</td>";
  echo "<td>" . $r["employeeid"] . "</td>";
  echo "<td>" . $r["partid"] . "</td>";
  echo "<td>" . $r["datesold"] . "</td>";
  echo "<td>" . $r["saleprice"] . "</td>";
  echo "<td>" . $r["quantity"] . "</td>";
  }
  ?>
    </table>
  </div>
</html>
