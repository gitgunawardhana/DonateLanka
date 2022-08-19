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
    $usertype = $_SESSION["usertype"];
  }

  if ($_SESSION["usertype"] == "requester"){
    header("location:./Requester/requesterHome.php");
  }elseif ($_SESSION["usertype"] == "donor"){
    header("location:./Donor/donorHome.php");
  }elseif ($_SESSION["usertype"] == "authorizer"){
    header("location:./Authorizer/authorizerHome.php");
  }

  
  // get next donor id - start
  $sql_get_count = "SELECT MAX(id) FROM donor";
  $result_get_count = mysqli_query($con, $sql_get_count);
  $row_info = $result_get_count->fetch_assoc();
  $next_img_id = $row_info['MAX(id)'] + 1;
  // get next donor id - end

  if(isset($_POST['submit'])){

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $nic = $_POST['nic'];
    $address = $_POST['address'];
    $username = $_POST['uname'];
    $password = $_POST['psw'];
    $Cpassword = $_POST['cpsw'];
    $occupation = $_POST['occupation'];
    $blood_group = $_POST['bgroup'];

    $profilePicture = $_FILES["profilePicture"]["name"];
    $dst = "./Upload/Avatar/Donor/".$next_img_id.$profilePicture;
    $dst_db = "Upload/Avatar/Donor/".$next_img_id.$profilePicture;

    move_uploaded_file($_FILES['profilePicture']['tmp_name'], $dst);

    if($password != $Cpassword){
      //$errpw = "Password Not Matched !";
      echo '<script>alert("Password Not Matched !")</script>';
    }else{
      $password = password_hash($password, PASSWORD_DEFAULT);
      $insert1="INSERT INTO `donor` (nic, first_name, last_name, gender, age, profile_picture, blood_group, mobile, email, address, occupation, username, password) VALUES ('$nic', '$first_name', '$last_name', '$gender', '$age', '$dst_db', '$blood_group', '$mobile', '$email', '$address', '$occupation', '$username', '$password')";

      $query = mysqli_query($con, $insert1) or die(mysqli_error($con));
      if($query == 1){
        setcookie('message', "Registration Successful !", time()+3);
        header("location:./registrationDonor.php");
        echo '<script>alert("Registration Successful !")</script>';
      }
      else{
        setcookie('message', "Registration Unsuccessful !", time()+3);
        echo '<script>alert("Registration Unsuccessful !")</script>';
        header("location:./registrationDonor.php");
      }

      mysqli_close($con);
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
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./index.php"><?php if($_SESSION["usertype"] == "admin"){ ?>Dashboard<?php }else {?>Home<?php } ?></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php if($_SESSION["usertype"] == "admin") {?> Add User <?php }elseif($_SESSION["usertype"] == "donor") {?> Register <?php }else {?> Register <?php } ?>
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
            <?php if($_SESSION['usertype'] != "user"){ ?>
              <a class="nav-link" href="./logout.php">Logout</a>
            <?php }else{ ?>
              <a class="nav-link" href="./login.php">Login</a>
            <?php } ?>
          </li>
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
    <div class="cst-content">
    <?php
      if(isset($_COOKIE['message'])){
        echo '<div class="alert alert-success alert-dismissible fade show border border-success" role="alert">'.$_COOKIE['message'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top:8px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        // unset($_COOKIE['message']);
      }
    ?>
    <h2 style="padding-bottom: 20px;"><b>Donor Registration</b></h2>
    <form action="#" method="POST" enctype="multipart/form-data">
      <div class="mb-3" style="display: flex;">
        <div style="width: 100%;">
          <label for="inputFirstName" class="form-label">First Name</label>
          <input type="text" class="form-control" id="inputFirstName" name="first_name">
        </div>
        <div style="width: 50px;"></div>
        <div style="width: 100%;">
          <label for="inputLastName" class="form-label">Last Name</label>
          <input type="text" class="form-control" id="inputLastName" name="last_name">
        </div>
      </div>
      <div class="mb-3" style="display: flex;">
        <div class="col-xxs-12 col-xs-6 mt alternate"  style="width: 100%;">
          <div class="input-field">
            <label class="form-label" for="date-end">Gender:</label>
            <div  style="margin-left: 20px;">
            <input class="form-check-input" type="radio" name="gender" id="male" value="Male" checked>
            <label class="form-check-label" >
              Male &nbsp;&nbsp;&nbsp;
            </label>
            <input class="form-check-input" type="radio" name="gender" id="female" value="Female">
            <label class="form-check-label">
              Female
            </label>
            </div>
          </div>
        </div>
        <div style="width: 50px;"></div>
        <div  style="width: 100%;">
          <label for="inputNIC" class="form-label">NIC</label>
          <input type="text" class="form-control" id="inputNIC" name="nic" maxlength="12" required>
          <div id="nicHelp" class="form-text"><label id="error_nic" style="color: red;"></label></div>
        </div>
      </div>
      <div class="mb-3" style="display: flex;">
        <div style="width: 100%;">
          <label for="inputAge" class="form-label">Age</label>
          <input type="number" class="form-control" id="inputAge" name="age" required>
        </div>
        <div style="width: 50px;"></div>
        <div style="width: 100%;">
          <label for="inputBloodGroup" class="form-label">Blood Group</label>
          <input type="text" class="form-control" id="inputBloodGroup" name="bgroup">
        </div>
      </div>
      <div class="mb-3" style="display: flex;">
        <div style="width: 100%;">
          <label for="inputMobile" class="form-label">Mobile</label>
          <input type="phone" class="form-control" id="inputMobile" aria-describedby="mobileHelp" name="mobile" maxlength="10" required>
          <div id="mobileHelp" class="form-text">We'll never share your mobile number with anyone else.<br><label id="error_mobile" style="color: red;"></label></div>
        </div>
        <div style="width: 50px;"></div>
        <div style="width: 100%;">
          <label for="inputEmail" class="form-label">Email</label>
          <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" name="email" required>
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.<br><label id="error_email" style="color: red;"></label></div>
        </div>
      </div>
      <div class="mb-3">
        <label for="inputAddress" class="form-label">Address</label>
        <input type="text" class="form-control" id="inputAddress" name="address" required>
      </div>
      <div class="mb-3">
        <label for="inputOccupation" class="form-label">Occupation</label>
        <input type="text" class="form-control" id="inputOccupation" name="occupation" required>
      </div>
      <div class="mb-3" style="display: flex;">
        <div style="width: 100%;">
        <label for="inputUsername" class="form-label">Username</label>
        <input type="text" class="form-control" id="inputUsername" name="uname" required>
        </div>
        <div style="width: 50px;"></div>
        <div style="width: 100%;">
          <label class="form-label">Profile Picture</label>
          <input type="file" class="form-control" placeholder="Upload your image" name="profilePicture">
        </div>
      </div>
      <div class="mb-3" style="display: flex;">
        <div style="width: 100%;">
          <label class="form-label">Password</label>
          <input type="password" class="form-control"  name="psw" required>
        </div>
        <div style="width: 50px;"></div>
        <div style="width: 100%;">
          <label class="form-label">Confirm Password</label>
          <input type="password" class="form-control"  name="cpsw" required>
        </div>
      </div>
      <button type="submit" class="btn btn-primary container-fluid" style="background-color: #F18259; height: 50px;"  name ="submit" value="Create Account">Create Account</button>
    </form>
  </div>
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