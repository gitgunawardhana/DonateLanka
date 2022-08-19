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
    $user_id = $_SESSION["user_id"];
    $usertype = $_SESSION["usertype"];
  }

  if ($_SESSION["usertype"] == "user"){
    header("location:./index.php");
  }elseif ($_SESSION["usertype"] == "authorizer"){
    header("location:./updateInfoAuthorizer.php");
  }elseif ($_SESSION["usertype"] == "donor"){
    header("location:./updateInfoDonor.php");
  }

	if ($logtype == "requester") {
		$sql = "SELECT * FROM requester WHERE id = '$user_id'";
		$result = mysqli_query($con, $sql);

		while($row=mysqli_fetch_assoc($result)){
			$first_name = $row["first_name"];
			$last_name = $row["last_name"];
			$nic = $row["nic"];
			$age = $row["age"];
      $gender = $row['gender'];
			$phone = $row["mobile"];
			$email = $row["email"];
			$address = $row["address"];
			$occu = $row["occupation"];
		}
	}

	if(isset($_POST['submit'])){

		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
		$age = $_POST['age'];
		$gender = $_POST['gender'];
		$nic = $_POST['nic'];
		$address = $_POST['address'];
		$occupation = $_POST['occupation'];

    $insert1 = "UPDATE `requester` SET nic = '$nic' ,first_name='$first_name',last_name='$last_name',gender='$gender',age='$age',mobile='$mobile',email='$email',address='$address',occupation='$occupation' WHERE id='$user_id'";

    $query = mysqli_query($con, $insert1) or die(mysqli_error($con));

    if($query == 1){		
        
      if($usertype == "requester"){
        echo '<script type="text/javascript">
        alert("Update Successful !");
        window.location.href = "./Requester/requesterHome.php";</script>';
      }else {
        echo '<script type="text/javascript">
        alert("Update Successful !");
        window.location.href = "./Admin/AdminHome.php";</script>';
      }
    }
    else{
      echo '<script>alert("Registration Unsuccessful !")</script>';
    }

    mysqli_close($con);

	}
	
	if(isset($_POST['back'])){
		if($usertype == "requester"){
			echo '<script type="text/javascript">window.location.href = "./Requester/requesterHome.php";</script>';
		}else {
			echo '<script type="text/javascript">window.location.href = "./Admin/adminManageUser.php";</script>';
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
          <?php if($usertype == "admin") {?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Admin/adminHome.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Admin/adminManageUser.php">Manage User</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>
          <?php }else {?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Requester/requesterHome.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./changePassword.php">Change Password</a>
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
        echo '<div class="alert alert-success alert-dismissible fade show border border-success" role="alert">'.$_COOKIE['message'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top:8px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        // unset($_COOKIE['message']);
      }
    ?>
    <h2 style="padding-bottom: 20px;"><b><?php if($_SESSION["usertype"] == "admin"){ ?>View Requester Details<?php }else {?>Update Requester Details<?php } ?></b></h2>
    <form action="#" method="POST">
      <div class="mb-3" style="display: flex;">
        <div style="width: 100%;">
          <label for="inputFirstName" class="form-label">First Name</label>
          <input type="text" class="form-control" id="inputFirstName" name="first_name" value="<?php echo $first_name;  ?>" <?php if($_SESSION["usertype"] == "admin"){ ?> disabled <?php } ?>>
        </div>
        <div style="width: 50px;"></div>
        <div style="width: 100%;">
          <label for="inputLastName" class="form-label">Last Name</label>
          <input type="text" class="form-control" id="inputLastName" name="last_name" value="<?php echo $last_name; ?>" <?php if($_SESSION["usertype"] == "admin"){ ?> disabled <?php } ?>>
        </div>
      </div>
      <div class="mb-3" style="display: flex;">
        <div class="col-xxs-12 col-xs-6 mt alternate"  style="width: 100%;">
          <div class="input-field">
            <label class="form-label" for="date-end">Gender:</label>
            <div  style="margin-left: 20px;">
            <input class="form-check-input" type="radio" name="gender" id="male" value="Male" <?php if($gender == "Male"){ ?> checked <?php } ?> <?php if($_SESSION["usertype"] == "admin"){ ?> disabled <?php } ?>>
            <label class="form-check-label" >
              Male &nbsp;&nbsp;&nbsp;
            </label>
            <input class="form-check-input" type="radio" name="gender" id="female" value="Female" <?php if($gender == "Female"){ ?> checked <?php } ?> <?php if($_SESSION["usertype"] == "admin"){ ?> disabled <?php } ?>>
            <label class="form-check-label">
              Female
            </label>
            </div>
          </div>
        </div>
        <div style="width: 50px;"></div>
        <div  style="width: 100%;">
          <label for="inputNIC" class="form-label">NIC</label>
          <input type="text" class="form-control" id="inputNIC" name="nic" maxlength="12" value="<?php echo $nic;  ?>" required <?php if($_SESSION["usertype"] == "admin"){ ?> disabled <?php } ?>>
          <div id="nicHelp" class="form-text"><label id="error_nic" style="color: red;"></label></div>
        </div>
      </div>
      <div class="mb-3" style="display: flex;">
        <div style="width: 100%;">
          <label for="inputAge" class="form-label">Age</label>
          <input type="number" class="form-control" id="inputAge" name="age" value="<?php echo $age; ?>" required <?php if($_SESSION["usertype"] == "admin"){ ?> disabled <?php } ?>>
        </div>
        <div style="width: 50px;"></div>
        <div style="width: 100%;">
          <label for="inputOccupation" class="form-label">Occupation</label>
          <input type="text" class="form-control" id="inputOccupation" name="occupation" value="<?php echo $occu; ?>" required <?php if($_SESSION["usertype"] == "admin"){ ?> disabled <?php } ?>>
        </div>
      </div>
      <div class="mb-3" style="display: flex;">
        <div style="width: 100%;">
          <label for="inputMobile" class="form-label">Mobile</label>
          <input type="phone" class="form-control" id="inputMobile" aria-describedby="mobileHelp" name="mobile" maxlength="10" value="<?php echo $phone; ?>" required <?php if($_SESSION["usertype"] == "admin"){ ?> disabled <?php } ?>>
          <div id="mobileHelp" class="form-text">We'll never share your mobile number with anyone else.<br><label id="error_mobile" style="color: red;"></label></div>
        </div>
        <div style="width: 50px;"></div>
        <div style="width: 100%;">
          <label for="inputEmail" class="form-label">Email</label>
          <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" name="email" value="<?php echo $email; ?>" required <?php if($_SESSION["usertype"] == "admin"){ ?> disabled <?php } ?>>
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.<br><label id="error_email" style="color: red;"></label></div>
        </div>
      </div>
      <div class="mb-3">
        <label for="inputAddress" class="form-label">Address</label>
        <input type="text" class="form-control" id="inputAddress" name="address" value="<?php echo $address; ?>" required <?php if($_SESSION["usertype"] == "admin"){ ?> disabled <?php } ?>>
      </div>
      <button type="submit" class="btn btn-primary container-fluid" style="background-color: #000; height: 50px;"  name ="back" value="Back">Back</button>
      <?php if($usertype != "admin") {?>
      <button type="submit" class="btn btn-primary container-fluid" style="background-color: #F18259; height: 50px; margin-top:20px;"  name ="submit" value="Update">Update</button>
      <?php } ?>
    </form>
  </div>

  <script>
    $("#inputNIC").keyup(function(){
        var email = $("#inputNIC").val();
        
        if(email.length>10){
          if(!/[0-9]{12}/.test(email)){
            $("#error_nic").text(email+" is not a valid nic");
            email.focus;
          }else{
            $("#error_nic").text("");
          }
        }else{
          if(!/[0-9]{9}[v]/.test(email)){
            $("#error_nic").text(email+" is not a valid nic");
            email.focus;
          }else{
            $("#error_nic").text("");
          }
        }
    });
    
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
    
    $("#inputMobile").keyup(function(){
        var email = $("#inputMobile").val();
        var filter = /[0][0-9]{9}/;
        if (!filter.test(email)) {
        //alert('Please provide a valid email address');
        $("#error_mobile").text(email+" is not a valid mobile number");
        email.focus;
        //return false;
      } else {
        $("#error_mobile").text("");
      }
    });
  </script>

  <!-- form section end -->

  <!-- footer -->
  <div class="footer-div">
    <?php require_once("./footer.php"); ?>
  </div>
  <!-- footer end -->
  
  
</body>
</html>