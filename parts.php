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
    <table class="table table-striped table-bordered table-hover">
      <tr>
        <th>Part #</th>
        <th>Cost</th>
        <th>Name</th>
        <th>Quantity</th>
<? if(is_manager()) { echo "<th>Edit</th>"; } ?>
      </tr>
<?php
$res = $db->query("SELECT * FROM parts p");
while ($r = $res->fetch_assoc()) {
  echo "<tr>";
  echo "<td>" . $r["partid"] . "</td>";
  echo "<td>" . $r["cost"] . "</td>";
  echo "<td>" . $r["name"] . "</td>";
  echo "<td>" . $r["quantity"] . "</td>";
  if(is_manager()) {
    echo "<td><a href=\"#\" class=\"delete\" data-id=\"" . $r["partid"] . "\"><i class=\"icon-trash\"></i></a> | ";
    echo "<a href=\"#\" class=\"edit\"><i class=\"icon-edit\"></i></a></td>";
  }
  echo "</tr>";
  }
  ?>
    </table>
<?if(is_manager()){?>
    <script>
      $(document).ready(function() {
        $('#triggerAdd').click(function() {
          $('#addModal').modal({show:true});
        });

        $('.delete').click(function() {
          alert($(this).data.id);
        });

        function reset() {
          $('#form1')[0].reset();
          $('#form2')[0].reset();
        }

        $('.reset').click(function() {
          reset();
        });

        $('#submit').click(function() {
          if ($('ul.nav-tabs li.active').text() == "New Part") {
            $values = {
              newsubmit: "newsubmit",
              newpartquantity: $('#newpartquantity').val(),
              newpartcost: $('#newpartcost').val(),
              newpartname: $('#newpartname').val()
            }
          } else {
            $values = {
              addsubmit: "addsubmit",
              addpartquantity: $('#addpartquantity').val(),
              addpartpart: $('#addpartpart').val()
            }
          }   
          $.ajax({
            type:     'POST',
            url:      'addPart.php',
            dataType: 'json',
            data:     $values,
            success: function(data) {
              if (data.error == false) {
                $('#message').text("Parts added successfully");
                $('#message').attr('class', 'alert alert-success');
                $('#message').attr('style', '');
                reset();
                } else {
                $('#message').text(data.msg);
                $('#message').attr('class', 'alert alert-error');
                $('#message').attr('style', '');
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
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
        <div class="tabbable">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#newpart" data-toggle="tab">New Part</a></li>
            <li><a href="#addpart" data-toggle="tab">Additional Parts</a></li>
          </ul>
          <div class="tab-content">
            <div id="newpart" class="tab-pane active">
              <form method="post" id="form1">
                <input type="text" id="newpartname" placeholder="Part name"><br/>
                <input type="text" id="newpartquantity" placeholder="Part quantity"><br/>
                <input type="text" id="newpartcost" placeholder="Part cost"><br/>
              </form>
            </div>
            <div id="addpart" class="tab-pane">
              <form method="post" id="form2">
                Part:<br />
                <select id="addpartpart">
                  <?
                  $res3 = $db->query("SELECT * FROM parts p");
                  while ($r = $res3->fetch_assoc()) {
                  echo "<option value=".$r['partid'].">" . $r["name"] . "</option>\n";
                  }
                  ?>
                </select><br />
                <input type="text" id="addpartquantity" placeholder="Quantity to add"><br/>
              </form>
            </div>
          </div><!--tab content-->
        </div><!--tabbable-->
      </div>
      <div class="modal-footer">
        <a class="btn reset">Reset</a>
        <a class="btn reset" data-dismiss="modal">Close</a>
        <a id="submit" class="btn btn-primary">Add Part</a>
      </div>
        <?}?>
      </div>
    </html>
