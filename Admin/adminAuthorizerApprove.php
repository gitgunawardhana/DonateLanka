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
  }elseif ($_SESSION["usertype"] == "donor"){
    header("location:../Donor/donorHome.php");
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
      <a class="navbar-brand" href="./adminHome.php"><h2 style="font-weight:600; color: #F18259;">DONATE LANKA</h2></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0" <?php if($_SESSION['usertype'] != "user"){ ?> style="margin-right: 20px;" <?php } ?>>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./adminHome.php">Dashboard</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Add User
            </a>
            <ul class="nav-item dropdown-menu dropdown-menu-light shadow-sm" aria-labelledby="navbarDarkDropdownMenuLink">
              <li><a class="nav-link" href="../registrationRequester.php">Requester</a></li>
              <li><a class="nav-link" href="../registrationDonor.php">Donor</a></li>
              <li><a class="nav-link" href="../registrationAuthorizer.php">Authorizer</a></li>
            </ul>
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
              Feedback
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
  <div class="container-fluid custom-container">
    <div class="container col-md-8 text-center heading-section">
      <h3>Pending Approval</h3>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto;">
    <?php

      $sql = "SELECT * FROM authorizer WHERE status ='Pending'";
			if ($result = mysqli_query($con,$sql)) {
				if(mysqli_num_rows($result)>0){

					echo '<table class="cst-tbl table">
                  <thead>
                    <tr>
                        <th class="th-col" scope="col">NIC</th>
                        <th class="th-col" scope="col">First Name</th>
                        <th class="th-col" scope="col">Last Name</th>
                        <th class="th-col" scope="col">Gender</th>
                        <th class="th-col" scope="col">Age</th>
                        <th class="th-col" scope="col">Email</th>
                        <th class="th-col" scope="col">Phone</th>
                        <th class="th-col" scope="col">Occupation</th>
                        <th class="th-col" scope="col">Address Residential</th>
                        <th class="th-col" scope="col">Address Official</th>
                        <th class="th-col" scope="col">Status</th>
                        <th class="th-col" scope="col" colspan="2" style="text-align: center;">Action</th>
                    </tr>
                  </thead>
                <tbody>;';

					while ($row = $result->fetch_assoc()) {
            $authorizer_id = $row["id"];
						$nic = $row["nic"];
						$first_name = $row["first_name"];
						$last_name = $row["last_name"];
						$gender = $row["gender"]; 
						$age = $row["age"];
						$email = $row["email"];
						$phone = $row["telephone_mobile"];
						$occupation = $row["occupation"];
						$address_residential = $row["address_residential"];
						$address_official = $row["address_official"];
						$status = $row["status"];
	
						echo '<form action="" method="POST">
                  <tr class="danger">
                      <td>'.$nic.'</td> 
                      <td>'.$first_name.'</td> 
                      <td>'.$last_name.'</td>
                      <td>'.$gender.'</td>
                      <td>'.$age.'</a></td>
                      <td>'.$email.'</a></td>
                      <td>'.$phone.'</td>
                      <td>'.$occupation.'</td>
                      <td>'.$address_residential.'</td>
                      <td>'.$address_official.'</td>
                      <td>'.$status.'</td>
                      <td width="50px"><button onClick=\'javascript:return confirm("Are you sure to approve this user.");\' type="submit" class="btn btn-warning" name="approve">Approve</button>
                      <input type="hidden" name="auth_id" value="'.$authorizer_id.'"</td>
                      <td width="50px"><button onClick=\'javascript:return confirm("Are you sure to reject this user.");\' type="submit" class="btn btn-danger" name="reject">Reject</button></td>
                    </tr>
                  </form>';
          }	
				}
				else 
				{
					echo "<br><h3 align='center'>No Authorizers to Approve</h3>";
					echo "</br></br>";
				}
      }   
      echo '</tbody></table>';
		?>

		<?php
      error_reporting(0); 
			if(isset($_POST['approve'])){
				$key = $_POST['auth_id'];
				$qupdate = mysqli_query($con,"UPDATE `authorizer` SET status = 'Approved' WHERE id = '$key'") or die("Action not successful".mysqli_connect_error());
				echo "<meta http-equiv='refresh' content='0'>";
				header("Refresh:0");
			}
			elseif(isset($_POST['reject'])){
				$key = $_POST['auth_id'];
				$qupdate = mysqli_query($con,"UPDATE `authorizer` SET status = 'Reject' WHERE id = '$key'") or die("Action not successful".mysqli_connect_error());
				echo "<meta http-equiv='refresh' content='0'>";
				header("Refresh:0");
			}
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