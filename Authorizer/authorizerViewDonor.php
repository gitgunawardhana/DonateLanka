<?php
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
                Donations
              </a>
              <ul class="nav-item dropdown-menu dropdown-menu-light shadow-sm" aria-labelledby="navbarDarkDropdownMenuLink">
                <!-- <li><a class="nav-link" href="#">View Requests</a></li> -->
                <li><a class="nav-link" href="./authorizerConfirmedDonations.php">Confirmed Donations</a></li>
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
  <div class="container custom-container">
    <div class="container col-md-8 text-center heading-section">
      <h3>Search Donor</h3>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto;">
    <table class="table" style="margin-top: 40px;">
      <tr>
        <form method="POST">
          <th width="200px" > <input style="background: #ffffff; border: none;" type="text" class="form-control" value="Search by NIC:" readonly> </th>
          <th >
            <div class="col-md-12">
              <div class="form-group">
                <input type="text" class="form-control" name="Donor_NIC" id="Donor_NIC" placeholder="Enter Donor's NIC" required="">
              </div>
            </div>				  
          </th>
          <th width="50px"><button type="submit" name="sby_nic" class="btn btn-info">Search</button></th>
        </form>
      </tr>
    </table>

		

			<?php
			
			if (isset($_POST['sby_nic'])) {
				$search_nic = $_POST['Donor_NIC'];
				echo search("SELECT * FROM donor WHERE nic = '$search_nic' ");
			}else{
				echo search("SELECT * FROM donor");
			}

			function search($query){

        include_Once('../config.php');

        $sql = $query;

        if ($result = mysqli_query($con,$sql)) {
          if(mysqli_num_rows($result)>0){

            echo '<div class="fh5co-hero">
              <table class="cst-tbl table" id="result_tbl">
                <thead>
                <tr>
                  <th class="th-col" scope="col">Full Name</th>
                  <th class="th-col" scope="col">Gender</th>
                  <th class="th-col" scope="col">Age</th>
                  <th class="th-col" scope="col">Blood Group</th>
                  <th class="th-col" scope="col">Mobile</th>
                  <th class="th-col" scope="col">Email</th>
                  <th class="th-col" scope="col">Address</th>
                  <th class="th-col" scope="col">Occupation</th>
                </tr>
                </thead>
              <tbody>';
            while ($row = $result->fetch_assoc()) {
              $first_name = $row['first_name'];
              $last_name = $row['last_name'];
              $gender = $row["gender"];
              $age = $row["age"];
              $blood_group = $row["blood_group"];
              $mobile = $row['mobile'];
              $email = $row["email"];
              $address = $row["address"];
              $occupation = $row['occupation'];

              echo '<tr class="danger">
                      <td>'.$first_name." ". $last_name .'</td>
                      <td>'.$gender.'</td> 
                      <td>'.$age.'</td>
                      <td>'.$blood_group.'</td>
                      <td>'.$mobile.'</td>
                      <td>'.$email.'</td>
                      <td>'.$address.'</td> 
                      <td>'.$occupation.'</td>
                    </tr>';
            }
          }else{
            echo "<br><h3 align='center'>No Donors</h3>";
            echo "<br><br><br><br><br><br><br><br><br>";
          }
        }
        echo '</tbody></table></div>';
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