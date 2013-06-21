<?php
// MySQL connection
function connect_db() {
  $db = new mysqli("localhost", "cs487", "cs487", "cs487");
  return $db;
}

