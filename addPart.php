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
    if (!(is_numeric($_POST['quantity']))){
      $return['error'] = true;
      $return['msg'] = "Quantity must be an integer";
      echo json_encode($return);
      die();
    }
    if($_POST['quantity']<0){
      $return['error'] = true;
      $return['msg'] = "Quantity must be 0 or greater";
      echo json_encode($return);
      die();
    }
    if (!(is_numeric($_POST['cost']))){
      $return['error'] = true;
      $return['msg'] = "Cost must be numeric";
      echo json_encode($return);
      die();
    }
    if($_POST['cost']<(.01)){
      $return['error'] = true;
      $return['msg'] = "Cost must be $0.01 or greater";
      echo json_encode($return);
      die();
    }
    if($_POST['action']=="add"){
      $res = $db->query('insert into parts (cost, quantity, name) values ('.$_POST['cost'].','.$_POST['quantity'].',"'.$_POST['name'].'");');
    } else {
      $res = $db->query('update parts set cost='.$_POST['cost'].', quantity='.$_POST['quantity'].', name="'.$_POST['name'].'" where partid='.$_POST['partid'].';');
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
