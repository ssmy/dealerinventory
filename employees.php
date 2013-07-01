<?php
include('util.php');
begin();
if (!is_manager()) {
  header('Location: menu.php');
  die();
}
$db = connect_db();
make_head("Employees");
?>
  <body>
    <div class="container">
<?php include('navbar.html'); ?>
      <h1>Employees</h1>
    <div id="dataerror" class="alert alert-error" style="display: none;"></div>
    <table id="table" class="table table-striped table-bordered table-hover">
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Address</th>
        <th>Location</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Rank</th>
        <th>Status</th>
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
              table: 'employees'
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
          $('#addModal').modal({show:true});
          $action = "add";
        });

        var editrow = null;

        function editset($obj){
          $row = $obj.closest("tr")[0].cells;
          $('#firstname').val($row[0].innerHTML);
          $('#lastname').val($row[1].innerHTML);
          $('#address').val($row[2].innerHTML);
          $('#city option:contains(' + $row[3].innerHTML + ')').prop({selected: true})
          $('#phone').val($row[4].innerHTML);
          $('#email').val($row[5].innerHTML);
          $('#rank option:contains(' + $row[6].innerHTML + ')').prop({selected: true})
          $('#status option:contains(' + $row[7].innerHTML + ')').prop({selected: true})
          $('.modal-header h3').text('Update Employee');
          $('#submit').text("Update Employee");
          $('#addModal').modal({show:true}); 
          $employeeid = $extradata[$row[0].parentNode.rowIndex - 1][0];
          $personid = $extradata[$row[0].parentNode.rowIndex - 1][1];
          $username = $extradata[$row[0].parentNode.rowIndex - 1][2];
          $password = $extradata[$row[0].parentNode.rowIndex - 1][3];
          $('#user').val($username);
          $('#pass').val($password);
          $('#duppass').val($password);
        }

        $('.reset').click(function() {
          if ($action=="add"){
            $('#form')[0].reset();
            $('#message').attr("style","display:none;");
          }
          else
            editset($editrow);
        });

        $('#submit').click(function() {
          $.ajax({
            type:     'POST',
            url:      'addEmployee.php',
            dataType: 'json',
            data:     {
              submit: 'submit',
              action: $action,
              personid: $personid,
              employeeid: $employeeid,
              firstname: $('#firstname').val(),
              lastname: $('#lastname').val(),
              email: $('#email').val(),
              address: $('#address').val(),
              city: $('#city').val(),
              phone: $('#phone').val(),
              status: $('#status').val(),
              user: $('#user').val(),
              pass: $('#pass').val(),
              duppass: $('#duppass').val(),
              oldpass: $password,
              rank: $('#rank').val(),
            },
            success: function(data) {
              if (data.error == false) {
                $('#message').text("Employee added successfully");
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
                }, 2000);
                $('#form')[0].reset();
                } else {
                $('#message').text(data.msg);
                $('#message').attr('class', 'alert alert-error');
                $('#message').attr('style', '');
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
              $('#message').text("Error adding employee");
              $('#message').attr('class', 'alert alert-error');
              $('#message').attr('style', '');
            }
          });
        });
      });
    </script>
    <a id="triggerAdd" class="btn btn-primary">Add new employee</a>
    <div id="addModal" class="modal hide fade" data-backdrop="static">
      <div class="modal-header">
        <h3>Add new employee</h3>
      </div>
      <div class="modal-body">
        <div id="message" style="display: none;"></div>
        <form method="post" id="form">
          <input type="text" id="firstname" placeholder="First name"><br/>
          <input type="text" id="lastname" placeholder="Last name"><br/>
          <input type="text" id="email" placeholder="Email"><br/>
          <input type="text" id="address" placeholder="Address"><br/>
          City:<br />
          <select id="city">
            <?
            $res3 = $db->query("SELECT * FROM cities c");
            while ($r = $res3->fetch_assoc()) {
            echo "<option value=".$r['cityid'].">" . $r["city"] . ", " . $r['state']  . "</option>\n";
            }
            ?>
          </select><br />
          <input type="text" id="phone" placeholder="Phone"><br/>
          <input type="text" id="user" placeholder="Username"><br/>
          <input type="password" id="pass" placeholder="Password"><br/>
          <input type="password" id="duppass" placeholder="Confirm password"><br/>
          Rank:<br />
          <select id="rank">
            <?
            $res4 = $db->query("SELECT * FROM ranks r");
            while ($r = $res4->fetch_assoc()) {
            echo "<option value=".$r['rankid'].">" . ucwords(strtolower($r["rank"])) . "</option>\n";
            }
            ?>
          </select>
          <br/>
          Status:<br />
          <select id="status">
            <?
            $res4 = $db->query("SELECT * FROM employeestatuses e");
            while ($r = $res4->fetch_assoc()) {
            echo "<option value=".$r['statusid'].">" . ucwords(strtolower($r["status"])) . "</option>\n";
            }
            ?>
          </select>
        </form>
      </div> <!-- body -->
      <div class="modal-footer">
        <a class="btn reset">Reset</a>
        <a class="btn reset" data-dismiss="modal">Close</a>
        <a id="submit" class="btn btn-primary">Add employee</a>
      </div>
    </div>
    <?}?>
  </div>
</body>
</html>

