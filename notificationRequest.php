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
    $nics = $_SESSION["nic"];
    $user_id = $_SESSION['user_id'];
    $usertype = $_SESSION["usertype"];
  }

  if ($_SESSION["usertype"] == "user"){
    header("location:./index.php");
  }elseif ($_SESSION["usertype"] == "donor"){
    header("location:./Donor/donorHome.php");
  }elseif ($_SESSION["usertype"] == "admin"){
    header("location:./Admin/adminHome.php");
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
          <?php if($usertype == "authorizer") {?> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./Authorizer/authorizerHome.php">Dashboard</a>
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
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>
          <?php }else { ?> 
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
            <a class="nav-link active" aria-current="page" href="./updateInfoRequester.php">Update Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./Chat/chatIndex.php">Chat</a>
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
  <div class="container custom-container">
    <div class="container col-md-8 text-center heading-section">
      <h3>Notifications</h3>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto; margin-bottom: 50px;">
    
    <?php

			if ($usertype == "authorizer") {

				$sql = "SELECT request_notification.id as notification_id, request_notification.authorizer_status, request.id as request_id, request.full_name, request.mention_title, request.category FROM request INNER JOIN request_notification ON request_notification.request_id = request.id";
				if ($result = mysqli_query($con,$sql)) {
					if(mysqli_num_rows($result)>0){

						echo '<table class="cst-tbl table"><thead>
                    <tr>
                      <th class="th-col" scope="col">Request Category</th>
                      <th class="th-col" scope="col">Request Title</th>
                      <th class="th-col" scope="col">Category</th>
                      <th class="th-col" scope="col" style="text-align:center";>Action</th>
                    </tr></thead>
                    <tbody>';

						while ($row = $result->fetch_assoc()) {

							$authorizer_status = $row["authorizer_status"];
							$notification_id = $row["notification_id"];
							$full_name = $row["full_name"];
							$mention_title = $row["mention_title"]; 
							$category = $row["category"];
		
							echo '<form action="" method="POST">
                      <tr class="danger"> 
                        <td>'.$full_name.'</td>';

              if($authorizer_status == '1'){
                echo '<td><b><a href="./Authorizer/authorizerApproveRequest.php" >'.$mention_title.'</a></b></td>
                      <td>'.$category.'</a></td>
                      <td width="50px">
                        <button type="submit" class="btn btn-warning" name="auth_mark_read">Mark as Read</button>
                        <input type="hidden" name="hrid" value="'.$notification_id.'">
                      </td>';
              } else{
                echo '<td>'.$mention_title.'</td>
                      <td>'.$category.'</a></td>
                      <td width="50px">
                        <button type="submit" class="btn btn-warning" disabled>Mark as Read</button>
                        <input type="hidden" name="hrid" value="'.$notification_id.'">
                      </td>';
              }

              echo '</form></tr>';
            }	
          }else{
						echo "<br><h3 align='center'>No Notifications</h3>";
						echo "</br></br>";
					}
        }       
        echo '</tbody></table>';

			}else if($usertype == "requester"){

				$sql = "SELECT request_notification.id as notification_id, request_notification.requester_status, request.id as request_id, request.mention_title, request.category, request.explanation, request.status  FROM request INNER JOIN request_notification ON request_notification.request_id = request.id WHERE request.requester_id = '$user_id'";

				if ($result = mysqli_query($con,$sql)) {
					if(mysqli_num_rows($result)>0){

						echo '<table class="cst-tbl table"><thead>
                    <tr>
                      <th class="th-col"  scope="col">Status</th>
                      <th class="th-col"  scope="col">Request Title</th>
                      <th class="th-col"  scope="col">Description</th>
                      <th class="th-col"  scope="col">Category</th>
                      <th class="th-col"  scope="col" style="text-align:center";>Action</th>
                    </tr></thead>
                    <tbody>';
						
						while ($row = $result->fetch_assoc()) {
							$notification_status = $row["status"];
							$requester_status = $row["requester_status"];
							$notification_id = $row["notification_id"];
							$mention_title = $row["mention_title"]; 
							$explanation = $row["explanation"];
							$category = $row["category"];
		
							echo '<form action="" method="POST">
								<tr class="danger">';

                if($requester_status == '1'){
                  echo '<td>'.$notification_status.'</a></td>
                        <td><b><a href="./viewRequest.php" >'.$mention_title.'</a></b></td>
                        <td>'.$explanation.'</a></td>
                        <td>'.$category.'</a></td>
                        <td width="50px">
                          <button type="submit" class="btn btn-warning" name="req_mark_read">Mark as Read</button>
                          <input type="hidden" name="hrid" value="'.$notification_id.'">
                        </td>';
                } else if($requester_status == '0'){
                  echo '<td>'.$notification_status.'</a></td>
                        <td>'.$mention_title.'</td>
                        <td>'.$explanation.'</a></td>
                        <td>'.$category.'</a></td>
                        <td width="50px">
                          <button type="submit" class="btn btn-warning" disabled>Mark as Read</button>
                          <input type="hidden" name="hrid" value="'.$notification_id.'">
                        </td>';
                }
                echo '</form></tr>';
            }
          }else {
						echo "<br><h3 align='center'>No Notifications</h3>";
						echo "</br></br>";
					}	
        }       
        echo '</tbody></table>';
			}
		?>

    <?php
      error_reporting(0);
			if(isset($_POST['auth_mark_read'])){

				$key = $_POST['hrid'];

				$qupdate = mysqli_query($con,"UPDATE `request_notification` SET authorizer_status = '0' WHERE id = '$key'") or die("Action not successful".mysqli_connect_error());
				echo "<meta http-equiv='refresh' content='0'>";
				header("Refresh:0");
			}

			if(isset($_POST['req_mark_read'])){

				$key = $_POST['hrid'];

				$qupdate = mysqli_query($con,"UPDATE `request_notification` SET requester_status = '0' WHERE id = '$key'") or die("Action not successful".mysqli_connect_error());
				echo "<meta http-equiv='refresh' content='0'>";
				header("Refresh:0");
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