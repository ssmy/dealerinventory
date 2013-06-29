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
    <table class="table table-striped table-bordered table-hover">
      <tr>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Address</td>
        <td>Location</td>
        <td>Phone</td>
        <td>Email</td>
<? // TODO: Add rank, status ?>
      </tr>
<?php
$res = $db->query("SELECT * FROM employees e, people p, cities ci WHERE p.personid=e.personid AND p.cityid=ci.cityid");
while ($r = $res->fetch_assoc()) {
  echo "<tr>";
  echo "<td>" . $r["firstname"] . "</td>";
  echo "<td>" . $r["lastname"] . "</td>";
  echo "<td>" . $r["address"] . "</td>";
  echo "<td>" . $r["city"] . ", " . $r['state'] . "</td>";
  echo "<td>" . $r["phone"] . "</td>";
  echo "<td>" . $r["email"] . "</td>";
  echo "</tr>\n";
  }
  ?>
    </table>
    <script>
      $(document).ready(function() {
        $('#triggerAdd').click(function() {
          $('#addModal').modal({show:true});
        });

        $('.reset').click(function() {
          $('#custform')[0].reset();
        });

        $('#submit').click(function() {
          $.ajax({
            type:     'POST',
            url:      'addEmployee.php',
            dataType: 'json',
            data:     {
              submit: 'submit',
              firstname: $('#firstname').val(),
              lastname: $('#lastname').val(),
              email: $('#email').val(),
              address: $('#address').val(),
              city: $('#city').val(),
              phone: $('#phone').val(),
              user: $('#user').val(),
              pass: $('#pass').val(),
              duppass: $('#duppass').val(),
              rank: $('#rank').val(),
            },
            success: function(data) {
              if (data.error == false) {
                $('#message').text("Employee added successfully");
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
        </form>
      </div> <!-- body -->
      <div class="modal-footer">
        <a class="btn reset">Reset</a>
        <a class="btn reset" data-dismiss="modal">Close</a>
        <a id="submit" class="btn btn-primary">Add employee</a>
      </div>
    </div>
  </div>
</body>
</html>

