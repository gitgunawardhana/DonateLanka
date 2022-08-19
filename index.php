<?php
include_once('./config.php');
// include_once('./configAdmin.php');

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
}elseif ($_SESSION["usertype"] == "requester"){
  header("location:./Requester/requesterHome.php");
}elseif ($_SESSION["usertype"] == "authorizer"){
  header("location:./Authorizer/authorizerHome.php");
}elseif ($_SESSION["usertype"] == "donor"){
  header("location:./Donor/donorHome.php");
}
?>



<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Donate Lanka</title>

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


<style>

</style>
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
            <a class="nav-link" href="./contact.php">
              Contact
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./about.php">
              About
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./login.php">
              Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- navbar end -->

  <!-- header -->
  <?php include_once("./header.php"); ?>
  <!-- header end -->

  <!-- container -->
  <div class="container custom-container">
    <h2 align="center"  style="margin-bottom: 80px;"><b>WELCOME TO DONATE LANKA</b></h2>
    <div class="cst-row">
      <?php

      $sql = "SELECT * FROM request WHERE status = 'Approved'";
      
      if ($result = mysqli_query($con, $sql)) {
        if (mysqli_num_rows($result) > 0) {
          while ($info = $result->fetch_assoc()) {
      ?>
      <div class="col-md-4 crd-div">
        <div class="row-inner">
          <div class="card hover-zoom hoverable hover-shadow" style="margin: 18px; overflow: hidden;">
            <img <?php if($info['category']=="Animal & Humane"){ ; ?> src="./Images/animalandhumancardBg.png" alt="Animal & Humane" 
              <?php }elseif($info['category']=="Health & Medical"){ ; ?> src="./Images/healthandmedicalcardBg.png" alt="Health & Medical" 
                <?php }elseif($info['category']=="Disaster Relief"){ ; ?> src="./Images/disasterreliefcardBg.png" alt="Disaster Relief" 
                  <?php }elseif($info['category']=="Human Services"){ ; ?> src="./Images/humanservicescardBg.png" alt="Human Services"  
                    <?php }elseif($info['category']=="Education"){ ; ?> src="./Images/educationcardBg.png" alt="Education" <?php }; ?> class="card-img-top">
            <div class="card-body">
              <div>
                <a href="./registrationDonor.php">
                  <h3 class="crd-name"><b><?php echo "{$info['mention_title']}"; ?></b></h3>
                </a>
              </div>
              <div>
                <p><?php echo "{$info['explanation']}"; ?></p>
              </div>
              <div>
                <label>Requester Name: </label>
                <a><?php echo "{$info['full_name']}"; ?></a>
              </div>
              <div>
                <label>Last Date: </label>
                <a><?php echo "{$info['last_day']}"; ?></a>
              </div>
            </div>
          </div>
          <!-- <div class="card bg-dark text-white" style="background-color: black;">
            <img style="opacity: .5;" src="./Images/cardBg.png" class="card-img" alt="...">
            <div class="card-img-overlay">
              
            </div>
          </div> -->
          <!-- <div class="custom-crd shadow-sm">
            
          </div> -->
        </div>
      </div>
      <?php };
        } else {
          echo "<br><h3 class='text-center' align='center' style='margin:0px auto !important; color:#5a5a5a !important;'>No Requests</h3>";
          echo "</br></br></br></br></br></br>";
        };
      };
      ?>
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