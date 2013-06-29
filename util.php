<?php
// Start session
// Should be called on every page that needs to be secured.
function begin() {
  session_start();
  if (!isset($_SESSION['userid'])) {
    header('Location: ' . 'index.php');
    die();
  }
}

// MySQL connection
function connect_db() {
  $db = new mysqli("localhost", "cs487", "cs487", "cs487");
  if ($db->connect_errno) {
    echo "Failed to connect to database: " . $db->connect_errno;
    return null;
  }
  return $db;
}

// Check if user is a manager
function is_manager() {
  $db = connect_db();
  $res = $db->query('SELECT * FROM employees WHERE employeeid=' . $_SESSION['userid'] . ' AND rankid=1');
  return $res->num_rows ? true : false;
}

// Generate top section with specified title.
function make_head($title) {
?>
<!DOCTYPE html>
<html>
  <head>
  <title>Chicago Cars :: <?=$title ?></title>
    <script src="jquery-1.10.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link rel="stylesheet" type="text/css" href="main.css"/>
  </head>
<?php
}
?>
