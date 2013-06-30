<?php
include('util.php');
begin();
$db = connect_db();
if (isset($_POST['submit'])) {
  if ($_POST['firstname'] != "" && $_POST['lastname'] != "") {
    if ($_POST['email'] != "") {
      if ($_POST['address'] == "") {
        $return['error'] = true;
        $return['msg'] = "Please enter an address";
      } else {
      if ($_POST['phone'] == "") {
        $return['error'] = true;
        $return['msg'] = "Please enter a phone number";
      } else {
        if($_POST['action']=="add"){
          $res = $db->query('INSERT INTO people (firstname, lastname, email, address, cityid, phone) VALUES ("'.$_POST['firstname'].'","'.$_POST['lastname'].'","'.$_POST['email'].'","'.$_POST['address'].'",'.$_POST['city'].','.$_POST['phone'].');');
        } else {
          $res = $db->query('UPDATE people SET firstname="'.$_POST['firstname'].'", lastname="'.$_POST['lastname'].'", email="'.$_POST['email'].'", address="'.$_POST['address'].'", cityid='.$_POST['city'].', phone="'.$_POST['phone'].'" WHERE personid='.$_POST['personid'].';');
        }
        if ($res) {
          if($_POST['action']=="add"){
            $personid=mysqli_insert_id($db);
            $res2 = mysqli_query($db,'INSERT INTO customers (personid, contacttype) VALUES ('.$personid.','.$_POST['contacttype'].');');
          } else {
            $res2 = $db->query('UPDATE customers SET contacttype=' . $_POST['contacttype'] . ' WHERE customerid=' . $_POST['customerid'] . ';');
          }
          if ($res2) {
            $return['error'] = false;
          } else {
            $return['error'] = true;
            $return['msg'] = $_POST['action'] == "add" ? "Error creating customer" : "Error updating customer";
          }  
        } else {
          $return['error'] = true;
          $return['msg'] = $_POST['action'] == "add" ? "Error creating customer" : "Error updating customer";
        }
      }//phone error
      }//address error
    } else {
      $return['error'] = true;
      $return['msg'] = "Please enter an email";
    }
  } else {
    $return['error'] = true;
    $return['msg'] = "Please enter a first and last name";
  }
}
echo json_encode($return);
?>
