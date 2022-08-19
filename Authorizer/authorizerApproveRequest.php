<?php
include_Once('../config.php');

	session_start();

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
  }elseif ($_SESSION["usertype"] == "admin"){
    header("location:../Admin/adminHome.php");
  }elseif ($_SESSION["usertype"] == "donor"){
    header("location:../Donor/donorHome.php");
  }
  
  if(isset($_SESSION["approvedUser"])){
    if($_SESSION["approvedUser"]=="N"){
      header("location:./authorizerHome.php");
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
      <a class="navbar-brand" href="./authorizerHome.php"><h2 style="font-weight:600; color: #F18259;">DONATE LANKA</h2></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0" <?php if($_SESSION['usertype'] != "user"){ ?> style="margin-right: 20px;" <?php } ?>>
            <li class="nav-item">
              <a class="nav-link" href="./authorizerHome.php">Dashboard</a>
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
                feedback
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
  <div class="container-fluid custom-container">
    <div class="container col-md-8 text-center heading-section">
      <h3>Pending Approval</h3>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto; margin-bottom: 50px;">

    <?php
      $sql = "SELECT request_notification.id as notification_id, request.id as request_id, request.requester_id as requester_id, request.full_name, requester.nic, request.mention_title, request.explanation, request.category, request.last_day, request.file FROM request INNER JOIN request_notification ON request.id = request_notification.request_id INNER JOIN requester ON request.requester_id= requester.id WHERE request.status ='Pending'";
			if ($result = mysqli_query($con,$sql)) {
				if(mysqli_num_rows($result)>0){

					echo '<table class="cst-tbl table">
                  <thead>
                  <tr>
                    <th class="th-col" scope="col">Full Name</th>
                    <th class="th-col" scope="col">NIC</th>
                    <th class="th-col" scope="col">Mention Request</th>
                    <th class="th-col" scope="col">Explanation</th>
                    <th class="th-col" scope="col">Category</th>
                    <th class="th-col" scope="col">Last Date</th>
                    <th class="th-col" scope="col">File</th>
                    <th class="th-col" scope="col" colspan="2" style="text-align: center;">Action</th>
                  </tr>
                  </thead>
                <tbody>';
					while ($row = $result->fetch_assoc()) {

						$request_id = $row["request_id"];
						$nic = $row["nic"];
						$full_name = $row["full_name"];
						$mention_title = $row["mention_title"]; 
						$explanation = $row["explanation"];
						$category = $row["category"];
						$last_day = $row["last_day"];
						$file = $row["file"];
						$notification_id = $row["notification_id"];

						echo '<form action="" method="POST">
                    <tr class="danger">
                      <td>'.$full_name.'</td>
                      <td>'.$nic.'</td> 
                      <td>'.$mention_title.'</td>
                      <td>'.$explanation.'</a></td>
                      <td>'.$category.'</a></td>
                      <td>'.$last_day.'</td>
                      <td><a href="../Upload/'.$file.'" target="_blank" >'.$file.'</a></td>
                
                      <td width="50px">
                        <button onClick=\'javascript:return confirm("Are you sure to approve this user.");\' type="submit" class="btn btn-warning" name="approve">Approve</button>
                        <input type="hidden" name="hrid" value="'.$request_id.'"</td>
                      <td width="50px">
                        <button onClick=\'javascript:return confirm("Are you sure to delete this user.");\' type="submit" class="btn btn-danger" name="reject">Reject</button></td>
                        <input type="hidden" name="hnotid" value="'.$notification_id.'"</td>
                    </tr>
                  </form>';
          }
          echo '</tbody></table>';	
        }else{
					echo "<br><h3 align='center'>No Requests to Approve</h3>";
					echo "</br>";
				}  
      }
		?>

		<?php
      error_reporting(0);
			if(isset($_POST['approve'])){
				$key = $_POST['hrid'];
				$authorizer_nic = $_SESSION["nic"];
        $user_id = $_SESSION["user_id"];
			
				$qupdate = mysqli_query($con,"UPDATE `request` SET Status = 'Approved', handled_by_auther_id = '$user_id' WHERE id = '$key'") or die("Action not successful".mysqli_connect_error());
				$qupdate2 = mysqli_query($con,"UPDATE `request_notification` SET requester_status = '1' WHERE id = '$notification_id'") or die("Action not successful".mysqli_connect_error());
				echo "<meta http-equiv='refresh' content='0'>";
				header("location:./authorizerApproveRequest.php");
			}
			elseif(isset($_POST['reject'])){
				$key = $_POST['hrid'];
				$authorizer_nic = $_SESSION["nic"];
				$notification_id = $_POST['hnotid'];
        $user_id = $_SESSION["user_id"];

				$qupdate = mysqli_query($con,"UPDATE `request` SET Status = 'Rejected',	handled_by_auther_id = '$user_id' WHERE id = '$key'") or die("Action not successful".mysqli_connect_error());
				$qupdate2 = mysqli_query($con,"UPDATE `request_notification` SET requester_status = '1' WHERE id = '$notification_id'") or die("Action not successful".mysqli_connect_error());
				echo "<meta http-equiv='refresh' content='0'>";
				header("location:./authorizerApproveRequest.php");
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