<?php
include('util.php');
begin();
$db = connect_db();
make_head("Customers");
?>
<html>
  <div class="container"/>
    <?php include('navbar.html'); ?>
    <h1>Customers</h1>
    <table class="table table-striped table-bordered table-hover">
      <tr>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Address</td>
        <td>Location</td>
        <td>Phone</td>
        <td>Email</td>
      </tr>
<?php
$res = $db->query("SELECT * FROM customers c, people p, cities ci WHERE p.personid=c.personid AND p.cityid=ci.cityid");
while ($r = $res->fetch_assoc()) {
  echo "<td>" . $r["firstname"] . "</td>";
  echo "<td>" . $r["lastname"] . "</td>";
  echo "<td>" . $r["address"] . "</td>";
  echo "<td>" . $r["city"] . ", " . $r['state'] . "</td>";
  echo "<td>" . $r["phone"] . "</td>";
  echo "<td>" . $r["email"] . "</td>";
  }
  ?>
    </table>
  </div>
</html>
