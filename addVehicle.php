<?php
include('util.php');
begin();
$db = connect_db();
if (isset($_POST['submit'])) {
  if ($_POST['vin'] != "") {
    if ($_POST['year'] != "") {
        $res = mysqli_query($db,'INSERT INTO vehicles (vin, colorid, modelid, year, statusid, locationid) VALUES ("'.$_POST['vin'].'",'.$_POST['color'].','.$_POST['model'].','.$_POST['year'].','.$_POST['status'].','.$_POST['location'].');');
        $_POST['vin']="";
        $_POST['year']="";
      if ($res) {
        $return['error'] = false;
      } else {
        $return['error'] = true;
        $return['msg'] = "Error creating vehicle";
      }
    } else {
      $return['error'] = true;
      $return['msg'] = "Please enter a year";
    }
  } else {
    $return['error'] = true;
    $return['msg'] = "Please enter a VIN";
  }
  echo json_encode($return);
}
?>
