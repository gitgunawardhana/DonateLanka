<?php
	include_Once('./config.php');

	session_start();

  if (empty($_SESSION)) {
    $usertype = "user";
    $_SESSION["usertype"] = "user";
  }elseif ($_SESSION["usertype"] == "user") {
    $usertype = "user";
  }else{
    $logtype = $_SESSION["type"];
    $nics = $_SESSION["nic"];
    $usertype = $_SESSION["usertype"];
  }

  if ($_SESSION["usertype"] == "admin"){
    header("location:./Admin/adminHome.php");
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

  <style>
    .container .flex-item-left ul, .container .flex-item-right ul {
      list-style-type: none;
    }
  </style>
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
          <?php if($usertype == "donor") {?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Donor/donorHome.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Donor/donorSearchRequests.php">Search Request</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Donor/donorConfirmedDonations.php">Confirmed Donations</a>
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
          <?php }elseif($usertype == "requester"){ ?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Requester/requesterHome.php">Dashboard</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Request
            </a>
            <ul class="nav-item dropdown-menu dropdown-menu-light shadow-sm" aria-labelledby="navbarDarkDropdownMenuLink">
              <li><a class="nav-link" href="./Requester/requestForm.php">Create Request</a></li>
              <li><a class="nav-link" href="./viewRequest.php">View Request</a></li>
            </ul>
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
          <?php }else if($usertype == "authorizer") {?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Authorizer/authorizerHome.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./viewRequest.php">View Requests</a>
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
          <?php }else {?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Register
            </a>
            <ul class="nav-item dropdown-menu dropdown-menu-light shadow-sm" aria-labelledby="navbarDarkDropdownMenuLink">
              <li><a class="nav-link" href="./registrationRequester.php">Requester</a></li>
              <li><a class="nav-link" href="./registrationDonor.php">Donor</a></li>
              <li><a class="nav-link" href="./registrationAuthorizer.php">Authorizer</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./contact.php">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./login.php">Login</a>
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
      <h3>About Us</h3>
      <h5>We need your financial support.</h5>
      <p>Our extent of the support we provide to victims of stalking is limited by the the amount of funding we receive. A donation from you, no matter how small, can make a significant contribution to our vital work. </p>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto;">

    <div class="container flex-container">
      <div class="flex-item-right">
        <div>
          <h3 class="section-title">Ways You Can Donate</h3>
          <p>In the past 12 months, we have provided support to over 500 stalking victims and their families. Your donation makes a real difference in the lives of stalking victims, their friends, and families who can all be affected by this crime. Your generosity will support our wide-ranging work which provides both emotional and practical support to victims of stalking and continue our campaigning.</p>
          <ul class="contact-info">
            <li><i class="fa-solid fa-hand-holding-medical"></i> &nbsp;&nbsp;Donate Online</li>
            <li><i class="fa-solid fa-hand-holding-medical"></i> &nbsp;&nbsp;Donate by Text</li>
          </ul>
        </div>
      </div>
      <div class="flex-item-left">
        <div>
          <h3 class="section-title">Our Address</h3>
          <p>We’d love to hear from you! Send us your questions or comments and someone from our team will be in touch shortly.</p>
          <ul class="contact-info">
            <li><i class="fa-solid fa-location-dot"></i> &nbsp;&nbsp;198 West 21th Street, Matara, Sri Lanaka</li>
            <li><i class="fa-solid fa-phone-volume"></i> &nbsp;&nbsp;+ 9775 2355 98</li>
            <li><i class="fa-solid fa-envelope"></i><a href="#"> &nbsp;&nbsp;info@yoursite.com</a></li>
            <li><i class="fa-solid fa-earth-asia"></i><a href="#"> &nbsp;&nbsp;www.yoursite.com</a></li>
          </ul>
        </div>
      </div>
    </div>

		</div>
  <!-- container end -->
  

  
  
  <!-- footer -->
  <div class="footer-div">
    <?php require_once("./footer.php"); ?>
  </div>
  <!-- footer end -->
  
</body>
</html>