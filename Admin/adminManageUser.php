<?php
  include_Once('../config.php');
  $selected = '';

  session_start();
  // header("Refresh:0");

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
  <div class="container custom-container">
    <div class="container col-md-8 text-center heading-section">
      <h3>Manage Users</h3>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto;">
    <table class="table" style="margin-top: 40px;">
      <tr> 
        <form action="" method="POST">
        <th>
          <select class="form-select" id="user" name="user">
            <option>Select</option>
            <option value="requester">Requester</option>
            <option value="donor">Donor</option>
            <option value="authorizer">Authorizer</option>
          </select>				  
        </th>
        <th width="50px"><button type="Submit" class="btn btn-info"  name="submit">Search</button></th>
      </form>
      </tr>
    </table>


    <?php
      if(isset($_POST['submit'])){
        if(!empty($_POST['user'])) {
          $selected = $_POST['user'];
        } 
      }
      if($selected == "requester"){

        $sql = "SELECT * FROM requester";
        if ($result = mysqli_query($con,$sql)) {
          if(mysqli_num_rows($result)>0){

            echo'<table class="cst-tbl table">
                  <thead>
										<tr>
											<th class="th-col" scope="col"></th>
                      <th class="th-col" scope="col">NIC</th>
                      <th class="th-col" scope="col">First Name</th>
                      <th class="th-col" scope="col">Last Name</th>
                      <th class="th-col" scope="col">Occupation</th>
                      <th class="th-col" scope="col">Phone</th>
                      <th class="th-col" scope="col">Address</th>
                      <th class="th-col" scope="col" colspan="2" style="text-align: center;">Action</th>
										</tr>
                  </thead>
                  <tbody>';
            while ($row = $result->fetch_assoc()) {
              $requester_id = $row["id"];
              $nic = $row["nic"];
              $first_name = $row["first_name"];
              $last_name = $row["last_name"];
              $occupation = $row["occupation"];
              $phone = $row["mobile"];
              $address = $row["address"];

              echo '<form action="" method="POST">
                      <tr class="danger"> 
                        <td></td>
                        <td>'.$nic.'</td> 
                        <td>'.$first_name.'</td> 
                        <td>'.$last_name.'</td>
                        <td>'.$occupation.'</td>
                        <td>'.$phone.'</td>
                        <td>'.$address.'</td>
                        <td width="50px">
                          <button type="submit" class="btn btn-warning" name="view">View</button>
                          <input type="hidden" name="user_id" value="'.$requester_id.'"><input type="hidden" name="type" value="requester">
                        </td>
                        <td width="50px"><button onClick=\'javascript:return confirm("Are you sure to delete this user.");\' type="submit" class="btn btn-danger" name="delete">Delete</button></td>
                      </tr>
                    </form>';
            }	
          }else {
            echo "<br><h3 align='center'>No Data</h3>";
          }
        }
        echo '</tbody>';
        echo'</table>';



			}elseif($selected == "donor"){

        $sql = "SELECT * FROM donor";
        if ($result = mysqli_query($con,$sql)) {
          if(mysqli_num_rows($result)>0){

            echo'<table class="cst-tbl table">
                  <thead>
                    <tr>
                      <th class="th-col" scope="col"></th>
                      <th class="th-col" scope="col">NIC</th>
                      <th class="th-col" scope="col">First Name</th>
                      <th class="th-col" scope="col">Last Name</th>
                      <th class="th-col" scope="col">Blood Group</th>
                      <th class="th-col" scope="col">Phone</th>
                      <th class="th-col" scope="col">Address</th>
                      <th class="th-col" scope="col">Occupation</th>
                      <th class="th-col" scope="col" colspan="2" style="text-align: center;">Action</th>
                    </tr>
                  </thead>
                <tbody>';

            while ($row = $result->fetch_assoc()) {
              $donor_id = $row["id"];
              $nic = $row["nic"];
              $first_name = $row["first_name"];
              $last_name = $row["last_name"];
              $blood_group = $row["blood_group"];
              $phone = $row["mobile"];
              $address = $row["address"];
              $occupation = $row["occupation"];

              echo '<form action="" method="POST">
                      <tr class="danger"> 
                        <td></td>
                        <td>'.$nic.'</td> 
                        <td>'.$first_name.'</td> 
                        <td>'.$last_name.'</td>
                        <td>'.$blood_group.'</a></td>
                        <td>'.$phone.'</td>
                        <td>'.$address.'</td>
                        <td>'.$occupation.'</td>
                        <td width="50px">
                          <button type="submit" class="btn btn-warning" name="view">View</button>
                          <input type="hidden" name="user_id" value="'.$donor_id.'"><input type="hidden" name="type" value="donor">
                        </td>
                        <td width="50px"><button onClick=\'javascript:return confirm("Are you sure to delete this user.");\' type="submit" class="btn btn-danger" name="delete">Delete</button></td>
                      </tr>
                    </form>';
            }	
          }else {
            echo "<br><h3 align='center'>No Data</h3>";
          }
        }
        echo '</tbody>';
        echo'</table>';
			}elseif($selected == "authorizer"){

        $sql = "SELECT * FROM authorizer WHERE Status = 'Approved'";
        if ($result = mysqli_query($con,$sql)) {
          if(mysqli_num_rows($result)>0){

            echo'<table class="cst-tbl table">
                  <thead>
                    <tr>
                      <th class="th-col" scope="col"></th>
                      <th class="th-col" scope="col">NIC</th>
                      <th class="th-col" scope="col">First Name</th>
                      <th class="th-col" scope="col">Last Name</th>
                      <th class="th-col" scope="col">Email</th>
                      <th class="th-col" scope="col">Phone</th>
                      <th class="th-col" scope="col">Occupation</th>
                      <th class="th-col" scope="col">Address Residential</th>
                      <th class="th-col" scope="col" colspan="2" style="text-align: center;">Action</th>
                    </tr>
                  </thead>
                <tbody>';
            while ($row = $result->fetch_assoc()) {
              $authorizer_id = $row["id"];
              $nic = $row["nic"];
              $first_name = $row["first_name"];
              $last_name = $row["last_name"];
              $email = $row["email"];
              $phone = $row["telephone_mobile"];
              $occupation = $row["occupation"];
              $address_residential = $row["address_residential"];

              echo '<form action="" method="POST">
                      <tr class="danger"> 
                        <td></td>
                        <td>'.$nic.'</td> 
                        <td>'.$first_name.'</td> 
                        <td>'.$last_name.'</td>
                        <td>'.$email.'</a></td>
                        <td>'.$phone.'</td>
                        <td>'.$occupation.'</td>
                        <td>'.$address_residential.'</td>
                        <td width="50px">
                          <button type="submit" class="btn btn-warning" name="view">View</button>
                          <input type="hidden" name="user_id" value="'.$authorizer_id.'"><input type="hidden" name="type" value="authorizer">
                        </td>
                        <td width="50px"><button onClick=\'javascript:return confirm("Are you sure to delete this user.");\' type="submit" class="btn btn-danger" name="delete">Delete</button></td>
                      </tr>
                    </form>';
            }
          }else {
            echo "<br><h3 align='center'>No Data</h3>";
          }	
        }
        echo '</tbody>';
        echo'</table>';
			}else {
				echo "<h3 align='center'>Please Select Valid User</h3>";
			}	
		?>


		<?php
			if(isset($_POST['view'])){
				$type = $_POST['type'];
				if($type== "requester"){
					$_SESSION["type"] = "requester";
          $_SESSION["user_id"] = $_POST['user_id'];
          echo("<script>location.href = '../updateInfoRequester.php';</script>");
          // header("Location:../updateInfoRequester.php");
          //header("Refresh:0; url=updateInfoRequester.php");
				}elseif($type == "donor"){
					$_SESSION["type"] = "donor";
          $_SESSION["user_id"] = $_POST['user_id'];
          echo("<script>location.href = '../updateInfoDonor.php';</script>");
          // header("Location:../updateInfoDonor.php");
          //header("Refresh:0; url=adminupdateinfoDonor.php");
				}else{
					$_SESSION["type"] = "authorizer";
          $_SESSION["user_id"] = $_POST['user_id'];
          echo("<script>location.href = '../updateInfoAuthorizer.php';</script>");
          // header("Location:../updateInfoAuthorizer.php");
          //header("Refresh:0; url=adminupdateinfoAuthorizer.php");
				}

			}

			if(isset($_POST['delete'])){
				$key = $_POST['user_id'];
				$type = $_POST['type'];
        

        error_reporting(0);
				if($type== "requester"){
          $sql_get_pp = mysqli_query($con,"SELECT profile_picture FROM `requester` WHERE id = '$key'");
          $profile_picture_link = mysqli_fetch_assoc($sql_get_pp);
          unlink("../{$profile_picture_link['profile_picture']}");

					$qupdate = mysqli_query($con,"DELETE FROM `requester` WHERE id = '$key'") or die("Action not successful".mysqli_connect_error());

					$qdelete2 = mysqli_query($con,"DELETE FROM `request` WHERE id = '$key'") or die("Action not successful".mysqli_connect_error());

					$qdelete2 = mysqli_query($con,"DELETE FROM `request_notification` WHERE Req_NIC = '$key'") or die("Action not successful".mysqli_connect_error());

					echo "<meta http-equiv='refresh' content='0'>";
					header("Refresh:0");
          header("location:./adminManageUser.php");
				}elseif($type == "donor"){
          $sql_get_pp = mysqli_query($con,"SELECT profile_picture FROM `donor` WHERE id = '$key'");
          $profile_picture_link = mysqli_fetch_assoc($sql_get_pp);
          unlink("../{$profile_picture_link['profile_picture']}");
          
					$qupdate = mysqli_query($con,"DELETE FROM `donor` WHERE id = '$key'") or die("Action not successful".mysqli_connect_error());
					echo "<meta http-equiv='refresh' content='0'>";
					header("Refresh:0");
          header("location:./adminManageUser.php");
				}else{
          $sql_get_pp = mysqli_query($con,"SELECT profile_picture FROM `authorizer` WHERE id = '$key'");
          $profile_picture_link = mysqli_fetch_assoc($sql_get_pp);
          unlink("../{$profile_picture_link['profile_picture']}");

					$qupdate = mysqli_query($con,"DELETE FROM `authorizer` WHERE id = '$key'") or die("Action not successful".mysqli_connect_error());
					echo "<meta http-equiv='refresh' content='0'>";
					header("Refresh:0");
          header("location:./adminManageUser.php");
				}
			}
    ?>	
    </br></br></br></br></br></br></br></br></br>
  </div>
  <!-- container end -->

  <!-- footer -->
  <div class="footer-div">
    <?php require_once("../footer.php"); ?>
  </div>
  <!-- footer end -->

  
</body>
</html>