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

	if(empty($_SESSION)){
		$usertype = "user";
	}else{
		$logtype = $_SESSION["type"];
    $nics = $_SESSION["nic"];
    $user_id = $_SESSION['user_id'];
    $usertype = $_SESSION["usertype"];
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
      <a class="navbar-brand" href="./donorHome.php"><h2 style="font-weight:600; color: #F18259;">DONATE LANKA</h2></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0" <?php if($_SESSION['usertype'] != "user"){ ?> style="margin-right: 20px;" <?php } ?>>
          <?php if($usertype == "donor") {?> 
            <li class="nav-item">
              <a class="nav-link" href="./donorHome.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="./donorSearchRequests.php">Search Request</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="./donorConfirmedDonations.php">Confirmed Donations</a>
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
          <?php }else if($usertype == "authorizer") {?> 
            <li class="nav-item">
              <a class="nav-link" href="../Authorizer/authorizerHome.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../viewRequest.php">View Requests</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../generateReports.php">Generate Reports</a>
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
          <?php } else if($usertype == "requester"){?> 
            <li class="nav-item">
              <a class="nav-link" href="../Requester/requesterHome.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../Requester/requestForm.php">Add Request</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../viewRequest.php">View Requests</a>
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
          <?php }else if($usertype == "admin"){ ?>
            <li class="nav-item">
              <a class="nav-link" href="../Admin/adminHome.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../Admin//adminManageUser.php">Manage Users</a>
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
      <h3>View Requests</h3>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto; margin-bottom:50px;">

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
            <img <?php if($info['category']=="Animal & Humane"){ ; ?> src="../Images/animalandhumancardBg.png" alt="Animal & Humane" 
              <?php }elseif($info['category']=="Health & Medical"){ ; ?> src="../Images/healthandmedicalcardBg.png" alt="Health & Medical" 
                <?php }elseif($info['category']=="Disaster Relief"){ ; ?> src="../Images/disasterreliefcardBg.png" alt="Disaster Relief" 
                  <?php }elseif($info['category']=="Human Services"){ ; ?> src="../Images/humanservicescardBg.png" alt="Human Services"  
                    <?php }elseif($info['category']=="Education"){ ; ?> src="../Images/educationcardBg.png" alt="Education" <?php }; ?> class="card-img-top">
            <div class="card-body">
              <div>
                <a href="./registrationDonor.php">
                  <h3 class="crd-name"><b><?php echo '<a href="#" id="' ."{$info['id']}". '" onclick="passData(this.id)" style="color:#f18259 !important;">' . "{$info['mention_title']}" . ''; ?></a></b></h3>
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
          <!--  -->
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

  	<script type="text/javascript">
		function passData(clicked_id){

			document.cookie='request_id='+clicked_id; 
			document.location.href='./donationView.php';
		}
	</script>
  <!-- container end -->

  <!-- footer -->
  <div class="footer-div">
    <?php require_once("../footer.php"); ?>
  </div>
  <!-- footer end -->

</body>
</html>