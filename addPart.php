<?php
include('util.php');
begin();
if (!is_manager()) {
  header('Location: vehicles.php');
  die();
}
$db = connect_db();
if (isset($_POST['submit']) && ($_POST['action']=="add" || $_POST['action']=="update")) {
  if ($_POST['cost'] != "" && $_POST['name'] != "" && $_POST['quantity']!="") {
    if($_POST['action']=="add"){
      $res = $db->query('INSERT INTO parts (cost, quantity, name) VALUES ('.$_POST['cost'].','.$_POST['quantity'].',"'.$_POST['name'].'");');
    } else {
      $res = $db->query('UPDATE parts SET cost='.$_POST['cost'].', quantity='.$_POST['quantity'].', name="'.$_POST['name'].'" WHERE partid='.$_POST['partid'].';');
    }
    if ($res) {
      $return['error'] = false;
      $return['msg'] = ($_POST['action']=="add" ? "Part created successfully" : "Part updated successfully");
    } else {
      $return['error'] = true;
      $return['msg'] = ($_POST['action']=="add" ? "Error creating part" : "Error updating part");
    }
  } else {//vin or year not set
      if ($_POST['cost']==""){
        $return['error'] = true;
        $return['msg'] = "Please enter a cost";
      }
      if ($_POST['name']==""){
        $return['error'] = true;
        $return['msg'] = "Please enter a name";
      }
      if ($_POST['quantity']==""){
        $return['error'] = true;
        $return['msg'] = "Please enter a quantity";
      }
  }
  echo json_encode($return);
}
?>
