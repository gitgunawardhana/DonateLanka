<?php

  include_Once('./config.php');
  session_start();

  if (empty($_SESSION)) {
    $usertype = "user";
    $_SESSION["usertype"] = "user";
  }elseif ($_SESSION["usertype"] == "user") {
    $usertype = "user";
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

  if(!isset($_SESSION['group']) or !isset($_SESSION['group_id'])){
    if ($_SESSION["usertype"] == "admin"){
      header("location:./generateReports.php");
    }
  }else{
    // $req_nic = $_SESSION['nic'];
    $usertype = $_SESSION["usertype"];
    $group = $_SESSION['group'];
    $group_id = $_SESSION['group_id'];
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
            <a class="nav-link active" aria-current="page" href="./generateReports.php">Generate Reports</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>
          <?php }elseif($usertype == "requester"){ ?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Requester/requesterHome.php">Dashboard</a>
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
          <?php }else {?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Authorizer/authorizerHome.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./generateReports.php">Generate Reports</a>
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
  <div class="container-fluid custom-container">
    <div class="container col-md-8 text-center heading-section">
      <h3>Generate Reports</h3>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto; margin-bottom: 50px;">

    <?php

		if ($group == "requester_grp") {

			echo '<div class="fh5co-hero">
            <table class="cst-tbl table" id="result_tbl">
            <thead>
            <tr>
              <th class="th-col" scope="col">Name</th>
              <th class="th-col" scope="col">Telephone</th>
              <th class="th-col" scope="col">Address</th>
              <th class="th-col" scope="col">Request Category</th>
              <th class="th-col" scope="col">Title</th>
              <th class="th-col" scope="col">Details</th>
              <th class="th-col" scope="col">End Date</th>
            </tr>
            </thead>
            <tbody>';

      $sql = "SELECT  requester.*, request.* FROM requester INNER JOIN request ON requester.id = request.requester_id WHERE request.requester_id = '$group_id' AND Status='Approved'";

      if ($result = mysqli_query($con,$sql)) {
        while ($row = $result->fetch_assoc()) {
							
          $full_name = $row["full_name"];
          $mobile = $row["mobile"];
          $address = $row["address"];
          $category = $row["category"];
          $mention_title = $row["mention_title"];
          $explanation = $row["explanation"];
          $last_day = $row["last_day"];

          echo '<tr class="danger">
                  <td>'.$full_name.'</td>
                  <td>'.$mobile.'</td> 
                  <td>'.$address.'</td>
                  <td>'.$category.'</td>
                  <td>'.$mention_title.'</td> 
                  <td>'.$explanation.'</td>
                  <td>'.$last_day.'</td>
                </tr>';
        }
						
      }
      echo '</tbody></table></div>';
		}else if ($group == "donor_grp") {

			echo '<div class="fh5co-hero">
            <table class="cst-tbl table" id="result_tbl">
            <thead>
            <tr>
              <th class="th-col" scope="col">Requester Name</th>
              <th class="th-col" scope="col">Request Title</th>
              <th class="th-col" scope="col">Request Category</th>
              <th class="th-col" scope="col">Donor Name</th>
              <th class="th-col" scope="col">Telephone</th>
              <th class="th-col" scope="col">Donation Details</th>
              <th class="th-col" scope="col">Donated Date</th>
            </tr>
            </thead>
            <tbody>';

			//$sql = "SELECT request.*, donation.*, donor.* FROM request INNER JOIN donation ON request.Request_ID = donation.Req_ID INNER JOIN donor ON donation.Donor_ID = donor.nic WHERE donation.Req_ID = '$group_id' ";

      $sql = "SELECT request.*, donation.*, donor.* FROM request INNER JOIN donation ON request.id = donation.request_id INNER JOIN donor ON donation.donor_id = donor.id WHERE donation.request_id = '$group_id' ";

			if ($result = mysqli_query($con,$sql)) {
				while ($row = $result->fetch_assoc()) {
					
					$requester_name = $row['full_name'];
					$mention_title = $row['mention_title'];
					$category = $row['category'];
					$donor_first_name = $row['first_name'];
					$donor_last_name = $row['last_name'];
					$mobile = $row['mobile'];
					$donation_details = $row['details'];
					$confirmed_date = $row['confirmed_date'];

					echo '<tr class="danger">
                  <td>'.$requester_name.'</td>
                  <td>'.$mention_title.'</td>
                  <td>'.$category.'</td> 
                  <td>'.$donor_first_name. " " . $donor_last_name .' </td>
                  <td>'.$mobile.'</td> 
                  <td>'.$donation_details.'</td> 
                  <td>'.$confirmed_date.'</td>
                </tr>';
				}
			
			}
						
			echo '</tbody></table></div>';
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