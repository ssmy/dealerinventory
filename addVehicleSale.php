<?php
include('util.php');
if (!is_manager()) {
  header('Location: sales.php');
  die();
}
begin();
$db = connect_db();
if (isset($_POST['submit']) && ($_POST['action']=="add" || $_POST['action']=="update")) {
  if ($_POST['date'] != "" && $_POST['price'] != "") {
    if ($_POST['customer'] != 0 && $_POST['employee'] != 0 && $_POST['vehicle']!=0) {
      if($_POST['action']=="add"){
        $res = $db->multi_query('INSERT INTO vehiclesales (customerid, employeeid, vehicleid, datesold, saleprice) VALUES ('.$_POST['customer'].','.$_POST['employee'].','.$_POST['vehicle'].',"'.$_POST['date'].'",'.$_POST['price'].'); UPDATE vehicles SET statusid=2 WHERE vehicleid='.$_POST['vehicle'].';');
      } else {
        $res = $db->multi_query('UPDATE vehicles SET statusid=1 WHERE vehicleid=(SELECT vehicleid FROM vehiclesales WHERE saleid='.$_POST['sale'].'); UPDATE vehiclesales SET customerid='.$_POST['customer'].', employeeid='.$_POST['employee'].', vehicleid='.$_POST['vehicle'].', datesold="'.$_POST['date'].'", saleprice='.$_POST['price'].' WHERE saleid='.$_POST['sale'].'; UPDATE vehicles SET statusid=2 WHERE vehicleid='.$_POST['vehicle'].';');
      }
      if ($res) {
        $return['error'] = false;
        $return['msg'] = ($_POST['action']=="add" ? "Sale added successfully" : "Sale updated successfully");
      } else {
        $return['error'] = true;
        $return['msg'] = ($_POST['action']=="add" ? "Error adding sale" : "Error updating sale");
      }
    } else {//customer, employee, or vehicle not set
      if ($_POST['customer']==0){
        $return['error'] = true;
        $return['msg'] = "Please enter a customer";
      }
      if ($_POST['employee']==0){
        $return['error'] = true;
        $return['msg'] = "Please enter a employee";
      }
      if ($_POST['vehicle']==0){
        $return['error'] = true;
        $return['msg'] = "Please enter a vehicle";
      }
    }
  } else {//date or price not set
      if ($_POST['date']==""){
        $return['error'] = true;
        $return['msg'] = "Please enter a date";
      }
      if ($_POST['price']==""){
        $return['error'] = true;
        $return['msg'] = "Please enter a price";
      }
  }
  echo json_encode($return);
}
?>
