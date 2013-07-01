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
  if($_POST['table']=="customers"){
    $res = $db->query("SELECT * FROM customers c, people p, cities ci, contacttypes co WHERE p.personid=c.personid AND p.cityid=ci.cityid AND c.contacttype=co.contactid");
    while ($r = $res->fetch_assoc()) {
      $edit="<a href=\"#\" class=\"edit\"><i class=\"icon-edit\"></i></a>";
      $return['contents'][] = array($r['firstname'], $r['lastname'], $r['address'], $r['city'] . ", " . $r['state'], $r['phone'], $r["email"], $r['contact'], $edit);
      $return['extra'][] = array($r['customerid'], $r['personid']);
    }
    $return['error'] = false;
  }
  if($_POST['table']=="employees"){
    if (is_manager()) {
      $res = $db->query("SELECT * FROM employees e, people p, cities ci, ranks r, employeestatuses s WHERE p.personid=e.personid AND p.cityid=ci.cityid AND e.rankid=r.rankid AND e.statusid=s.statusid");
      while ($r = $res->fetch_assoc()) {
        $edit="<a href=\"#\" class=\"edit\"><i class=\"icon-edit\"></i></a>";
        $return['contents'][] = array($r['firstname'], $r['lastname'], $r['address'], $r['city'] . ", " . $r['state'], $r['phone'], $r["email"], ucwords(strtolower($r['rank'])), ucwords(strtolower($r['status'])), $edit);
        $return['extra'][] = array($r['employeeid'], $r['personid'], $r['username'], $r['password']);
      }
      $return['error'] = false;
    }
  }
  if($_POST['table']=="partsales"){//format: part name, customer, employee, date, price, quantity
    $res = $db->query("SELECT * FROM partsales ps, customers c, employees e, people p, people p2, parts pt WHERE ps.customerid=c.customerid AND ps.employeeid=e.employeeid AND ps.partid=pt.partid AND c.personid=p.personid AND e.personid=p2.personid");
    while ($r = $res->fetch_array()) {
      if(is_manager()) {
        $edit="<a href=\"#\" class=\"edit\"><i class=\"icon-edit\"></i></a>";
        $return['contents'][] = array($r['name'], $r[17].' '.$r[18], $r[24].' '.$r[25], $r['datesold'], money_format("%i",$r['saleprice']), $r['quantity'], $edit);
      }
      else{
        $return['contents'][] = array($r['name'], $r[17].' '.$r[18], $r[24].' '.$r[25], $r['datesold'], money_format("%i",$r['saleprice']), $r['quantity']);
      }
    }
    $return['error'] = false;
  }

  echo json_encode($return);
}
?>
