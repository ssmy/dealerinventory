<?php
include('util.php');
begin();
if (!is_manager()) {
  header('Location: parts.php');
  die();
}
$db = connect_db();
if (isset($_POST['newsubmit'])) {
  if ($_POST['newpartname'] != "") {
    if ($_POST['newpartquantity'] != "") {
      if ($_POST['newpartcost'] == "") {
        $return['error'] = true;
        $return['msg'] = "Please enter a cost";
      } else {
        $res = mysqli_query($db,'INSERT INTO parts (cost, quantity, name) VALUES ('.$_POST['newpartcost'].','.$_POST['newpartquantity'].',"'.$_POST['newpartname'].'");');
        $_POST['newpartname']="";
        $_POST['newpartquantity']="";
        $_POST['newpartcost']="";
        if ($res) {
          $return['error'] = false;
        } else {
          $return['error'] = true;
          $return['msg'] = "Error creating part";
        }
      }//cost error
    } else {
      $return['error'] = true;
      $return['msg'] = "Please enter a quantity";
    }
  } else {
    $return['error'] = true;
    $return['msg'] = "Please enter a part name";
  }
  echo json_encode($return);
}
if (isset($_POST['addsubmit'])){
  if ($_POST['addpartquantity']==""){
    $return['error'] = true;
    $return['msg'] = "Please enter a quantity";
  } else{
    $res2 = $db->query('UPDATE parts SET quantity=quantity+"' . $_POST['addpartquantity'] . '" WHERE partid=' . $_POST['addpartpart']);
    if ($db->affected_rows) {
      $return['error'] = false;
    } else {
      $return['error'] = true;
      $return['msg'] = "Error updating part";
    }
  }
  echo json_encode($return);
}
 ?>
