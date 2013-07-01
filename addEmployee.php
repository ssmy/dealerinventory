<?php
include('util.php');
begin();
if (!is_manager()) {
  header('Location: menu.php');
  die();
}
$basestatus = 1;
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
      if ($_POST['user'] == "") {
        $return['error'] = true;
        $return['msg'] = "Please enter a username";
      } else {
      if ($_POST['pass'] == "" || $_POST['duppass'] == "") {
        $return['error'] = true;
        $return['msg'] = "Please enter and confirm password";
      } else {
      if ($_POST['pass'] !=  $_POST['duppass']) {
        $return['error'] = true;
        $return['msg'] = "Passwords do not match";
      } else {
        if($_POST['action']=="add"){
          $res = $db->query('INSERT INTO people (firstname, lastname, email, address, cityid, phone) VALUES ("'.$_POST['firstname'].'","'.$_POST['lastname'].'","'.$_POST['email'].'","'.$_POST['address'].'",'.$_POST['city'].','.$_POST['phone'].');');
        } else {
          $res = $db->query('UPDATE people SET firstname="'.$_POST['firstname'].'", lastname="'.$_POST['lastname'].'", email="'.$_POST['email'].'", address="'.$_POST['address'].'", cityid='.$_POST['city'].', phone="'.$_POST['phone'].'" WHERE personid='.$_POST['personid'].';');
        }
        if ($res) {
          $personid=$db->insert_id;
          if($_POST['action']=="add"){
            $res2 = $db->query('INSERT INTO employees (personid, username, password, rankid, statusid) VALUES ('.$personid.',"'.$_POST['user'].'","'.sha1($_POST['pass']).'",'.$_POST['rank'].','.$basestatus.');');
          } else {
            if ($_POST['oldpass'] != $_POST['pass'])
              $password = sha1($_POST['pass']);
            else
              $password = $_POST['oldpass'];
            $res2 = $db->query('UPDATE employees SET username="' . $_POST['user'] . '", rankid=' . $_POST['rank'] . ', statusid=' . $_POST['status'] . ', password="' . $password . '" WHERE employeeid=' . $_POST['employeeid'] . ';');
          }
          if ($res2) {
            $return['error'] = false;
          } else {
            $return['error'] = true;
            $return['msg'] = "Error creating employee";
            $return['msg'] = $db->error;
          }  
        } else {
          $return['error'] = true;
          $return['msg'] = "Error creating employee";
        }
      }//match error
      }//password error
      }//username error
      }//phone error
      }//address error
    } else {
      $return['error'] = true;
      $return['msg'] = "Please enter an email";
    }
  } else {
    $return['error'] = true;
    $return['msg'] = "Please enter both a first and last name";
  }
  echo json_encode($return);
}
?>
