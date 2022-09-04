<?php      
  include_Once('./config.php');

  session_start();
  if (empty($_SESSION)) {
    $usertype = "user";
    $_SESSION["usertype"] = "user";
  }elseif ($_SESSION["usertype"] == "user") {
    $usertype = "user";
  }

  if(isset($_POST['submit'])){ 
    $uname = $_POST['username'];  
    $password = $_POST['password'];
    $logtype = $_POST['usertype']; 

    $uname = stripcslashes($uname);  
    $password = stripcslashes($password);  
    $uname = mysqli_real_escape_string($con, $uname);  
    $password = mysqli_real_escape_string($con,$password);

    if ($logtype == "admin"){
      $sql = "SELECT * FROM admin WHERE username = '$uname'";
    }elseif ($logtype == "authorizer") {
      $sql = "SELECT * FROM authorizer WHERE username = '$uname'";
    }elseif ($logtype == "donor") {
      $sql = "SELECT * FROM donor WHERE username = '$uname'";
    }elseif ($logtype == "requester") {
      $sql = "SELECT * FROM requester WHERE username = '$uname'";
    }

    //$sql = "select *from tblrequester where username = '$uname' and password = '$password'";  


    $result = mysqli_query($con, $sql);  

    if(mysqli_num_rows($result)>0){
      while($row = mysqli_fetch_assoc($result)){
        if(password_verify($password, $row["password"])){
          $user_verified = 1;
          break;
        }else{
          $user_verified = 0;
        }
      }
    }
    // $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
    // $count = mysqli_num_rows($result); 

    if($user_verified == 1){

      if ($logtype == "admin"){
        $_SESSION["type"] = $logtype;
        $_SESSION["nic"] = $row['nic'];
        $_SESSION["user_id"] = $row['id'];
        $_SESSION["usertype"] = $logtype;

        if(strlen($row['username'])>11){
          $_SESSION['username'] = substr($row['username'], 0, 11)."...";
        }else{
          $_SESSION['username'] = $row['username'];
        }

        $_SESSION["profile_picture"] = $row['profile_picture'];

        setcookie('message', "Login Successful !", time()+3);        
        header("Location:./Admin/adminHome.php");
        echo '<script>alert("Login Successful !")</script>';

      }elseif ($logtype == "authorizer") {
        $_SESSION["type"] = $logtype;
        $_SESSION["nic"] = $row['nic'];
        $_SESSION["usertype"] = $logtype;
        $_SESSION['user_id'] = $row['id'];

        if(strlen($row['username'])>11){
          $_SESSION['username'] = substr($row['username'], 0, 11)."...";
        }else{
          $_SESSION['username'] = $row['username'];
        }

        $_SESSION["profile_picture"] = $row['profile_picture'];

        include_Once('./Chat/database_connection.php');
        $sub_query = "INSERT INTO login_details (user_id) VALUES ('".$row['nic']."')";
        $statement = $connect->prepare($sub_query);
        $statement->execute();
        $_SESSION['login_details_id'] = $connect->lastInsertId();

        setcookie('message', "Login Successful !", time()+3);
        header("Location:./Authorizer/authorizerHome.php");
        echo '<script>alert("Login Successful !")</script>';

      }elseif ($logtype == "donor") {
        $_SESSION['type'] = $logtype;
        $_SESSION['nic'] = $row['nic'];
        $_SESSION["usertype"] = $logtype;
        $_SESSION['user_id'] = $row['id'];

        if(strlen($row['username'])>11){
          $_SESSION['username'] = substr($row['username'], 0, 11)."...";
        }else{
          $_SESSION['username'] = $row['username'];
        }

        $_SESSION["profile_picture"] = $row['profile_picture'];

        include_Once('./Chat/database_connection.php');
        $sub_query = "INSERT INTO login_details (user_id) VALUES ('".$row['nic']."')";
        $statement = $connect->prepare($sub_query);
        $statement->execute();
        $_SESSION['login_details_id'] = $connect->lastInsertId();

        setcookie('message', "Login Successful !", time()+3);
        header("Location:./Donor/donorHome.php");
        echo '<script>alert("Login Successful !")</script>';

      }elseif ($logtype == "requester") {
        $_SESSION["type"] = $logtype;
        $_SESSION["nic"] = $row['nic'];
        $_SESSION["usertype"] = $logtype;
        $_SESSION['user_id'] = $row['id'];

        if(strlen($row['username'])>11){
          $_SESSION['username'] = substr($row['username'], 0, 11)."...";
        }else{
          $_SESSION['username'] = $row['username'];
        }

        $_SESSION["profile_picture"] = $row['profile_picture'];

        include_Once('./Chat/database_connection.php');
        $sub_query = "INSERT INTO login_details (user_id) VALUES ('".$row['nic']."')";
        $statement = $connect->prepare($sub_query);
        $statement->execute();
        $_SESSION['login_details_id'] = $connect->lastInsertId();

        setcookie('message', "Login Successful !", time()+3);
        header("Location:./Requester/requesterHome.php");
        echo '<script>alert("Login Successful !")</script>';
      }
    }else{
      $_SESSION["usertype"] = "user";
      setcookie('message', "Invalid username or password !", time()+3);
      header("location:./login.php");
      echo '<script>alert("Login Faild !")</script>';	 
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

  <style>
    body {
          background: linear-gradient(to right, rgba(255, 62, 28, 0.5) 0%, rgba(255, 140, 0, 0.5) 100%);
    }

  </style>
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
  
  <!-- form section -->
  <div class="container custom-container login-div" style="width: 500px;">
  <div class="cst-content">
    <?php
      if(isset($_COOKIE['message'])){
        if($_COOKIE['message']=='Invalid username or password !'){
          echo '<div class="alert alert-danger alert-dismissible fade show border border-danger" role="alert">'.$_COOKIE['message'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top:8px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        }else{
          echo '<div class="alert alert-success alert-dismissible fade show border border-success" role="alert">'.$_COOKIE['message'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top:8px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        }
        // unset($_COOKIE['message']);
      }
    ?>
    <h2 style="padding-bottom: 20px;"><b>Login</b></h2>
    <form action="#" method="POST">
      <div class="mb-3">
        <label for="inputUserType" class="form-label">User Type</label>
        <select class="form-select" aria-label="Default select example" id="usertype" name="usertype">
          <option value="admin">Admin</option>
          <option value="authorizer">Authorizer</option>
          <option value="donor">Donor</option>
          <option value="requester">Requester</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="inputUsername" class="form-label">Username</label>
        <input type="text" class="form-control" id="inputUsername" id="username"  name="username" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" id="password"  name="password" required>
      </div>
      <button type="submit" class="btn btn-primary container-fluid" style="background-color: #F18259; height: 50px;"  name ="submit" value="Login">Login</button>
    </form>
  </div>
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