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
	$logtype = $_SESSION["type"];
	$usertype = $_SESSION["usertype"];
	$request_id = $_COOKIE["request_id"];

	if(isset($request_id)){

		$sql = "SELECT request.full_name, request.mention_title, request.explanation, request.category, request.last_day, request.file, requester.mobile, requester.email, requester.address FROM request INNER JOIN requester ON request.requester_id = requester.id WHERE request.id = '$request_id' ";

		if ($result = mysqli_query($con,$sql)) {
			while ($row = $result->fetch_assoc()){

				$req_title = $row["mention_title"];
				$req_details = $row["explanation"];
				$req_cat = $row["category"];
				$req_date = $row["last_day"];
				$attachment = $row["file"];

				$full_name = $row["full_name"];
				$mobile = $row["mobile"];
				$email = $row["email"];
				$address = $row["address"];
			}
		}
	}


	if(isset($_POST['submit'])){

		$sql = "SELECT requester_id FROM request WHERE id = '$request_id' ";
		$result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $requester_id = $row['requester_id'];

		$donation_details = $_POST['donate_details'];
		
		$confirmed_date =date('Y-m-d');

		$insert="INSERT INTO `Donation` (request_id, requester_id, details, donor_id, confirmed_date) VALUES ( '$request_id', '$requester_id', '$donation_details', '$donor_id', '$confirmed_date')";

		$query = mysqli_query($con, $insert) or die(mysqli_error($con));
		if($query == 1){
				echo '<script>alert("Donation Successful !")
                window.location.href = "./donorRequestsView.php";
              </script>';
        
		}
		else{
			echo '<script>alert("Donation Unsuccessful !")
              window.location.href = "./donorRequestsView.php";
            </script>';
		}

    mysqli_close($con);
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
      <?php
        if(isset($_COOKIE['message'])){
          if($_COOKIE['message']=="Message Send Successfully."){
            echo '<div class="alert alert-success alert-dismissible fade show border border-success" role="alert">'.$_COOKIE['message'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top:8px">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
          }else{
            echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" role="alert">'.$_COOKIE['message'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top:8px">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
          }
        };
      ?>
    </div>
    <div class="container flex-container">
      
      <div class="flex-item-right">
        <h4 class="section-title">Request details</h4>
        
        <form action="" method="POST">
          <div>
            <div class="row">
              <div>
                <div class="form-group">
                  <label for="inputFirstName" class="form-label">Title</label>
                  <input type="text" class="form-control" name="Req_Title" id="Req_Title" placeholder="Requester title" value="<?php echo (isset($req_title))?$req_title:'';?>" readonly="" >
                </div>
              </div>
              <div>
                <div class="form-group">
                  <label for="inputFirstName" class="form-label">details</label>
                  <textarea class="form-control" name="Req_details" id="Req_details" cols="30" rows="7" placeholder="Req details" readonly="" ><?php echo (isset($req_details))?$req_details:'';?></textarea>
                </div>
              </div>
              <div class="mb-3" style="display: flex;">
                <div  style="width: 100%;">
                  <label for="inputNIC" class="form-label">Category</label>
                  <input type="text" class="form-control" name="Req_Cat" id="Req_Cat" placeholder="Category" value="<?php echo (isset($req_cat))?$req_cat:'';?>" readonly>
                </div>
                <div style="width: 50px;"></div>
                <div  style="width: 100%;">
                  <label for="inputNIC" class="form-label">Attachments</label><br>
                  <button type="button"  style="width:60%" class="btn btn-info" name="download" id="download" onclick="document.getElementById('link').click()">
										<i class="fa-solid fa-download"></i> &nbsp;&nbsp;DOWNLOAD
                  </button>
                  <a  href="file.doc" download hidden></a>
									<?php echo '<a id="link" href="../Upload/'.$attachment.'" download hidden></a>'; ?>
                </div>
              </div>
              <div>
                <div class="form-group">
                  <label for="inputFirstName" class="form-label">Ending Date</label>
                  <input type="text"  name="Req_Date" id="Req_Date"  class="form-control" placeholder="Date" value="<?php echo (isset($req_date))?$req_date:'';?>" readonly>
                </div>
              </div>
              <?php if($usertype == "donor") {?> 
              <div style="background-color:#fae9cd; height: 250px; padding: 20px; border-radius: 5px; margin-top:20px">
                <div>
                  <div class="form-group">
                    <label for="inputFirstName" class="form-label">What can you Donate</label>
                    <textarea class="form-control" name="donate_details" id="donate_details" cols="20" rows="3" placeholder="details" required=""></textarea>
                  </div>
                </div>
                <div>
                  <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-warning">DONATE</button>
                  </div>
                </div>
              </div>
              <?php }; ?>
            </div>
          </div>
        </form>
      </div>
      <div class="flex-item-right">
        <h4 class="section-title">Requester's details</h4>
        <form action="" method="POST">
          <div>
            <div class="row">
              <div>
                <div class="form-group">
                  <label for="inputFirstName" class="form-label">Name</label>
                  <input type="text" class="form-control" placeholder="Full name" value="<?php echo (isset($full_name))?$full_name:'';?>" readonly="">
                </div>
              </div>
              <div>
                <div class="form-group">
                  <label for="inputFirstName" class="form-label">Mobile</label>
                  <input type="text" class="form-control" placeholder="Mobile" value="<?php echo (isset($mobile))?$mobile:'';?>" readonly="">
                </div>
              </div>
              <div>
                <div class="form-group">
                  <label for="inputFirstName" class="form-label">Email</label>
                  <input type="text" class="form-control" placeholder="Email" value="<?php echo (isset($email))?$email:'';?>" readonly="">
                </div>
              </div>
              <div>
                <div class="form-group">
                  <label for="inputFirstName" class="form-label">Address</label>
                  <input type="text" class="form-control" placeholder="Address" value="<?php echo (isset($address))?$address:'';?>" readonly="">
                </div>
              </div>
            </div>
          </div>
        </form>
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