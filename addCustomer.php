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
        $res = mysqli_query($db,'INSERT INTO people (firstname, lastname, email, address, cityid, phone) VALUES ("'.$_POST['firstname'].'","'.$_POST['lastname'].'","'.$_POST['email'].'","'.$_POST['address'].'",'.$_POST['city'].','.$_POST['phone'].');');
        if ($res) {
          $personid=mysqli_insert_id($db);
          $res2 = mysqli_query($db,'INSERT INTO customers (personid, contacttype) VALUES ('.$personid.','.$_POST['contacttype'].');');
          $_POST['firstname']="";
          $_POST['lastname']="";
          $_POST['email']="";
          $_POST['address']="";
          $_POST['phone']="";
          if ($res2) {
            $return['error'] = false;
          } else {
            $return['error'] = true;
            $return['msg'] = "Error creating customer";
          }  
        } else {
          $return['error'] = true;
          $return['msg'] = "Error creating customer";
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
