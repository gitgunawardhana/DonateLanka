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

	$user_id = $_SESSION['user_id'];
	$requester_nic = $_SESSION['nic'];

	$sql = "SELECT * FROM requester WHERE id = '$user_id' ";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);
	$requester_id = $row['id'];
	$req_first_name = $row['first_name'];
	$req_last_name = $row['last_name'];
	$full_name = $req_first_name ." " . $req_last_name;

	if(isset($_POST["submit"])){
		$full_name = $full_name;
		$mention_title = $_POST['mention_title'];
		$explanation = $_POST['explanation'];
		$category = $_POST['category'];
		$last_day = $_POST['last_day'];


		$file=$_FILES["myfile"]["name"];
		$tmp_name=$_FILES["myfile"]["tmp_name"];
		$path="../Upload/".$file;
		$file1=explode(".",$file);
		$ext=$file1[1];
		$allowed=array("jpg","png","gif","pdf","wmv","pdf","zip");
    
		if(in_array($ext,$allowed)){
			move_uploaded_file($tmp_name,$path);
			$query = mysqli_query($con,"INSERT INTO request (requester_id, full_name, mention_title, explanation, category, last_day, file, status) VALUES ('$requester_id', '$full_name', '$mention_title', '$explanation', '$category', '$last_day', '$file', 'Pending')");

			if($query == 1){		

				$last_id = mysqli_insert_id($con);

				$insert1 ="INSERT INTO `request_notification` (request_id, requester_nic, authorizer_status, requester_status) VALUES ('$last_id', '$requester_nic', '1', '2')";
				$query = mysqli_query($con, $insert1) or die(mysqli_error($con));

				if($query == 1){
					echo '<script>alert("Request Sent To Authorizer!")</script>';
				}
				
			}else{
				echo '<script>alert("Unsuccessful Requested! ")</script>';
			}

		}

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
  
  <!-- form section -->
  <div class="container custom-container">
    <?php
      if(isset($_COOKIE['message'])){
        echo '<div class="alert alert-success alert-dismissible fade show border border-success" role="alert">'.$_COOKIE['message'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top:8px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        // unset($_COOKIE['message']);
      }
    ?>
    <form action="#" method="POST" enctype="multipart/form-data">
      <div style="display: flex; flex-wrap: wrap;">
      
      <div class="sec-2" style="width: 100%;">
        <h2 style="padding-bottom: 20px;"><b>Request Details</b></h2> 

        <div style="width: 100%;">
            <label for="full_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo (isset($full_name))?$full_name:'';?>" disabled>
          </div>
          <div style="width: 50px;"></div>
          <div style="width: 100%;">
            <label for="nic" class="form-label">NIC</label>
            <input type="text" class="form-control" id="nic" name="nic"  value="<?php echo (isset($requester_nic))?$requester_nic:'';?>" name="nic"  value="<?php echo (isset($requester_nic))?$requester_nic:'';?>" maxlength="12" disabled>
          </div>
        <div class="mb-3">
          <label for="inputAddress" class="form-label">Category</label>
          <select class="form-select" id="category" name="category">
            <option>Health & Medical</option>
            <option>Education</option>
            <option>Human Services</option>
            <option>Animal & Humane</option>
            <option>Disaster Relief</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Mention The Requirement</label>
          <input type="text" class="form-control" id="mention_title" name="mention_title" required/>
        </div>
        <div class="mb-3">
          <label class="form-label">Explain Your Requirement</label>
          <textarea type="text" id="explanation" name="explanation" class="form-control" cols="30" rows="5" required></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">When Is The Last Day You Need Money?</label>
          <input type="date" class="form-control" id="last_day" name="last_day" min="<?= date('Y-m-d'); ?>" required/>
        </div>
        <div class="mb-3">
          <label class="form-label " for="inputGroupFile02">Proof Documents ( Upload as a PDF)</label>
          <input type="file" class="form-control"  name="myfile">
        </div>
      </div>
      </div>
      <button type="submit" class="btn btn-primary container-fluid" style="background-color: #F18259; height: 50px;"  name ="submit" value="Create Account">Create Request</button>
      <a href="./requesterHome.php" class="btn btn-primary container-fluid" style="background-color: black; height: 50px; margin-top:10px; padding-top:15px;">Back</a>
    </form>
  </div>

  <script>
    $("#inputEmail").keyup(function(){
        var email = $("#inputEmail").val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(email)) {
        //alert('Please provide a valid email address');
        $("#error_email").text(email+" is not a valid email");
        email.focus;
        //return false;
      } else {
        $("#error_email").text("");
      }
    });
  </script>

  <!-- form section end -->
  <!-- container end -->

  <!-- footer -->
  <div class="footer-div">
    <?php require_once("../footer.php"); ?>
  </div>
  <!-- footer end -->

  
</body>
</html>

