<?php
	include_Once('./config.php');

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
    $req_nic = $_SESSION['nic'];
  }

  if ($_SESSION["usertype"] == "user"){
    header("location:./index.php");
  }elseif ($_SESSION["usertype"] == "donor"){
    header("location:./Donor/donorRequestsView.php");
  }

  if(isset($_SESSION["approvedUser"])){
    if($_SESSION["approvedUser"]=="N"){
      header("location:./Authorizer/authorizerHome.php");
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
            <a class="nav-link active" aria-current="page" href="./generateReports.php">Generate Reports</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>
          <?php }elseif($usertype == "requester"){ ?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Requester/requesterHome.php">Dashboard</a>
          </li>         
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Request
            </a>
            <ul class="nav-item dropdown-menu dropdown-menu-light shadow-sm" aria-labelledby="navbarDarkDropdownMenuLink">
              <li><a class="nav-link" href="./Requester/requestForm.php">Create Request</a></li>
              <li><a class="nav-link" href="./viewRequest.php">View Request</a></li>
            </ul>
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
          <?php }else {?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Authorizer/authorizerHome.php">Dashboard</a>
          </li>           
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Request
            </a>
            <ul class="nav-item dropdown-menu dropdown-menu-light shadow-sm" aria-labelledby="navbarDarkDropdownMenuLink">
              <li><a class="nav-link" href="./addRequestAdminAuthorizer.php">Create Request</a></li>
              <li><a class="nav-link" href="./viewRequest.php">View Request</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./feedback.php">Feedback</a>
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
  
  <!-- container -->
  <div class="container-fluid custom-container">
    <div class="container col-md-8 text-center heading-section">
      <h3>View Requests</h3>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto;">

    <?php

    
		if ($usertype == "requester") {
			loadData("SELECT * FROM request WHERE requester_id = '$user_id' ");
		}
		else {
			loadData("SELECT * FROM request WHERE status= 'Approved'");
		}

    function loadData($query){
      include ('./config.php');

			$sql = $query;
			if ($result = mysqli_query($con,$sql)) {
				if(mysqli_num_rows($result)>0){

					echo '<table class="cst-tbl table" style="margin-top:'.'50px'.';">
                  <thead>
                    <tr>
                        <th class="th-col" scope="col">REQUIREMENT</th>
                        <th class="th-col" scope="col">EXPLAIN REQUIREMENT</th>
                        <th class="th-col" scope="col">CATEGORY</th>
                        <th class="th-col" scope="col">DATE</th>
                        <th class="th-col" scope="col">DOCUMENT</th>
                        <th class="th-col" scope="col">STATUS</th>
                        <th class="th-col" scope="col" colspan="2" style="text-align: center;">Action</th>
                    </tr>
                  </thead>
                <tbody>';

					while ($row = $result->fetch_assoc()) {

            $request_id = $row["id"];
						$mention_title = $row["mention_title"];
						$explanation = $row["explanation"];
						$category = $row["category"];
						$date = $row["last_day"]; 
						$attachment = $row["file"];
						$status = $row["status"];

						echo '<tr class="danger"> 
                      <td>'.$mention_title.'</td> 
                      <td>'.$explanation.'</td> 
                      <td>'.$category.'</td>
                      <td>'.$date.'</td>
                      <td><a href="./Upload/'.$attachment.'" target="_blank" >'.$attachment.'</a></td>
                      <td>'.$status.'</td>
                      <td width="40px"><form method="POST" action="#"><button onClick=\'javascript:return confirm("Are you sure to delete this request.");\' type="submit" class="btn btn-danger" name="delete">Delete</button><input type="hidden" name="hid" value="'.$request_id.'"></form></td>
                  </tr>';

          }	
				}else
        {
          echo "<br><h3 align='center'>No Requests</h3>";
          echo "</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>";
        }
      }   
      echo '</tbody></table>';
    }

    error_reporting(0); 
    if(isset($_POST['delete'])){
				
			

			$key = $_POST['hid'];
			$qdelete = mysqli_query($con,"DELETE FROM `request` WHERE id = '$key'") or die("Action not successful".mysqli_connect_error());

			$qdelete2 = mysqli_query($con,"DELETE FROM `request_notification` WHERE request_id = '$key'") or die("Action not successful".mysqli_connect_error());

			echo "<meta http-equiv='refresh' content='0'>";
			header("Refresh:0");
			
			//else{
			///	$qupdate = mysqli_query($con,"DELETE FROM `tbldonor` WHERE nic = '$key'") or die("Action not successful".mysql_error());
			//	header("Refresh:0");
			//}
		}

		?>
    
  </div>
  <!-- container end -->

  
  <!-- footer -->
  <div class="footer-div">
    <?php require_once("./footer.php"); ?>
  </div>
  <!-- footer end -->
  

  


  
</body>
</html>