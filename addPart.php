<?php
include('util.php');
begin();

make_head("Add Part");
?>
  <body>
    <div class="container">
      <? include('navbar.html') ?>
      <h1>Add Part</h1>
<?php if(is_manager()){
$db = connect_db();
if (isset($_POST['newsubmit'])) {
  if ($_POST['firstname'] != "" && $_POST['lastname'] != "") {
    if ($_POST['email'] != "") {
      if ($_POST['address'] == "") {
        echo '<div class="alert alert-error">Please enter an address</div>';
      } else {
      if ($_POST['phone'] == "") {
        echo '<div class="alert alert-error">Please enter a phone number</div>';
      } else {
      if ($_POST['user'] == "") {
        echo '<div class="alert alert-error">Please enter a username</div>';
      } else {
      if ($_POST['pass'] == "" || $_POST['duppass'] == "") {
        echo '<div class="alert alert-error">Please enter and confirm password</div>';
      } else {
      if ($_POST['pass'] !=  $_POST['duppass']) {
        echo '<div class="alert alert-error">Passwords do not match</div>';
      } else {
        $res = mysqli_query($db,'INSERT INTO people (firstname, lastname, email, address, cityid, phone) VALUES ("'.$_POST['firstname'].'","'.$_POST['lastname'].'","'.$_POST['email'].'","'.$_POST['address'].'",'.$_POST['city'].','.$_POST['phone'].');');
        if ($res) {
          $personid=mysqli_insert_id($db);
          echo $personid." and ".$_POST['pass']." and ".$_POST['rank'];
          $res2 = mysqli_query($db,'INSERT INTO employees (personid, username, password, rankid, statusid) VALUES ('.$personid.',"'.$_POST['user'].'","'.sha1($_POST['pass']).'",'.$_POST['rank'].','.$basestatus.');');
          $_POST['firstname']="";
          $_POST['lastname']="";
          $_POST['email']="";
          $_POST['address']="";
          $_POST['phone']="";
          $_POST['user']="";
          if ($res2) {
            echo '<div class="alert alert-success">Employee successfully created</div>';
          } else {
            echo '<div class="alert alert-error">Error creating employee</div>';
          }  
        } else {
          echo '<div class="alert alert-error">Error creating employee</div>';
        }
      }//match error
      }//password error
      }//username error
      }//phone error
      }//address error
    } else {
      echo '<div class="alert alert-error">Please enter an email</div>';
    }
  } else {
    echo '<div class="alert alert-error">Please enter both a first and last name</div>';
  }
}
} ?>

<? if(is_manager()){ ?>
      <!--<script>
        $('#addPart a').click(function (e) {
          e.preventDefault();
          $(this).tab('show');
        })
      </script>-->
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#newpart" data-toggle="tab">New Part</a></li>
          <li><a href="#addpart" data-toggle="tab">Additional Parts</a></li>
        </ul>
        <div class="tab-content">
          <div id="newpart" class="tab-pane active">
            <form method="post" action="addPart.php">
              <input type="hidden" name="newsubmit">
              <input type="text" name="newpartname" <? echo ((isset($_POST['newpartname']) && $_POST['newpartname'] != "") ? "value=".$_POST['newpartname'] : "placeholder=\"Part name\""); ?>><br/>
              <input type="text" name="newpartquantity" <? echo ((isset($_POST['newpartquantity']) && $_POST['newpartquantity'] != "") ? "value=".$_POST['newpartquantity'] : "placeholder=\"Quantity\""); ?>><br/>
              <input type="text" name="newpartcost" <? echo ((isset($_POST['newpartcost']) && $_POST['newpartcost'] != "") ? "value=".$_POST['newpartcost'] : "placeholder=\"Cost\""); ?>><br/>
              <table name="buttontable"><tr><td>
                <button class="btn btn-large btn-primary">Add Employee</button>
            </form></td><td>
            <form action="parts.php"><br />
              <button class="btn btn-large">Cancel</button>
            </form>
              </td></tr></table>
          </div>
          <div id="addpart" class="tab-pane">
            <form method="post" action="addPart.php">
              <input type="hidden" name="addsubmit">
              <input type="text" name="user" <? echo ((isset($_POST['user']) && $_POST['user'] != "") ? "value=".$_POST['user'] : "placeholder=\"Username\""); ?>><br/>
              <input type="password" name="pass" placeholder="Password"><br/>
              <input type="password" name="duppass" placeholder="Confirm password"><br/>
              Rank:<br />
              <select name="rank">
                <?
                  $res4 = $db->query("SELECT * FROM ranks r");
                  while ($r = $res4->fetch_assoc()) {
                    echo "<option value=".$r['rankid'].">" . $r["rank"] . "</option>\n";
                  }
                ?>
              </select><br />
              <table name="buttontable"><tr><td>
                <button class="btn btn-large btn-primary">Add Employee</button>
            </form></td><td>
            <form action="parts.php"><br />
              <button class="btn btn-large">Cancel</button>
            </form>
              </td></tr></table>
          </div>
        </div><!--tab content-->
        <script>
          $(function () {
            $('#myTab a:last').tab('show');
          })
        </script>
      </div><!--tabbable-->
<?} else{?>
    <h3>Only Managers can add parts</h3>
<?}?>
    </div><!--container-->
  </body>
</html> 
