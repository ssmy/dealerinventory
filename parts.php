<?php
include('util.php');
begin();
$db = connect_db();
make_head("Parts");
?>
<html>
  <div class="container"/>
    <?php include('navbar.html'); ?>
    <h1>Parts</h1>
    <table class="table table-striped table-bordered table-hover">
      <tr>
        <td>Part #</td>
        <td>Cost</td>
        <td>Name</td>
        <td>Quantity</td>
      </tr>
<?php
$res = $db->query("SELECT * FROM parts p");
while ($r = $res->fetch_assoc()) {
  echo "<td>" . $r["partid"] . "</td>";
  echo "<td>" . $r["cost"] . "</td>";
  echo "<td>" . $r["name"] . "</td>";
  echo "<td>" . $r["quantity"] . "</td>";
  }
  ?>
    </table>
  </div>
</html>
