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

