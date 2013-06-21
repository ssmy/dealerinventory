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
    <script src="jquery-1.10.1.min.js"></script>
  </head>
  <body>
    <div class="container">
      <?php include('navbar.html'); ?>
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

