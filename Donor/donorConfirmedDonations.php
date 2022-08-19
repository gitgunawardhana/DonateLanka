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
  
	$donor_id = $_SESSION['user_id'];

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
          <li class="nav-item">
            <a class="nav-link" href="./donorHome.php">Dashboard</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Donations
            </a>
            <ul class="nav-item dropdown-menu dropdown-menu-light shadow-sm" aria-labelledby="navbarDarkDropdownMenuLink">
              <li><a class="nav-link" href="./donorRequestsView.php">View Request</a></li>
              <li><a class="nav-link" href="./donorConfirmedDonations.php">Confirmed Donations</a></li>
            </ul>
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
      <h3>Confirmed Donations</h3>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto;">
    
    <?php
	
		$sql = "SELECT  request.mention_title,  request.category, request.full_name, request.file, requester.mobile, requester.address, donation.details, donation.confirmed_date FROM request INNER JOIN requester ON request.requester_id = requester.id INNER JOIN donation ON request.id = donation.request_id WHERE donor_id = '$donor_id' ";

		if ($result = mysqli_query($con,$sql)) {
			if(mysqli_num_rows($result)>0){

				echo '<div class="fh5co-hero" style="margin-top:50px;">
                <table class="cst-tbl table">
                  <thead>
                    <tr>
                      <th class="th-col" scope="col">Request Title</th>
                      <th class="th-col" scope="col">Category</th>
                      <th class="th-col" scope="col">Requester Name</th>
                      <th class="th-col" scope="col">Mobile</th>
                      <th class="th-col" scope="col">Address</th>
                      <th class="th-col" scope="col">Attachment</th>
                      <th class="th-col" scope="col">Donation Details</th>
                      <th class="th-col" scope="col">Donated Date</th>
                  </tr></thead><tbody>';
				while ($row = $result->fetch_assoc()) {
					$req = $row["mention_title"];
					$category = $row["category"];
					$attachment = $row["file"];

					$full_name = $row['full_name'];
					$mobile = $row['mobile'];
					$address = $row['address'];

					$details = $row['details'];
					$confirmed_date = $row['confirmed_date'];

					echo '<tr class="danger">
                  <td>'.$req.'</td> 
                  <td>'.$category.'</td>
                  <td>'.$full_name.'</td> 
                  <td>'.$mobile.'</td>
                  <td>'.$address.'</td>
                  <td><a href="../Upload/'.$attachment.'" target="_blank">'.$attachment.'</a></td>
                  <td>'.$details.'</td>
                  <td>'.$confirmed_date.'</td>
                </tr>';
				}
			}else{
				echo "</br><h3 align='center'>No Confirmed Donations</h3>";
				echo "</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>";
			}
		}
		echo '</tbody></table></div>';
	  ?>
    </br></br></br></br></br></br></br></br></br></br></br></br>
  </div>
  <!-- container end -->


  <!-- footer -->
  <div class="footer-div">
    <?php require_once("../footer.php"); ?>
  </div>
  <!-- footer end -->

  
</body>
</html>