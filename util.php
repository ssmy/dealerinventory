<?php
// MySQL connection
function connect_db() {
  $db = new mysqli("localhost", "cs487", "cs487", "cs487");
  if ($db->connect_errno) {
    echo "Failed to connect to database: " . $db->connect_errno;
    return null;
  }
  return $db;
}

