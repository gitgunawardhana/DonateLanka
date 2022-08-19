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
  }elseif ($_SESSION["usertype"] == "requester"){
    header("location:../Requester/requesterHome.php");
  }elseif ($_SESSION["usertype"] == "authorizer"){
    header("location:../Authorizer/authorizerHome.php");
  }elseif ($_SESSION["usertype"] == "admin"){
    header("location:../Admin/adminHome.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donor</title>

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
      <a class="navbar-brand" href="./donorHome.php"><h2 style="font-weight:600; color: #F18259;">DONATE LANKA</h2></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0" <?php if($_SESSION['usertype'] != "user"){ ?> style="margin-right: 20px;" <?php } ?>>
          <li class="nav-item">
            <a class="nav-link" href="./donorHome.php">
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../updateInfoDonor.php">Update Profile</a>
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
      <h3>Donor</h3>
      <p>Sample test Sample test Sample test Sample test Sample test Sample test Sample test Sample test</p>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto;">
    <div class="container" style="margin-top: 50px;">
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-15.jpg" class="card-img-top" alt="Manage Users">
            <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">View Requests</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" href="./donorRequestsView.php">See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-18.jpg" class="card-img-top" alt="Generate Report">
            <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Search Requests</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" href="./donorSearchRequests.php">See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100 crd hover-zoom hoverable hover-shadow">
            <img src="../Images/place-16.jpg" class="card-img-top" alt="Authentication">
            <div class="card-body crd-bdy desc">
              <span></span>
              <h5 class="card-title crd-ttl">Confirmed Donation</h5>
              <a class="btn btn-primary btn-outline btn-cst border border-light" href="./donorConfirmedDonations.php">See Now &nbsp;<i class="fa-solid fa-angle-right"></i></a>
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