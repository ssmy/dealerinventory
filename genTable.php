<?
include('util.php');
begin();
$db = connect_db();
if(isset($_POST['table'])){
  if($_POST['table']=="parts"){
    $res = $db->query("SELECT * FROM parts p");
    while ($r = $res->fetch_assoc()) {
      $return['contents'][] = array($r['partid'], $r['cost'], $r['name'], $r['quantity']);
    }
    $return['error'] = false;
  }
  echo json_encode($return);
}
?>
