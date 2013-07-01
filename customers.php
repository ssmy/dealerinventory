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
    <div id="dataerror" class="alert alert-error" style="display: none;"></div>
    <table id="table" class="table table-striped table-bordered table-hover">
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Address</th>
        <th>Location</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Edit</th>
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
              table: 'customers'
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

        $('#triggerAdd').click(function() {
          $('#addModal').modal({show:true});
          $action = "add";
        });
        
        var editrow = null;
        $customerid = 0;
        $personid = 0;

        function editset($obj){
          $row = $obj.closest("tr")[0].cells;
          $('#firstname').val($row[0].innerHTML);
          $('#lastname').val($row[1].innerHTML);
          $('#address').val($row[2].innerHTML);
          $('#city option:contains(' + $row[3].innerHTML + ')').prop({selected: true})
          $('#phone').val($row[4].innerHTML);
          $('#email').val($row[5].innerHTML);
          $('#contacttype option:contains(' + $row[6].innerHTML + ')').prop({selected: true})
          $('.modal-header h3').text('Update Customer');
          $('#submit').text("Update Customer");
          $('#addModal').modal({show:true}); 
          $customerid = $extradata[$row[0].parentNode.rowIndex - 1][0];
          $personid = $extradata[$row[0].parentNode.rowIndex - 1][1];
        }

        function reset() {
          $('.modal-header h3').text('Add new customer');
          $('#submit').text("Add Customer");
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
            url:      'addCustomer.php',
            dataType: 'json',
            data:     {
              submit: 'submit',
              action: $action,
              firstname: $('#firstname').val(),
              lastname: $('#lastname').val(),
              email: $('#email').val(),
              address: $('#address').val(),
              city: $('#city').val(),
              phone: $('#phone').val(),
              contacttype: $('#contacttype').val(),
              customerid: $customerid,
              personid: $personid
            },
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
                  $('#form').attr('style', '');
                  $('div.modal-footer').attr('style', '');
                  $('#message').attr('style', 'display: none;');
                  loadData();
                  reset();
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
              $('#message').text("Error modifying customer");
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
        <form method="post" id="form">
          <input type="hidden" name="submit">
          <input type="text" id="firstname" placeholder="First name"><br/>
          <input type="text" id="lastname" placeholder="Last name")><br/>
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
        <a class="btn closer" data-dismiss="modal">Close</a>
        <a id="submit" class="btn btn-primary">Add Customer</a>
      </div>
    </div>
  </div>
</body>
</html>
