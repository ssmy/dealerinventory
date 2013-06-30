<?php
include('util.php');
begin();
$db = connect_db();
if (isset($_POST['submit']) && ($_POST['action']=="add" || $_POST['action']=="update")) {
  if ($_POST['date'] != "" && $_POST['price'] != "" && $_POST['quantity'] != "") {
    if ($_POST['customer'] != 0 && $_POST['employee'] != 0 && $_POST['part']!=0) {
      if($_POST['action']=="add"){
        $partres = $db->query('SELECT quantity FROM parts WHERE partid='.$_POST['part'].';');
        $partquan = $partres->fetch_row();
        if ($_POST['quantity']>$partquan[0]){
          $return['error'] = true;
          $return['msg'] = "Trying to sell more parts than are in stock";
          echo json_encode($return);
          die();
        } else {
          $res = $db->multi_query('INSERT INTO partsales (customerid, employeeid, partid, datesold, saleprice, quantity) VALUES ('.$_POST['customer'].','.$_POST['employee'].','.$_POST['part'].',"'.$_POST['date'].'",'.$_POST['price'].','.$_POST['quantity'].'); UPDATE parts SET quantity=quantity-'.$_POST['quantity'].' WHERE partid='.$_POST['part'].';');
        }
      } else {
        $partres = $db->query('SELECT parts.quantity+partsales.quantity FROM parts, partsales WHERE parts.partid='.$_POST['part'].' AND partsales.saleid='.$_POST['sale'].';');
        $partquan = $partres->fetch_row();
        if ($_POST['quantity']>$partquan[0]){
          $return['error'] = true;
          $return['msg'] = "Trying to sell more parts than are in stock";
          echo json_encode($return);
          die();
        } else {
          $res = $db->multi_query('UPDATE parts SET quantity=quantity+(SELECT quantity FROM partsales WHERE saleid='.$_POST['sale'].') WHERE partid=(SELECT partid FROM partsales WHERE saleid='.$_POST['sale'].'); UPDATE partsales SET customerid='.$_POST['customer'].', employeeid='.$_POST['employee'].', vehicleid='.$_POST['vehicle'].', datesold="'.$_POST['date'].'", saleprice='.$_POST['price'].', quantity='.$_POST['quantity'].' WHERE saleid='.$_POST['sale'].'; UPDATE parts SET quantity=quantity-'.$_POST['quantity'].' WHERE partid='.$_POST['part'].';');
        }
      }
      if ($res) {
        $return['error'] = false;
        $return['msg'] = ($_POST['action']=="add" ? "Sale added successfully" : "Sale updated successfully");
      } else {
        $return['error'] = true;
        $return['msg'] = ($_POST['action']=="add" ? "Error adding sale" : "Error updating sale");
      }
    } else {//customer, employee, or part not set
      if ($_POST['customer']==0){
        $return['error'] = true;
        $return['msg'] = "Please enter a customer";
      }
      if ($_POST['employee']==0){
        $return['error'] = true;
        $return['msg'] = "Please enter a employee";
      }
      if ($_POST['part']==0){
        $return['error'] = true;
        $return['msg'] = "Please enter a part";
      }
    }
  } else {//date, price, or quantity not set
      if ($_POST['date']==""){
        $return['error'] = true;
        $return['msg'] = "Please enter a date";
      }
      if ($_POST['price']==""){
        $return['error'] = true;
        $return['msg'] = "Please enter a price";
      }
      if ($_POST['quantity']==""){
        $return['error'] = true;
        $return['msg'] = "Please enter a quantity";
      }
  }
  echo json_encode($return);
}
?>
