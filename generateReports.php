<?php
	include('./config.php');

  session_start();

  if (empty($_SESSION)) {
    $usertype = "user";
    $_SESSION["usertype"] = "user";
  }elseif ($_SESSION["usertype"] == "user") {
    $usertype = "user";
  }else{
    $logtype = $_SESSION["type"];
    $user_id = $_SESSION["user_id"];
    $usertype = $_SESSION["usertype"];
  }

  if ($_SESSION["usertype"] == "user"){
    header("location:./index.php");
  }elseif ($_SESSION["usertype"] == "donor"){
    header("location:./Donor/donorHome.php");
  }elseif ($_SESSION["usertype"] == "requester"){
    header("location:./Requester/requesterHome.php");
  }

  if(isset($_SESSION["approvedUser"])){
    if($_SESSION["approvedUser"]=="N"){
      header("location:./Authorizer/authorizerHome.php");
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DONATE LANKA</title>

  <!-- links -->
  <?php
  require_once("./Inc/alert_link.php");
  require_once("./Inc/bootstrap_link.php");
  require_once("./Inc/font_awesome_link.php");
  require_once("./Inc/google_font_link.php");
  require_once("./Inc/mdb_link.php");
  ?>
  <!-- links end -->

  <!-- custom styles link -->
  <link rel="stylesheet" href="./Style/style.css">
  <!-- custom styles link end-->

</head>
<body>  
  
  <!-- navbar -->
  <nav class="navbar navbar-expand-lg shadow-sm fixed-top" style="background-color: white;">
    <div class="container-fluid">
      <a class="navbar-brand" <?php if($_SESSION["usertype"] == "admin") {?>  href="./Admin/adminHome.php" <?php }elseif($_SESSION["usertype"] == "requester") {?> href="./Requester/requesterHome.php" <?php }elseif($_SESSION["usertype"] == "donor") {?> href="./Donor/donorHome.php"  <?php }elseif($_SESSION["usertype"] == "authorizer") {?> href="./Authorizer/authorizerHome.php" <?php }else {?> href="./index.php" <?php } ?>> 
        <h2 style="font-weight:600; color: #F18259;">DONATE LANKA</h2>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0" <?php if($_SESSION['usertype'] != "user"){ ?> style="margin-right: 20px;" <?php } ?>>
          <?php if($usertype == "admin") {?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Admin/adminHome.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Admin/adminManageUser.php">Manage User</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./generateReports.php">Generate Report</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>
          <?php }else {?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Authorizer/authorizerHome.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./contact.php">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>
          <?php }  ?>
        </ul>
        <?php if($_SESSION['usertype'] != "user"){ ?>
          <a class="nav-link" href="" style="padding-inline: inherit; padding-left: 20px; height:80px">
            <img src=<?php echo "./{$_SESSION['profile_picture']}" ?> alt="Avatar" class="avatar cst-avatar" style="border-radius: 100px; padding:0px !important; object-fit: cover; border:#F18259 solid 2px; margin: 0px 11px;" width="55px" height="55px">
            <p class="text-center" style="font-size: 12px;"><b><?php echo $_SESSION['username'];?></b></p>
          </a>
        <?php } ?>
      </div>
    </div>
  </nav>
  <!-- navbar end -->

  <!-- container -->
  <div class="container custom-container">
    <div class="container col-md-8 text-center heading-section">
      <h3>Generate Reports</h3>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto;">
    <table class="table" style="margin-top: 40px;">
      <tr> 
        <form method="POST">
        <th>
          <select class="form-select" id="type" name="type" onchange="setVal()">
            <option>All Requests</option>
            <option value="Requests by Category">Requests by Category</option>
            <option>Group by Requesters</option>
            <option>All Donations</option>
            <option>Group by Donations</option>
          </select>		  
        </th>
        <th>
          <div class="col-xxs-12 col-xs-12 mt">
            <div class="input-field">
              <select class="form-select" id="category" name="category" disabled="">
								
              </select>
            </div>
          </div>
        </th>
        <th width="50px"><button type="Submit" class="btn btn-info"  name="sby_category">Search</button></th>
      </form>
      </tr>
    </table>

    <script type="text/javascript">
      $(document).ready(function () {
        $("#type").change(function () {
          var val = $(this).val();
          if (val == "Requests by Category") {
            document.getElementById("category").disabled = false;
              $("#category").html("<option>Health & Medical</option><option>Education</option><option>Human Services</option><option>Animal & Humane</option><option>Disaster Relief</option>");
          }
        });
      });
    </script>

    <?php
			if (isset($_POST['sby_category'])) {
				
				$search_type = $_POST['type'];

				switch ($search_type) {
					case 'All Requests':
						echo searchRequest("request", "requester", " WHERE status = 'Approved'");
						break;
					case 'Requests by Category':
						$search_category = $_POST['category'];
						echo searchRequest("request", "requester", "WHERE category = '$search_category' AND status = 'Approved'");
						break;
					case 'Group by Requesters':
						echo searchRequestGroups("request", "requester", "WHERE status = 'Approved' GROUP By request.requester_id");
						break;
					case 'All Donations':
						echo searchDonation("request", "donation", "donor", "");
						break;
					case 'Group by Donations':
						echo searchDonationGroup("request", "donation", "donor", "GROUP By donation.request_id");
						break;
					
					default:
						// code...
						break;
				}
				

			}else {
				
				echo "<h3 align='center'>Please Select Report Type</h3>";
				echo "</br></br></br></br></br></br></br></br></br></br></br>";
			}

			function searchRequest($table1, $table2, $query){

				include('./config.php');

				

        $sql = "SELECT $table1.*, $table2.* FROM $table1 INNER JOIN $table2 ON $table1.requester_id = $table2.id $query";

        //$sql = "SELECT request.*, requester.* FROM request INNER JOIN requester ON request.nic = requester.nic WHERE $column = '$value' ";

        if ($result = mysqli_query($con,$sql)) {
          if(mysqli_num_rows($result)>0){

            echo '<div class="fh5co-hero">
              <table class="cst-tbl table" id="result_tbl">
                  <thead>
                  <tr>
                    <th class="th-col"  scope="col">Name</th>
                    <th class="th-col"  scope="col">NIC</th>
                    <th class="th-col"  scope="col">Telephone</th>
                    <th class="th-col"  scope="col">Request Category</th>
                    <th class="th-col"  scope="col">Title</th>
                    <th class="th-col"  scope="col">Details</th>
                    <th class="th-col"  scope="col">Ending Date</th>
                  </tr>
                  </thead>
                  <tbody>';
            while ($row = $result->fetch_assoc()) {
              
              $full_name = $row['full_name'];
              $requester_nic = $row["nic"];
              $mobile = $row["mobile"];
              $category = $row["category"];
              $mention_title = $row["mention_title"];
              $explanation = $row["explanation"];
              $last_day = $row['last_day'];

              echo '<tr class="danger"> 
                      <td>'.$full_name.'</td>
                      <td>'.$requester_nic.'</td>
                      <td>'.$mobile.'</td> 
                      <td>'.$category.'</td>
                      <td>'.$mention_title.'</td> 
                      <td>'.$explanation.'</td>
                      <td>'.$last_day.'</td>
                    </tr>';
            }
          }else{
            echo "<br><h3 align='center'>No Data</h3>";
            echo "</br></br></br></br></br></br></br></br></br>";
          }
        }
						
				echo '</tbody></table></div>';
			}

			function searchRequestGroups($table1, $table2, $query){

				include('./config.php');

        $sql = "SELECT Count($table1.id) AS count, $table1.*, $table2.* FROM $table1 INNER JOIN $table2 ON $table1.requester_id = $table2.id $query";

        if ($result = mysqli_query($con,$sql)) {
          if(mysqli_num_rows($result)>0){

            echo '<div class="fh5co-hero">
            <table class="cst-tbl table" id="result_tbl">
                <thead>
                <tr>
                  <th class="th-col"  scope="col">Name</th>
                  <th class="th-col"  scope="col">NIC</th>
                  <th class="th-col"  scope="col">Telephone</th>
                  <th class="th-col"  scope="col">Request Count</th>
                  <th width="50px" class="th-col"  scope="col" style="text-align: center;">Action</th>
                </tr>
                </thead>
                <tbody>';

            while ($row = $result->fetch_assoc()) {
              $requester_id = $row["requester_id"];
              $full_name = $row['full_name'];
              $requester_nic = $row["nic"];
              $mobile = $row["mobile"];
              $count = $row["count"];

              echo '<tr class="danger">
                      <td>'.$full_name.'</td>
                      <td>'.$requester_nic.'</td>
                      <td>'.$mobile.'</td> 
                      <td>'.$count.'</td>
                      <td><form method="POST" action="#"><input type="submit" name="req_group" class="btn btn-warning" value="View"><input type="hidden" name="hid" value="'.$requester_id.'"></form></td>
                    </tr>';
            }
          }else{
            echo "<br><h3 align='center'>No Data</h3>";
            echo "</br></br></br></br></br></br></br></br></br>";
          }
        }
          
				echo '</tbody></table></div>';
			}

			function searchDonation($table1, $table2, $table3, $query){

				include('./config.php');

				
        $sql = "SELECT $table1.*, $table2.*, $table3.* FROM $table1 INNER JOIN $table2 ON $table1.id = $table2.request_id INNER JOIN $table3 ON $table2.donor_id = $table3.id $query";

        if ($result = mysqli_query($con,$sql)) {
          if(mysqli_num_rows($result)>0){

            echo '<div class="fh5co-hero">
              <table class="cst-tbl table" id="result_tbl">
                  <thead>
                  <tr>
                    <th class="th-col"  scope="col">Requester Name</th>
                    <th class="th-col"  scope="col">Request Title</th>
                    <th class="th-col"  scope="col">Request Category</th>
                    <th class="th-col"  scope="col">Donor Name</th>
                    <th class="th-col"  scope="col">Donation Details</th>
                    <th class="th-col"  scope="col">Donated Date</th>
                  </tr>
                  </thead>
                  <tbody>';

            while ($row = $result->fetch_assoc()) {
              
              $requester_name = $row['full_name'];
              $mention_title = $row["mention_title"];
              $category = $row["category"];
              $donor_first_name = $row["first_name"];
              $donor_last_name = $row["last_name"];
              $donation_details = $row['details'];
              $confirmed_date = $row['confirmed_date'];

              echo '<tr class="danger"> 
                      <td>'.$requester_name.'</td>
                      <td>'.$mention_title.'</td>
                      <td>'.$category.'</td> 
                      <td>'.$donor_first_name. " " . $donor_last_name .' </td>
                      <td>'.$donation_details.'</td> 
                      <td>'.$confirmed_date.'</td>
                    </tr>';
            }
          }else{
            echo "<br><h3 align='center'>No Data</h3>";
            echo "</br></br></br></br></br></br></br></br></br>";
          }
        }
						
				echo '</tbody></table></div>';
			}

			function searchDonationGroup($table1, $table2, $table3, $query){

				include('./config.php');


        $sql = "SELECT request.id as request_id, $table1.*, $table2.*, COUNT($table2.request_id) AS count, $table3.* FROM $table1 INNER JOIN $table2 ON $table1.id = $table2.request_id INNER JOIN $table3 ON $table2.donor_id = $table3.id $query ";

        if ($result = mysqli_query($con,$sql)) {
          if(mysqli_num_rows($result)>0){


            echo '<div class="fh5co-hero">
            <table class="cst-tbl table" id="result_tbl">
                <thead>
                <tr>
                  <th class="th-col"  scope="col">Request ID</th>
                  <th class="th-col"  scope="col">Requster Name</th>
                  <th class="th-col"  scope="col">Request Title</th>
                  <th class="th-col"  scope="col">Request Category</th>
                  <th class="th-col"  scope="col">Donation Count</th>
                  <th width="50px" class="th-col"  scope="col" style="text-align: center;">Action</th>
                </tr>
                </thead>
                <tbody>';
            while ($row = $result->fetch_assoc()) {
              
              $requester_name = $row['full_name'];
              $mention_title = $row["mention_title"];
              $category = $row["category"];
              $request_id = $row["request_id"];
              $donation_count = $row["count"];

              echo '<tr class="danger">
                      <td>'.$request_id.'</td>
                      <td>'.$requester_name.'</td>
                      <td>'.$mention_title.'</td>
                      <td>'.$category.'</td> 
                      <td>'.$donation_count.'</td>
                      <td><form method="POST" action="#"><input type="submit"  name="don_group" class="btn btn-warning" value="View"><input type="hidden" name="hidd" value="'.$request_id.'"></form></td>
                    </tr>';
            }
          }else{
            echo "<br><h3 align='center'>No Data</h3>";
            echo "</br></br></br></br></br></br></br></br></br>";

          }
        }
						
				echo '</tbody></table></div>';
			}

			if (isset($_POST['req_group'])) {

				$_SESSION['group'] = "requester_grp";
				$_SESSION['group_id'] = $_POST['hid'];
        echo "<script>location.href = './viewGroupReports.php';</script>";
				// header("Location:./viewGroupReports.php");
				
			}

			if (isset($_POST['don_group'])) {

				$_SESSION['group'] = "donor_grp";
				$_SESSION['group_id'] = $_POST['hidd'];
        echo "<script>location.href = './viewGroupReports.php';</script>";
				// header("Location:./viewGroupReports.php");
				
			}

		?>
    
  </div>
  <!-- container end -->

  <!-- footer -->
  <div class="footer-div">
    <?php require_once("./footer.php"); ?>
  </div>
  <!-- footer end -->

  
</body>
</html>