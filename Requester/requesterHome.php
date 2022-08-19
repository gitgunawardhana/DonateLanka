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
  }elseif ($_SESSION["usertype"] == "authorizer"){
    header("location:../Authorizer/authorizerHome.php");
  }elseif ($_SESSION["usertype"] == "admin"){
    header("location:../Admin/adminHome.php");
  }

	$logtype = $_SESSION["type"];
  $nics = $_SESSION["nic"];
  $user_id = $_SESSION["user_id"];

	$sql = "SELECT * FROM request_notification WHERE requester_status ='1' AND 	requester_nic = '$nics'";
	if ($result=mysqli_query($con,$sql)) {
    $rowcount=mysqli_num_rows($result);
	}else{
		$rowcount=0;
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Requester</title>

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
          <li class="nav-item">
            <a class="nav-link" href="./requesterHome.php">
              Dashboard
            </a>
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
            <a class="nav-link active" aria-current="page" href="../updateInfoRequester.php">Update Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../Chat/chatIndex.php">
              Chat
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../contact.php">
              Contact
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../about.php">
              About
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">
              Logout
            </a>
          </li>
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
      <h3>What Can I Request?</h3>
      <p>This site is designed to provide relief to people in need.This will give you some relief from any financial difficulties you may have.</p>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto;">
    <div class="container" style="margin-top: 50px;">
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-19.jpg" class="card-img-top" alt="Manage Users">
            <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Create Request</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" href="./requestForm.php">Create Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-15.jpg" class="card-img-top" alt="Generate Report">
            <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">View Request</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" href="../viewRequest.php">View Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img <?php if($rowcount > 0) {?> src="../Images/place-17-red.jpg" <?php }else {?> src="../Images/place-17-grey.jpg" <?php }  ?> class="card-img-top" alt="Authentication">
            <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Notification</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" href="../notificationRequest.php">See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-13.jpg" class="card-img-top" alt="Generate Report">
            <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Confirmed donations</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" href="./confirmedDonations.php">See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-4.jpg" class="card-img-top" alt="Generate Report">
            <!-- <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Generate Report</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" href="../generateReports.php">See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div> -->
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-5.jpg" class="card-img-top" alt="Generate Report">
            <!-- <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Generate Report</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" href="../generateReports.php">See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div> -->
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-6.jpg" class="card-img-top" alt="Generate Report">
            <!-- <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Generate Report</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" href="../generateReports.php">See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div> -->
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-3.jpg" class="card-img-top" alt="Generate Report">
            <!-- <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Generate Report</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" href="../generateReports.php">See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div> -->
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-2.jpg" class="card-img-top" alt="Generate Report">
            <!-- <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Generate Report</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" href="../generateReports.php">See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- container end -->

  <!-- footer -->
  <div class="footer-div">
    <?php require_once("../footer.php"); ?>
  </div>
  <!-- footer end -->

  
</body>
</html>