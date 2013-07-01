<?php
include('util.php');
begin();
if (!is_manager()) {
  header('Location: vehicles.php');
  die();
}
$db = connect_db();
if (isset($_POST['submit']) && ($_POST['action']=="add" || $_POST['action']=="update")) {
  if ($_POST['vin'] != "" && $_POST['year'] != "") {
    if ($_POST['make'] != 0 && $_POST['model'] != 0) {
      if (!(preg_match('/[a-zA-Z0-9]{17}/',$_POST['vin']))){
        $return['error'] = true;
        $return['msg'] = "VIN must be 17 digits";
        echo json_encode($return);
        die();
      }
      if (($_POST['year']>(date('Y')+1))||($_POST['year']<1850)){
        $return['error'] = true;
        $return['msg'] = "Year must be valid";
        echo json_encode($return);
        die();
      }
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
      if ($_POST['model']==0){
        $return['error'] = true;
        $return['msg'] = "Please enter a model";
      }
      if ($_POST['make']==0){
        $return['error'] = true;
        $return['msg'] = "Please enter a make";
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
