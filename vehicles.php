<?php
include('util.php');
begin();
$db = connect_db();
make_head("Vehicles");
?>
<body>
  <div class="container"/>
    <?php include('navbar.html'); ?>
    <h1>Vehicles</h1>
    <table class="table table-striped table-bordered table-hover">
      <tr>
        <th>VIN</th>
        <th>Year</th>
        <th>Color</th>
        <th>Make</th>
        <th>Model</th>
        <th>Location</th>
<? // TODO: Add status ?>
      </tr>
<?php
$res = $db->query("SELECT * FROM vehicles v, colors c, models m, makes ma, locations l, cities ci WHERE v.colorid=c.colorid AND v.modelid=m.modelid AND m.makeid=ma.makeid AND v.locationid=l.locationid AND l.cityid=ci.cityid");
while ($r = $res->fetch_assoc()) {
  echo "<tr>";
  echo "<td>" . $r["vin"] . "</td>";
  echo "<td>" . $r["year"] . "</td>";
  echo "<td>" . $r["color"] . "</td>";
  echo "<td>" . $r["make"] . "</td>";
  echo "<td>" . $r["model"] . "</td>";
  echo "<td>" . $r["city"] . ", " . $r['state'] . "</td>";
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

        $('.reset').click(function() {
          $('#form')[0].reset();
        });

        $('#submit').click(function() {
          $.ajax({
            type:     'POST',
            url:      'addVehicle.php',
            dataType: 'json',
            data:     {
              submit: 'submit',
              vin: $('#vin').val(),
              color: $('#color').val(),
              make: $('#make').val(),
              model: $('#model').val(),
              year: $('#year').val(),
              status: $('#status').val(),
              location: $('#location').val(),
            },
            success: function(data) {
              if (data.error == false) {
                $('#message').text("Vehicle added successfully");
                $('#message').attr('class', 'alert alert-success');
                $('#message').attr('style', '');
                $('#form')[0].reset();
                } else {
                $('#message').text(data.msg);
                $('#message').attr('class', 'alert alert-error');
                $('#message').attr('style', '');
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
              $('#message').text("Error adding vehicle");
              $('#message').attr('class', 'alert alert-error');
              $('#message').attr('style', '');
            }
          });
        });
      });
    </script>
    <a id="triggerAdd" class="btn btn-primary">Add new vehicle</a>
    <div id="addModal" class="modal hide fade" data-backdrop="static">
      <div class="modal-header">
        <h3>Add new vehicle</h3>
      </div>
      <div class="modal-body">
        <div id="message" style="display: none;"></div>
        <form method="post" id="form">
          <input type="text" id="vin" placeholder="VIN"><br/>
          Color:<br />
          <select id="color">
            <?
            $res2 = $db->query("SELECT * FROM colors c");
            while ($r = $res2->fetch_assoc()) {
            echo "<option value=".$r['colorid'].">" . $r["color"] . "</option>\n";
            }
            ?>
          </select><br />
          <script type="text/javascript">
            function configureDropDownLists() {
              <?
                echo "var makeMapping = {";
                $res4 =$db->query("SELECT makeid FROM makes m");
                while($r=$res4->fetch_assoc()){
                  echo $r['makeid'].": [";
                    $resn = $db->query("SELECT modelid, model FROM models m WHERE makeid=".$r['makeid']);
                    while($r2=$resn->fetch_assoc()){
                      echo "[".$r2['modelid'].", \"".$r2['model']."\"], ";
                    }
                  echo "], ";
                }
                echo "};\n";
              ?>
              var make=$('#make').val();
              $('#modeldiv').attr("style","");
              createOption(document.getElementById('model'),"Please Select a Model",0);
              for(var i=0;i<makeMapping[make].length;i++){
                createOption(document.getElementById("model"), makeMapping[make][i][1], makeMapping[make][i][0]);
              }
            }
            function createOption(ddl, text, value) {
              var opt = document.createElement('option');
              opt.value = value;
              opt.text = text;
              ddl.options.add(opt);
            }
            </script>
            Make:<br />
            <select id="make" onchange="configureDropDownLists()">
              <option value="0">Please Select a Make</option>
              <?
              $res3 = $db->query("SELECT * FROM makes m");
              while ($r = $res3->fetch_assoc()) {
              echo "<option value=".$r['makeid'].">" . $r["make"] . "</option>\n";
              }
              ?>
            </select><br />
            <div id="modeldiv" style="display:none">
            Model:<br />
            <select id="model">
            </select></div>
            <input type="text" id="year" placeholder="Year"><br/>
            Status:<br />
            <select id="status">
              <?
              $res5 = $db->query("SELECT * FROM statuses s");
              while ($r = $res5->fetch_assoc()) {
              echo "<option value=".$r['statusid'].">" . ucwords(strtolower($r["status"])) . "</option>\n";
              }
              ?>
            </select><br />
            Location:<br />
            <select id="location">
              <?
              $res6 = $db->query("SELECT * FROM locations l");
              while ($r = $res6->fetch_assoc()) {
              echo "<option value=".$r['locationid'].">" . $r["name"] . "</option>\n";
              }
              ?>
            </select><br />
          </form>
      </div> <!-- body -->
      <div class="modal-footer">
        <a class="btn reset">Reset</a>
        <a class="btn reset" data-dismiss="modal">Close</a>
        <a id="submit" class="btn btn-primary">Add Vehicle</a>
      </div>
    </div>
<?}?>
  </div>
</body>
</html>
