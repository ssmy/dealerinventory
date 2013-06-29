<?php
include('util.php');
begin();
$db = connect_db();
make_head("Customers");
?>
<body>
  <div class="container"/>
    <?php include('navbar.html'); ?>
    <h1>Customers</h1>
    <table class="table table-striped table-bordered table-hover">
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Address</th>
        <th>Location</th>
        <th>Phone</th>
        <th>Email</th>
      </tr>
<?php
$res = $db->query("SELECT * FROM customers c, people p, cities ci WHERE p.personid=c.personid AND p.cityid=ci.cityid");
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
            url:      'addCustomer.php',
            dataType: 'json',
            data:     {
              submit: 'submit',
              firstname: $('#firstname').val(),
              lastname: $('#lastname').val(),
              email: $('#email').val(),
              address: $('#address').val(),
              city: $('#city').val(),
              phone: $('#phone').val(),
              contacttype: $('#contacttype').val()
            },
            success: function(data) {
              if (data.error == false) {
                $('#message').text("Customer added successfully");
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
              $('#message').text("Error adding customer");
              $('#message').attr('class', 'alert alert-error');
              $('#message').attr('style', '');
            }
          });
        });
      });
    </script>
    <a id="triggerAdd" class="btn btn-primary">Add new customer</a>
    <div id="addModal" class="modal hide fade" data-backdrop="static">
      <div class="modal-header">
        <h3>Add new customer</h3>
      </div>
      <div class="modal-body">
        <div id="message" style="display: none;"></div>
        <form method="post" id="custform">
          <input type="hidden" name="submit">
          <input type="text" id="firstname" <? echo ((isset($_POST['firstname']) && $_POST['firstname'] != "") ? "value=".$_POST['firstname'] : "placeholder=\"First name\""); ?>><br/>
          <input type="text" id="lastname" <? echo ((isset($_POST['lastname']) && $_POST['lastname'] != "") ? "value=".$_POST['lastname'] : "placeholder=\"Last name\""); ?>><br/>
          <input type="text" id="email" <? echo ((isset($_POST['email']) && $_POST['email'] != "") ? "value=".$_POST['email'] : "placeholder=\"Email\""); ?>><br/>
          <input type="text" id="address" <? echo ((isset($_POST['address']) && $_POST['address'] != "") ? "value=".$_POST['address'] : "placeholder=\"Address\""); ?>><br/>
          City:<br />
          <select id="city">
            <?
            $res3 = $db->query("SELECT * FROM cities c");
            while ($r = $res3->fetch_assoc()) {
            echo "<option value=".$r['cityid'].">" . $r["city"] . ", " . $r['state']  . "</option>\n";
            }
            ?>
          </select><br />
          <input type="text" id="phone" <? echo ((isset($_POST['phone']) && $_POST['phone'] != "") ? "value=".$_POST['phone'] : "placeholder=\"Phone\""); ?>><br/>
          Contact Type:<br />
          <select id="contacttype">
            <?
            $res4 = $db->query("SELECT * FROM contacttypes c");
            while ($r = $res4->fetch_assoc()) {
            echo "<option value=".$r['contactid'].">" . $r["contact"] . "</option>\n";
            }
            ?>
          </select><br />
        </form>
      </div> <!-- body -->
      <div class="modal-footer">
        <a class="btn reset">Reset</a>
        <a class="btn reset" data-dismiss="modal">Close</a>
        <a id="submit" class="btn btn-primary">Add Customer</a>
      </div>
    </div>
  </div>
</body>
</html>
