<?php
include('util.php');
begin();

$db = connect_db();
function get_count($table) {
  global $db;
  $res = $db->query('SELECT * FROM ' . $table);
  return $res->num_rows;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Chicago Cars Inventory</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
  </head>
  <body>
    <div class="container">
      <div class="navbar">
        <div class="navbar-inner">
          <a class="brand" href="#">Chicago Cars</a>
          <ul class="nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="customers.php">Customers</a></li>
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="sales.php">Sales</a></li>
            <li><a href="admin.php">Admin</a></li>
          </ul>
        </div>
      </div>
      <h2>Select a section from the menu above</h2>
      <h3>Statistics</h3>
      <ul>
        <li>Total Customers: <?=get_count("customers"); ?></li>
        <li>Total Vehicles: <?=get_count("vehicles"); ?></li>
        <? // TODO: Add more of these. ?>
      </ul>
    </div>
  </body>
</html>

