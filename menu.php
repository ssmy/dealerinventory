<?php
include('util.php');
begin();

$db = connect_db();
function get_count($table) {
  global $db;
  $res = $db->query('SELECT * FROM ' . $table);
  return $res->num_rows;
}
make_head("Menu");
?>
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

