<?php
include('util.php');
begin();
$db = connect_db();
make_head("Parts");
?>
<html>
  <div class="container"/>
    <?php include('navbar.html'); ?>
    <h1>Parts</h1>
    <div id="dataerror" class="alert alert-error" style="display: none;"></div>
    <table id="table" class="table table-striped table-bordered table-hover">
      <tr>
        <th>Name</th>
        <th>Cost</th>
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
              table: 'parts'
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
          $('#form')[0].reset();
          $('#addModal').modal({show:true});
          $action = "add";
        });

        var editrow = null;
        var $partid = 0;//To fix errors on adding

        function editset($obj){
          $row = $obj.closest("tr")[0].cells;
          $('#name').val($row[0].innerHTML);
          $('#cost').val($row[1].innerHTML);
          $('#quantity').val($row[2].innerHTML);
          $('.modal-header h3').text('Update Part');
          $('#submit').text("Update Part");
          $('#addModal').modal({show:true}); 
          $partid = $extradata[$row[0].parentNode.rowIndex - 1][0];
        }

        function reset() {
          $('.modal-header h3').text('Add new part');
          $('#submit').text("Add Part");
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
          $values = {
            submit: "submit",
            quantity: $('#quantity').val(),
            cost: $('#cost').val(),
            name: $('#name').val(),
            partid: $partid,
            action: $action
          }
          $.ajax({
            type:     'POST',
            url:      'addPart.php',
            dataType: 'json',
            data:     $values,
            success: function(data) {
              if (data.error == false) {
                $('#message').text(data.msg);
                $('#message').attr('class', 'alert alert-success');
                $('#message').attr('style', '');
                $('#form').attr('style', 'display:none;');
                $('div.modal-footer').attr('style', 'display:none;');
                setTimeout(function() {
                  $('#addModal').modal('toggle');
                  $('#table tr').not(function(){if ($(this).has('th').length){return true}}).remove();
                  loadData();
                  $('#form').attr('style', '');
                  $('div.modal-footer').attr('style', '');
                  $('#message').attr('style', 'display: none;');
                }, 2000);
                } else {
                $('#message').text(data.msg);
                $('#message').attr('class', 'alert alert-error');
                $('#message').attr('style', '');
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
              $('#message').text("Error adding parts");
              $('#message').attr('class', 'alert alert-error');
              $('#message').attr('style', '');
            }
          });
        });
      });
    </script>
    <a id="triggerAdd" class="btn btn-primary">Add new part</a>
    <div id="addModal" class="modal hide fade" data-backdrop="static">
      <div class="modal-header">
        <h3>Add new part</h3>
      </div>
      <div class="modal-body">
        <div id="message" style="display: none;"></div>
        <form method="post" id="form">
          <input type="text" id="name" placeholder="Part name"><br/>
          <input type="text" id="quantity" placeholder="Part quantity"><br/>
          <div class="input-prepend">
            <span class="add-on">$</span>
            <input class="span2" type="text" id="cost" placeholder="Part cost">
          </div><br/>
        </form>
      </div>
      <div class="modal-footer">
        <a class="btn reset">Reset</a>
        <a class="btn closer" data-dismiss="modal">Close</a>
        <a id="submit" class="btn btn-primary">Add Part</a>
      </div>
        <?}?>
      </div>
    </html>
