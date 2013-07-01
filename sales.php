<?php
include('util.php');
begin();
$db = connect_db();
make_head("Sales");
?>
  <script src="datepicker/js/bootstrap-datepicker.js"></script>
  <link href="datepicker/css/datepicker.css" rel="stylesheet" media="screen" />
<body>
  <div class="container"/>
    <?php include('navbar.html'); ?>
    <h1>Vehicle Sales</h1>
    <table id="table1" class="table table-striped table-bordered table-hover">
      <tr>
        <th>Vehicle</th>
        <th>Customer</th>
        <th>Employee</th>
        <th>Date Sold</th>
        <th>Sale Price</th>
<? if(is_manager()) { echo "<th>Edit</th>"; } ?>
      </tr>
    </table>
    <script>
      $(document).ready(function() {
        function loadData() {
          $.ajax({
            type:     'POST',
            url:      'genTable.php',
            dataType: 'json',
            data:     {
              table: 'vehiclesales'
            },
            success: function(data) {
              if (data.error == false) {
                for (var r = 0; r < data.contents.length; r++) {
                  $data = "";
                  for (var c = 0; c < data.contents[r].length; c++)
                    $data += '<td>' + data.contents[r][c] + '</td>';
                  $('#table1 tr:last').after('<tr>' + $data + '</tr>');
                }
                $extradata = data.extra;
                $('.edit').click(function(){
                  editset($(this));
                  $action = "update";
                  $editrow=$(this);
                });
              } else {
                $('#dataerror').text(data.msg);
                $('#dataerror').attr('style', '');
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              $('#dataerror').text("Error loading data. Please refresh.");
              $('#dataerror').attr('style', '');
            }
          });
        }
        loadData();
<?if(!is_manager()) {?>
      });
    </script>
    <script>
      $(document).ready(function() {
<?} else {?>
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
          <br/>Date sold:<br/>
          <input id="date" type="text" data-date-format="mm/dd/yyyy" value="<? echo date('m/d/Y');?>"/>
          <script>$('#date').datepicker();</script>
          <br />
          Sale price:<br/>
          <div class="input-prepend">
            <span class="add-on">$</span>
            <input class="span2" type="text" id="sale" placeholder="Sale price"/>
          </div>
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
    <div id="dataerror" class="alert alert-error" style="display: none;"></div>
    <table id="table2" class="table table-striped table-bordered table-hover">
      <tr>
        <th>Part</th>
        <th>Customer</th>
        <th>Employee</th>
        <th>Date Sold</th>
        <th>Sale Price</th>
        <th>Quantity</th>
<? if(is_manager()) { echo "<th>Edit</th>"; } ?>
      </tr>
    </table>
    <script>
      $(document).ready(function() {
        function loadData() {
          $.ajax({
            type:     'POST',
            url:      'genTable.php',
            dataType: 'json',
            data:     {
              table: 'partsales'
            },
            success: function(data) {
              if (data.error == false) {
                for (var r = 0; r < data.contents.length; r++) {
                  $data = "";
                  for (var c = 0; c < data.contents[r].length; c++)
                    $data += '<td>' + data.contents[r][c] + '</td>';
                  $('#table2 tr:last').after('<tr>' + $data + '</tr>');
                }
                $extradata = data.extra;
                $('.edit').click(function(){
                  editset($(this));
                  $action = "update";
                  $editrow=$(this);
                });
              } else {
                $('#dataerror').text(data.msg);
                $('#dataerror').attr('style', '');
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
              $('#dataerror').text("Error loading data. Please refresh.");
              $('#dataerror').attr('style', '');
            }
          });
        }
        loadData();
<?if(!is_manager()) {?>
      });
    </script>
    <script>
      $(document).ready(function() {
<?} else {?>
        $('#triggerAdd2').click(function() {
          $('#addModal2').modal({show:true});
          $action = "add";
        });

        function reset() {
          $('#form2')[0].reset();
        }

        $('.reset').click(function() {
          reset();
        });

        $('#submit2').click(function() {
          $.ajax({
            type:     'POST',
            url:      'addPartSale.php',
            dataType: 'json',
            data:     {
              submit: 'submit',
              action: $action,
              customer: $('#customer2').val(),
              employee: $('#employee2').val(),
              part: $('#part2').val(),
              date: $('#date2').val(),
              quantity: $('#quantity2').val(),
              price: $('#sale2').val()
            },
            success: function(data) {
              if (data.error == false) {
                $('#message2').text("Sale added successfully");
                $('#message2').attr('class', 'alert alert-success');
                $('#message2').attr('style', '');
                $('#form')[0].reset();
                } else {
                $('#message2').text(data.msg);
                $('#message2').attr('class', 'alert alert-error');
                $('#message2').attr('style', '');
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
              $('#message2').text("Error adding sale");
              $('#message2').attr('class', 'alert alert-error');
              $('#message2').attr('style', '');
            }
          });
        });
      });
    </script>
    <a id="triggerAdd2" class="btn btn-primary">Add new part sale</a>
    <div id="addModal2" class="modal hide fade" data-backdrop="static">
      <div class="modal-header">
        <h3>Add new part sale</h3>
      </div>
      <div class="modal-body">
        <div id="message2" style="display: none;"></div>
        <form method="post" id="form2">
          Customer:<br/>
          <select id="customer2">
<?
$res = $db->query('SELECT * FROM customers c, people p WHERE c.personid=p.personid');
while ($r = $res->fetch_assoc()) {
  echo '<option value="' . $r['customerid'] . '">' . $r['firstname'] . " " . $r['lastname'] . '</option>';
}
?>
          </select>
          <br/>Employee:<br/>
          <select id="employee2">
<?
$res = $db->query('SELECT * FROM employees e, people p WHERE e.personid=p.personid');
while ($r = $res->fetch_assoc()) {
  echo '<option value="' . $r['employeeid'] . '">' . $r['firstname'] . " " . $r['lastname'] . '</option>';
}
?>
          </select>
          <br/>Part #:<br/>
          <select id="part2">
<?
$res = $db->query('SELECT * FROM parts p');
while ($r = $res->fetch_assoc()) {
  echo '<option value="' . $r['partid'] . '">' . $r['name'] . '</option>';
}
?>
          </select>
          <br/>Date sold:<br/>
          <input id="date2" type="text" data-date-value="mm/dd/yyyy" value="<?echo date('m/d/Y')?>"/>
          <script>$('#date2').datepicker();</script>
          <br/>Quantity:<br/>
          <input type="text" id="quantity2" placeholder="Quantity sold:"/>
          <br/>Sale price (total):<br/>
          <div class="input-prepend">
            <span class="add-on">$</span>
            <input class="span2" type="text" id="sale2" placeholder="Sale price"/>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <a class="btn reset">Reset</a>
        <a class="btn reset" data-dismiss="modal">Close</a>
        <a id="submit2" class="btn btn-primary">Make sale</a>
      </div>
    </div>
    <? } ?>
  </div>
</html>
