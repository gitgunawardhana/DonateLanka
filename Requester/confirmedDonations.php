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
      <h3>View Donations</h3>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto; margin-bottom:50px;">

    <?php
			$sql = "SELECT request.*, donation.*, COUNT(donation.request_id) AS count, donor.* FROM request INNER JOIN donation ON request.id = donation.request_id INNER JOIN donor ON donation.donor_id = donor.id GROUP By donation.request_id ";

			if ($result = mysqli_query($con,$sql)) {
				if(mysqli_num_rows($result)>0){
					echo '<div class="fh5co-hero">
							<table class="cst-tbl table" id="result_tbl">
                  <thead>
                  <tr>
                    <th class="th-col" scope="col">Request ID</th>
                    <th class="th-col" scope="col">Request Title</th>
                    <th class="th-col" scope="col">Request Category</th>
                    <th class="th-col" scope="col">Donation Count</th>
                    <th class="th-col"  scope="col" style="text-align:center";>Action</th>
                  </tr>
                  </thead>
                <tbody>';
					while ($row = $result->fetch_assoc()) {
						
						$mention_title = $row["mention_title"];
						$category = $row["category"];
						$request_id = $row["request_id"];
						$donation_count = $row["count"];

						echo '<tr class="danger">
                    <td>'.$request_id.'</td>
                    <td>'.$mention_title.'</td>
                    <td>'.$category.'</td> 
                    <td>'.$donation_count.'</td>
                    <td width="50px"><form method="POST" action="#"><input type="submit"  name="don_group" class="btn btn-warning" value="View"><input type="hidden" name="hidd" value="'.$request_id.'"></form></td>
                  </tr>';
					}
				}else{
					echo "<h3 align='center'>No Donations to View</h3>";
					echo "</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>";
				}
			}
				
			echo '</tbody></table></div>';
			
			if (isset($_POST['don_group'])) {

				$_SESSION['group'] = "donor_grp";
				$_SESSION['group_id'] = $_POST['hidd'];
        echo "<script>location.href = './viewGroupDonations.php';</script>";
				// header("Location:../Requester/viewGroupDonations.php");
			}
		?>
  </div>

  <!-- container end -->

  <!-- footer -->
  <div class="footer-div">
    <?php require_once("../footer.php"); ?>
  </div>
  <!-- footer end -->
  
</body>
</html>