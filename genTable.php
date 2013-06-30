<?
include('util.php');
begin();
$db = connect_db();
if(isset($_POST['table'])){
  if($_POST['table']=="parts"){
    $res = $db->query("SELECT * FROM parts p");
    while ($r = $res->fetch_assoc()) {
      if(is_manager()) {
        $edit="<a href=\"#\" class=\"edit\"><i class=\"icon-edit\"></i></a>";
        $return['contents'][] = array($r['partid'], $r['cost'], $r['name'], $r['quantity'], $edit);
      }
      else{
        $return['contents'][] = array($r['partid'], $r['cost'], $r['name'], $r['quantity']);
      }
    }
    $return['error'] = false;
  }
  if($_POST['table']=="vehicles"){
    $res = $db->query("SELECT * FROM vehicles v, colors c, models m, makes ma, locations l, cities ci, statuses s WHERE v.colorid=c.colorid AND v.modelid=m.modelid AND m.makeid=ma.makeid AND v.locationid=l.locationid AND l.cityid=ci.cityid AND v.statusid=s.statusid");
    while ($r = $res->fetch_assoc()) {
      if(is_manager()) {
        $edit="<a href=\"#\" class=\"edit\"><i class=\"icon-edit\"></i></a>";
        $return['contents'][] = array($r['vin'], $r['year'], $r['color'], $r['make'], $r['model'], ucwords(strtolower($r["status"])), $r["name"], $edit);
        $return['extra'][] = array($r['vehicleid']);
      }
      else{
        $return['contents'][] = array($r['vin'], $r['year'], $r['color'], $r['make'], $r['model'], ucwords(strtolower($r["status"])), $r["name"]);
        $return['extra'][] = array($r['vehicleid']);
      }
    }
    $return['error'] = false;
  }
  echo json_encode($return);
}
?>
