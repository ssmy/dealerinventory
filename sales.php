<?php
include('util.php');
begin();
$db = connect_db();
make_head("Sales");
?>
<html>
  <div class="container"/>
    <?php include('navbar.html'); ?>
    <h1>Vehicle Sales</h1>
    <table class="table table-striped table-bordered table-hover">
      <tr>
        <th>Sale #</th>
        <th>Customer #</th>
        <th>Employee #</th>
        <th>Vehicle #</th>
        <th>Date Sold</th>
        <th>Sale Price</th>
      </tr>
<?php
$res = $db->query("SELECT * FROM vehiclesales p");
while ($r = $res->fetch_assoc()) {
  echo "<tr>";
  echo "<td>" . $r["saleid"] . "</td>";
  echo "<td>" . $r["customerid"] . "</td>";
  echo "<td>" . $r["employeeid"] . "</td>";
  echo "<td>" . $r["vehicleid"] . "</td>";
  echo "<td>" . $r["datesold"] . "</td>";
  echo "<td>" . $r["saleprice"] . "</td>";
  echo "</tr>";
  }
  ?>
    </table>
    <? if (is_manager()) { ?>
    <script>
      $(document).ready(function() {
        $('#triggerAdd').click(function() {
          $('#addModal').modal({show:true});
          $action = "add";
        });

        function reset() {
          $('#form')[0].reset();
        }

        $('.reset').click(function() {
          reset();
        });

        $('#submit').click(function() {
          $.ajax({
            type:     'POST',
            url:      'addVehicleSale.php',
            dataType: 'json',
            data:     {
              submit: 'submit',
              action: $action,
              customer: $('#customer').val(),
              employee: $('#employee').val(),
              vehicle: $('#vehicle').val(),
              date: $('#date').val(),
              price: $('#sale').val()
            },
            success: function(data) {
              if (data.error == false) {
                $('#message').text("Sale added successfully");
                $('#message').attr('class', 'alert alert-success');
                $('#message').attr('style', '');
                $('#custform')[0].reset();
                } else {
                $('#message').text(data.msg);
                $('#message').attr('class', 'alert alert-error');
                $('#message').attr('style', '');
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              $('#message').text("Error adding sale");
              $('#message').attr('class', 'alert alert-error');
              $('#message').attr('style', '');
            }
          });
        });
      });
    </script>
    <a id="triggerAdd" class="btn btn-primary">Add new vehicle sale</a>
    <div id="addModal" class="modal hide fade" data-backdrop="static">
      <div class="modal-header">
        <h3>Add new vehicle sale</h3>
      </div>
      <div class="modal-body">
        <div id="message" style="display: none;"></div>
        <form method="post" id="form">
          Customer:<br/>
          <select id="customer">
<?
$res = $db->query('SELECT * FROM customers c, people p WHERE c.personid=p.personid');
while ($r = $res->fetch_assoc()) {
  echo '<option value="' . $r['customerid'] . '">' . $r['firstname'] . " " . $r['lastname'] . '</option>';
}
?>
          </select>
          <br/>Employee:<br/>
          <select id="employee">
<?
$res = $db->query('SELECT * FROM employees e, people p WHERE e.personid=p.personid');
while ($r = $res->fetch_assoc()) {
  echo '<option value="' . $r['employeeid'] . '">' . $r['firstname'] . " " . $r['lastname'] . '</option>';
}
?>
          </select>
          <br/>Vehicle:<br/>
          <select id="vehicle">
<?
$res = $db->query('SELECT * FROM vehicles v, makes m, models mo WHERE v.statusid=1 AND v.modelid=mo.modelid AND mo.makeid=m.makeid');
while ($r = $res->fetch_assoc()) {
  echo '<option value="' . $r['vehicleid'] . '">' . $r['year'] . " " . $r['make'] . " " . $r['model'] . " (" . $r['vin'] . ')</option>';
}
?>
          </select>
          <br/>Date sold: (MM/DD/YYYY)<br/>
          <input id="date" type="date"/>
          <br/>Sale price:<br/>
          <input type="text" id="sale" placeholder="Sale price"/>
        </form>
      </div>
      <div class="modal-footer">
        <a class="btn reset">Reset</a>
        <a class="btn reset" data-dismiss="modal">Close</a>
        <a id="submit" class="btn btn-primary">Make sale</a>
      </div>
    </div>
    <? } ?>
    <h1>Part Sales</h1>
    <table class="table table-striped table-bordered table-hover">
      <tr>
        <th>Sale #</th>
        <th>Customer #</th>
        <th>Employee #</th>
        <th>Part #</th>
        <th>Date Sold</th>
        <th>Sale Price</th>
        <th>Quantity</th>
      </tr>
<?php
$res = $db->query("SELECT * FROM partsales p");
while ($r = $res->fetch_assoc()) {
  echo "<td>" . $r["saleid"] . "</td>";
  echo "<td>" . $r["customerid"] . "</td>";
  echo "<td>" . $r["employeeid"] . "</td>";
  echo "<td>" . $r["partid"] . "</td>";
  echo "<td>" . $r["datesold"] . "</td>";
  echo "<td>" . $r["saleprice"] . "</td>";
  echo "<td>" . $r["quantity"] . "</td>";
  }
  ?>
    </table>
  </div>
</html>
