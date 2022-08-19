<?php
	include_Once('../config.php');

	session_start();

  if (empty($_SESSION)) {
    $usertype = "user";
    $_SESSION["usertype"] = "user";
  }elseif ($_SESSION["usertype"] == "user") {
    $usertype = "user";
  }

  if ($_SESSION["usertype"] == "user"){
    header("location:../index.php");
  }elseif ($_SESSION["usertype"] == "requester"){
    header("location:../Requester/requesterHome.php");
  }elseif ($_SESSION["usertype"] == "admin"){
    header("location:../Admin/adminHome.php");
  }elseif ($_SESSION["usertype"] == "donor"){
    header("location:../Donor/donorHome.php");
  }

	$user_id = $_SESSION['user_id'];

	$result = mysqli_query($con, "SELECT * FROM authorizer WHERE id= '$user_id' AND status = 'Approved'");
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
  $count = mysqli_num_rows($result); 

  if($count == 1){
    $approvedUser = "Y";
    $_SESSION["approvedUser"] = "Y";
  }else{
    $approvedUser = "N";
    $_SESSION["approvedUser"] = "N";
  }

	$sql = "SELECT * FROM request_notification WHERE authorizer_status = '1'";
	if ($result=mysqli_query($con,$sql)) {
    $rowcount=mysqli_num_rows($result);
  }else{
    $rowcount=0;
  }

	$sql2 = "SELECT * FROM request WHERE status = 'Pending'";
	if ($result2=mysqli_query($con,$sql2)) {
    $rowcount2=mysqli_num_rows($result2);
	}else{
		$rowcount2=0;
	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Authorizer</title>

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
      <a class="navbar-brand" href="./authorizerHome.php"><h2 style="font-weight:600; color: #F18259;">DONATE LANKA</h2></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0" <?php if($_SESSION['usertype'] != "user"){ ?> style="margin-right: 20px;" <?php } ?>>

          <?php if($approvedUser == "Y") { ?>
            <li class="nav-item">
              <a class="nav-link" href="./authorizerHome.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../updateInfoAuthorizer.php">Update Profile</a>
            </li>            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Request
              </a>
              <ul class="nav-item dropdown-menu dropdown-menu-light shadow-sm" aria-labelledby="navbarDarkDropdownMenuLink">
                <li><a class="nav-link" href="../addRequestAdminAuthorizer.php">Create Request</a></li>
                <li><a class="nav-link" href="../viewRequest.php">View Request</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../feedback.php">
                feedback
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
          <?php }else { ?>

            <li><a href="../logout.php">Logout</a></li>

          <?php } ?>
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
      <?php 
        if($approvedUser == "N"){ 
          echo '<div class="text-center alert alert-warning alert-dismissible fade show border border-warning" role="alert" style="margin-bottom: 50px; padding: 10px 50px">Please wait !<br>Your details are being verified.</div>';
        } 
      ?>
      <h3>Authorizer</h3>
      <?php if($approvedUser == "Y") {?>
        <p>Sample test Sample test Sample test Sample test Sample test Sample test Sample test Sample test</p>
      <?php }else { ?>
        <p>You have to wait until approved by the Administration. Thank You!</p>
      <?php } ?>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto;">
    <div class="container" style="margin-top: 50px;">
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-12.jpg" class="card-img-top" alt="Manage Users">
            <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">View Requests</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" <?php if($approvedUser == "Y") {?> href="../viewRequest.php" <?php } ?>>See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img <?php if($rowcount2 > 0) {?> src="../Images/place-14-red.jpg" <?php }else {?> src="../Images/place-14-grey.jpg" <?php }  ?> class="card-img-top" alt="Generate Report">
            <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Approve Requests</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" <?php if($approvedUser == "Y") {?> href="./authorizerApproveRequest.php" <?php } ?>>See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img <?php if($rowcount > 0) {?> src="../Images/place-17-red.jpg" <?php }else {?> src="../Images/place-17-grey.jpg" <?php }  ?> class="card-img-top" alt="Generate Report">
            <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Notification</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" <?php if($approvedUser == "Y") {?> href="../notificationRequest.php"<?php } ?>>See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-16.jpg" class="card-img-top" alt="Authentication">
            <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Confirmed donations</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" <?php if($approvedUser == "Y") {?> href="./authorizerConfirmedDonations.php" <?php } ?>>See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-12.jpg" class="card-img-top" alt="Manage Users">
            <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">View Donor</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" <?php if($approvedUser == "Y") {?> href="./authorizerViewDonor.php" <?php } ?>>See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-13.jpg" class="card-img-top" alt="Generate Report">
            <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Generate Reports</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" <?php if($approvedUser == "Y") {?> href="../generateReports.php" <?php } ?>>See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div>
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