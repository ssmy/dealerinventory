<?
include('util.php');
begin();
if(isset($_POST['table'])){
  if($_POST['table']=="parts"){
    $res = $db->query("SELECT * FROM parts p");
    while ($r = $res->fetch_assoc()) {
      $return['contents'].push([$r['partid'], $r['cost'], $r['name'], $r['quantity']]);
    }
  }
  echo json_encode($return);
}
?>
