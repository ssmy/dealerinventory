<?php
include('util.php');
begin();
$db = connect_db();
if (isset($_POST['submit']) && ($_POST['action']=="add" || $_POST['action']=="update")) {
  if ($_POST['vin'] != "" && $_POST['year'] != "") {
    if ($_POST['make'] != 0 && $_POST['model'] != 0) {
      if($_POST['action']=="add"){
        $res = $db->query('INSERT INTO vehicles (vin, colorid, modelid, year, statusid, locationid) VALUES ("'.$_POST['vin'].'",'.$_POST['color'].','.$_POST['model'].','.$_POST['year'].','.$_POST['status'].','.$_POST['location'].');');
      } else {
        $res = $db->query('UPDATE vehicles SET vin="'.$_POST['vin'].'", colorid='.$_POST['color'].', modelid='.$_POST['model'].', year='.$_POST['year'].', statusid='.$_POST['status'].', locationid='.$_POST['location'].' WHERE vehicleid='.$_POST['vehicleid'].';');
      }
      if ($res) {
        $return['error'] = false;
        $return['msg'] = ($_POST['action']=="add" ? "Vehicle created successfully" : "Vehicle updated successfully");
      } else {
        $return['error'] = true;
        $return['msg'] = ($_POST['action']=="add" ? "Error creating vehicle" : "Error updating vehicle");
      }
    } else {//make or model not set
      if ($_POST['make']==0){
        $return['error'] = true;
        $return['msg'] = "Please enter a make";
      }
      if ($_POST['model']==0){
        $return['error'] = true;
        $return['msg'] = "Please enter a model";
      }
    }
  } else {//vin or year not set
      if ($_POST['vin']==""){
        $return['error'] = true;
        $return['msg'] = "Please enter a VIN";
      }
      if ($_POST['year']==""){
        $return['error'] = true;
        $return['msg'] = "Please enter a year";
      }
  }
  echo json_encode($return);
}
?>
