<?php
include('util.php');
begin();
$db = connect_db();
make_head("Vehicle Sales");
?>
  <script src="datepicker/js/bootstrap-datepicker.js"></script>
  <link href="datepicker/css/datepicker.css" rel="stylesheet" media="screen" />
<body>
  <div class="container"/>
    <?php include('navbar.html'); ?>
    <h1>Vehicle Sales</h1>
    <div id="dataerror" class="alert alert-error" style="display: none;"></div>
    <table id="table" class="table table-striped table-bordered table-hover">
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
                  $('#table tr:last').after('<tr>' + $data + '</tr>');
                }
                $extradata = data.extra;
                $('.edit').click(function(){
                  $('#vehicle option[value=0]').remove();
                  $editrow=$(this);
                  editset($(this));
                  $action = "update";
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
          $('#vehicle option[value=0]').remove();
          $('#addModal').modal({show:true});
          $action = "add";
        });

        var editrow = null;
        $oldvehicle = 0;

        function editset($obj){
          $row = $obj.closest("tr")[0].cells;
          $('#customer option:contains(' + $row[1].innerHTML + ')').prop({selected: true})
          $('#employee option:contains(' + $row[2].innerHTML + ')').prop({selected: true})
          $('#date').val($row[3].innerHTML);
          $('#sale').val($row[4].innerHTML);
          $('#vehicle').prepend($('<option>', {value: 0}).text('No change'));
          $('#vehicle')[0].selectedIndex = 0;
          $('.modal-header h3').text('Update Sale');
          $('#submit').text("Update Sale");
          $('#addModal').modal({show:true}); 
          $oldvehicle = $extradata[$row[0].parentNode.rowIndex - 1][0];
          $saleid = $extradata[$row[0].parentNode.rowIndex - 1][1];
        }

        $('.reset').click(function() {
          $('#message').attr("style","display:none;");
          if ($action=="add"){
            $('#form')[0].reset();
          }
          else
            editset($editrow);
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
              oldvehicle: $oldvehicle,
              sale: $saleid,
              date: $('#date').val(),
              price: $('#sale').val()
            },
            success: function(data) {
              if (data.error == false) {
                $('#message').text("Sale added successfully");
                $('#message').attr('class', 'alert alert-success');
                $('#message').attr('style', '');
                $('#form')[0].reset();
                $('#form').attr('style', 'display:none;');
                $('div.modal-footer').attr('style', 'display:none;');
                setTimeout(function() {
                  $('#addModal').modal('toggle');
                  $('#table tr').not(function(){if ($(this).has('th').length){return true}}).remove();
                  loadData();
                  $('#form').attr('style', '');
                  $('div.modal-footer').attr('style', '');
                  $('#message').attr('style', 'display: none;');
                  $('#vehicle option[value=0]').remove();
                }, 2000);
                } else {
                $('#message').text(data.msg);
                $('#message').attr('class', 'alert alert-error');
                $('#message').attr('style', '');
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
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
          <input id="date" type="text" data-date-format="yyyy-mm-dd" value="<? echo date('Y-d-m');?>"/>
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
  </div>
</html>
