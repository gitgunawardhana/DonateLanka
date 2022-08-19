<?php

  session_start();
	include_Once('../config.php');

  if (empty($_SESSION)) {
    $usertype = "user";
    $_SESSION["usertype"] = "user";
  }elseif ($_SESSION["usertype"] == "user") {
    $usertype = "user";
  }

  if ($_SESSION["usertype"] == "user"){
    header("location:../index.php");
  }elseif ($_SESSION["usertype"] == "donor"){
    header("location:../Donor/donorHome.php");
  }elseif ($_SESSION["usertype"] == "admin"){
    header("location:../Admin/adminHome.php");
  }

  if(!isset($_SESSION['group']) or !isset($_SESSION['group_id'])){
    if ($_SESSION["usertype"] == "requester"){
      header("location:./confirmedDonations.php");
    }elseif ($_SESSION["usertype"] == "authorizer"){
      header("location:../Authorizer/authorizerConfirmedDonations.php");
    }
  }else{
    $req_nic = $_SESSION['nic'];
    $user_id = $_SESSION['user_id'];
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
  require_once("../Inc/alert_link.php");
  require_once("../Inc/bootstrap_link.php");
  require_once("../Inc/font_awesome_link.php");
  require_once("../Inc/google_font_link.php");
  require_once("../Inc/mdb_link.php");
  ?>
  <!-- links end -->

  <!-- custom styles link -->
  <link rel="stylesheet" href="../Style/style.css">
  <!-- custom styles link end-->

</head>
<body>

  <!-- navbar -->
  <nav class="navbar navbar-expand-lg shadow-sm fixed-top" style="background-color: white;">
    <div class="container-fluid">
      <a class="navbar-brand" href="./requesterHome.php"><h2 style="font-weight:600; color: #F18259;">DONATE LANKA</h2></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0" <?php if($_SESSION['usertype'] != "user"){ ?> style="margin-right: 20px;" <?php } ?>>
          <?php if($usertype == "requester"){ ?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./requesterHome.php">Dashboard</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Request
            </a>
            <ul class="nav-item dropdown-menu dropdown-menu-light shadow-sm" aria-labelledby="navbarDarkDropdownMenuLink">
              <li><a class="nav-link" href="./requestForm.php">Create Request</a></li>
              <li><a class="nav-link" href="../viewRequest.php">View Request</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../Chat/chatIndex.php">Chat</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../contact.php">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">Logout</a>
          </li>
          <?php }else {?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../Authorizer/authorizerHome.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../contact.php">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>
          <?php }  ?>
        </ul>
        <?php if($_SESSION['usertype'] != "user"){ ?>
          <a class="nav-link" href="" style="padding-inline: inherit; padding-left: 20px; height:80px">
            <img src=<?php echo "../{$_SESSION['profile_picture']}" ?> alt="Avatar" class="avatar cst-avatar" style="border-radius: 100px; padding:0px !important; object-fit: cover; border:#F18259 solid 2px; margin: 0px 11px;" width="55px" height="55px">
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
      <h3>View Donations</h3>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto; margin-bottom:50px;">

    <?php
			echo '<div class="fh5co-hero">
              <table class="cst-tbl table" id="result_tbl">
              <thead>
                <tr>
                  <th class="th-col" scope="col">Donor Name</th>
                  <th class="th-col" scope="col">Telephone</th>
                  <th class="th-col" scope="col">Donation Details</th>
                  <th class="th-col" scope="col">Donated Date</th>
                </tr>
              </thead>
              <tbody>';

      $sql = "SELECT request.*, donation.*, donor.*, donor.mobile as donor_mobile FROM request INNER JOIN donation ON request.id = donation.request_id INNER JOIN donor ON donation.donor_id = donor.id WHERE donation.request_id = '$group_id' ";

			if ($result = mysqli_query($con,$sql)) {
				while ($row = $result->fetch_assoc()) {
					
					$donor_first_name = $row['first_name'];
					$donor_last_name = $row['last_name'];
					$donor_mobile = $row['donor_mobile'];
					$donation_details = $row['details'];
					$confirmed_date = $row['confirmed_date'];

					echo '<tr class="danger">
                  <td>'.$donor_first_name. " " . $donor_last_name .' </td>
                  <td>'.$donor_mobile.'</td> 
                  <td>'.$donation_details.'</td> 
                  <td>'.$confirmed_date.'</td>
                </tr>';
				}
			}
			echo '</tbody></table></div>';
		?>
  </div>


  <!-- footer -->
  <div class="footer-div">
    <?php require_once("../footer.php"); ?>
  </div>
  <!-- footer end -->

  
</body>
</html>