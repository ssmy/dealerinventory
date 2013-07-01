<?php
include('util.php');
begin();
$db = connect_db();
make_head("Part Sales");
?>
  <script src="datepicker/js/bootstrap-datepicker.js"></script>
  <link href="datepicker/css/datepicker.css" rel="stylesheet" media="screen" />
<body>
  <div class="container"/>
    <?php include('navbar.html'); ?>
    <h1>Part Sales</h1>
    <div id="dataerror" class="alert alert-error" style="display: none;"></div>
    <table id="table" class="table table-striped table-bordered table-hover">
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
                  $('#table tr:last').after('<tr>' + $data + '</tr>');
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
        $('#triggerAdd').click(function() {
          $('#addModal').modal({show:true});
          $action = "add";
        });

        var editrow = null;
        $saleid = 0;

        function editset($obj){
          $row = $obj.closest("tr")[0].cells;
          $('#part option:contains(' + $row[0].innerHTML + ')').prop({selected: true})
          $('#customer option:contains(' + $row[1].innerHTML + ')').prop({selected: true})
          $('#employee option:contains(' + $row[2].innerHTML + ')').prop({selected: true})
          $('#datesold').val($row[3].innerHTML);
          $('#sale').val($row[4].innerHTML);
          $('#quantity').val($row[5].innerHTML);
          $('.modal-header h3').text('Update Sale');
          $('#submit').text("Update Sale");
          $('#addModal').modal({show:true}); 
          $saleid = $extradata[$row[0].parentNode.rowIndex - 1][0];
        }

        function reset() {
          $('.modal-header h3').text('Add new part sale');
          $('#submit').text("Make sale");
          $('#message').attr("style","display:none;");
        }

        $('.reset').click(function() {
          $('#message').attr("style","display:none;");
          if ($action=="add"){
            $('#form')[0].reset();
          }
          else
            editset($editrow);
        });

        $('.closer').click(function() {
          $('#form')[0].reset();
          reset();
        });

        $('#submit').click(function() {
          $.ajax({
            type:     'POST',
            url:      'addPartSale.php',
            dataType: 'json',
            data:     {
              submit: 'submit',
              action: $action,
              customer: $('#customer').val(),
              employee: $('#employee').val(),
              part: $('#part').val(),
              date: $('#date').val(),
              quantity: $('#quantity').val(),
              price: $('#sale').val(),
              sale: $saleid
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
                  reset();
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
    <a id="triggerAdd" class="btn btn-primary">Add new part sale</a>
    <div id="addModal" class="modal hide fade" data-backdrop="static">
      <div class="modal-header">
        <h3>Add new part sale</h3>
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
          <br/>Part #:<br/>
          <select id="part">
<?
$res = $db->query('SELECT * FROM parts p');
while ($r = $res->fetch_assoc()) {
  echo '<option value="' . $r['partid'] . '">' . $r['name'] . '</option>';
}
?>
          </select>
          <br/>Date sold:<br/>
          <input id="date" type="text" data-date-format="yyyy-mm-dd" value="<?echo date('Y-m-d')?>"/>
          <script>$('#date').datepicker();</script>
          <br/>Quantity:<br/>
          <input type="text" id="quantity" placeholder="Quantity sold:"/>
          <br/>Sale price (total):<br/>
          <div class="input-prepend">
            <span class="add-on">$</span>
            <input class="span2" type="text" id="sale" placeholder="Sale price"/>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <a class="btn reset">Reset</a>
        <a class="btn closer" data-dismiss="modal">Close</a>
        <a id="submit" class="btn btn-primary">Make sale</a>
      </div>
    </div>
    <? } ?>
  </div>
</html>
