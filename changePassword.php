<?php
	include_Once('./config.php');
	$errpw = "";

	session_start();

  if (empty($_SESSION)) {
    $usertype = "user";
    $_SESSION["usertype"] = "user";
  }elseif ($_SESSION["usertype"] == "user") {
    $usertype = "user";
  }else{
    $logtype = $_SESSION["type"];
    $nics = $_SESSION["nic"];
    $user_id = $_SESSION['user_id'];
    $usertype = $_SESSION["usertype"];
  }

  if ($_SESSION["usertype"] == "admin"){
    header("location:./Admin/adminHome.php");
  }elseif ($_SESSION["usertype"] == "user"){
    header("location:./index.php");
  }

  if(isset($_SESSION["approvedUser"])){
    if($_SESSION["approvedUser"]=="N"){
      header("location:./Authorizer/authorizerHome.php");
    }
  }

	$tbl = null;

	if ($logtype == "authorizer") {
    $sql = "SELECT password FROM authorizer WHERE id = '$user_id'";
    $tbl = "authorizer";
  }elseif ($logtype == "donor") {
    $sql = "SELECT password FROM donor WHERE id = '$user_id'";
    $tbl = "donor";
  }elseif ($logtype == "requester") {
    $sql = "SELECT password FROM requester WHERE id = '$user_id'";
    $tbl = "requester";
  }

  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
  $count = mysqli_num_rows($result);

	$old_pw = $row['password'];

	if(isset($_POST['submit'])){

		$old_pw_frm_user = $_POST['o_password'];
		$password = $_POST['n_password'];
		$Cpassword = $_POST['cn_password'];
// if(password_verify($password, $row["password"])){
//           $user_verified = 1;
//           break;
//         }else{
//           $user_verified = 0;
//         }
		if(!password_verify($old_pw_frm_user, $old_pw)){
      setcookie('message', "Passwords Not Matched.", time()+3);
      header("location:./changePassword.php");
			// echo '<script>alert("Old Password Not Matched!")</script>';
		}else{
			if($password != $Cpassword){
        setcookie('message', "Passwords Not Matched.", time()+3);
        header("location:./changePassword.php");
				// echo '<script>alert("Passwords Not Matched!")</script>';
			}else{
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
				$qupdate = mysqli_query($con, "UPDATE $tbl SET password = '$hashedPassword' WHERE id = '$user_id'");

				if($qupdate ==1){
          setcookie('message', "Passwords Changed Successfully.", time()+3);
          header("location:./changePassword.php");
					// echo '<script>alert("Passwords Changed Successfully!")</script>';
				}else{
          setcookie('message', "Passwords Not Matched.", time()+3);
          header("location:./changePassword.php");
					// echo '<script>alert("Passwords Changed Unsuccessfully!")</script>';
				}
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
            <a class="nav-link active" aria-current="page" href="./updateInfoDonor.php">Update Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Donor/donorSearchRequests.php">Search Request</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Donor/donorConfirmedDonations.php">Confirmed Donations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>
          <?php }elseif($usertype == "authorizer"){ ?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Authorizer/authorizerHome.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./updateInfoAuthorizer.php">Update Profile</a>
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
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./updateInfoRequester.php">Update Profile</a>
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
  
  <!-- form section -->
  <div class="container custom-container">
    <?php
        if(isset($_COOKIE['message'])){
          if($_COOKIE['message']=="Passwords Changed Successfully."){
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
          
          // unset($_COOKIE['message']);
        }
      ?>
    <h2 style="padding-bottom: 20px;"><b>Change Password</b></h2>
    <form action="#" method="POST">
      <div class="mb-3">
        <label for="from">Old Password:</label>
        <input type="password" class="form-control" name="o_password" required/>
      </div>
      <div class="mb-3">
        <label for="date-end">New Password:</label>
        <input type="password" class="form-control" name="n_password" required/>
      </div>
      <div class="mb-3">
        <label for="date-end">Confirm New Password:</label>
        <input type="password" class="form-control" name="cn_password" required/>
      </div>
      <button type="submit" class="btn btn-primary container-fluid" style="background-color: #F18259; height: 50px; margin-top:20px; "  name ="submit" value="Update">Update</button>
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

  <!-- footer -->
  <div class="footer-div" style="bottom: 0;">
    <?php require_once("./footer.php"); ?>
  </div>
  <!-- footer end -->
  
</body>
</html>