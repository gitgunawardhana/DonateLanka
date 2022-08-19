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
  }elseif ($_SESSION["usertype"] == "authorizer"){
    header("location:../Authorizer/authorizerHome.php");
  }elseif ($_SESSION["usertype"] == "admin"){
    header("location:../Admin/adminHome.php");
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
      <a class="navbar-brand" href="./donorHome.php"><h2 style="font-weight:600; color: #F18259;">DONATE LANKA</h2></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0" <?php if($_SESSION['usertype'] != "user"){ ?> style="margin-right: 20px;" <?php } ?>>
          <li class="nav-item">
            <a class="nav-link" href="./donorHome.php">Dashboard</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Donations
            </a>
            <ul class="nav-item dropdown-menu dropdown-menu-light shadow-sm" aria-labelledby="navbarDarkDropdownMenuLink">
              <li><a class="nav-link" href="./donorRequestsView.php">View Request</a></li>
              <li><a class="nav-link" href="./donorConfirmedDonations.php">Confirmed Donations</a></li>
            </ul>
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
      <h3>Search Requests</h3>
    </div>
    <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto;">
    <table class="table" style="margin-top: 40px;">
      <tr>
				<form method="POST">
          <th> <input style="width: 160px; background: #ffffff; border: none;" type="text" class="form-control" value="Search by Name:" readonly> </th>
          <th >
            <div class="col-md-12">
              <div class="form-group">
                <input style="width: 235px;" type="text" class="form-control" name="requester_name" id="requester_name" placeholder="Enter Requester's Full Name" required="">
              </div>
            </div>				  
          </th>
          <th width="50px"><button type="submit" name="sby_name" class="btn btn-info">Search</button></th>
        </form>
        <form method="POST">
          <th> <input style="width: 180px; background: #ffffff; border: none;" type="text" class="form-control" name="request_category" id="request_category" placeholder="Category" value="Search by Category:" readonly> </th>
          <th >
            <div class="col-xxs-12 col-xs-12 mt">
              <div class="input-field">
                <select style="width: 180px;" class="form-select" id="category" name="category">
                  <option>Health & Medical</option>
                  <option>Education</option>
                  <option>Human Services</option>
                  <option>Animal & Humane</option>
                  <option>Disaster Relief</option>
                </select>
              </div>
            </div>			  
          </th>
          <th width="50px"><button type="submit" name="sby_category" class="btn btn-info">Search</button></th>
        </form>
			</tr>
    </table>

		

				
		
		<?php
			if (isset($_POST['sby_name'])) {				
				$search_name = $_POST['requester_name'];
				echo search("full_name", $search_name);					
			}else if (isset($_POST['sby_category'])) {				
				$search_category = $_POST['category'];
				echo search("Category", $search_category);
			}else{				
				echo "<h3 align='center'>Please Select User Name or Category</h3>";
				echo "</br></br></br></br></br></br></br></br></br></br>";
			}

			function search($column, $value){

				include_Once('../config.php');

      
        $sql = "SELECT * FROM request WHERE $column = '$value' AND status = 'Approved'";

        if ($result = mysqli_query($con,$sql)) {
          if(mysqli_num_rows($result)>0){

            echo '<div class="fh5co-hero">
              <table class="cst-tbl table" id="result_tbl">
                <thead>
                <tr>
                  <th class="th-col" scope="col"></th>
                  <th class="th-col" scope="col">Request ID</th>
                  <th class="th-col" scope="col">Requester Name</th>
                  <th class="th-col" scope="col">Title</th>
                  <th class="th-col" scope="col">Category</th>
                  <th class="th-col" scope="col">Ending Date</th>
                  <th width="50px" class="th-col" scope="col">Donate</th>
                </tr>
                </thead>
              <tbody>';
            while ($row = $result->fetch_assoc()) {
              $request_id = $row['id'];
              $full_name = $row['full_name'];
              $mention_title = $row["mention_title"];
              $category = $row["category"];
              $last_day = $row['last_day'];

              echo '<tr class="danger">
                      <td> </td>  
                      <td>'.$request_id.'</td> 
                      <td>'.$full_name.'</td>
                      <td>'.$mention_title.'</td> 
                      <td>'.$category.'</td>
                      <td>'.$last_day.'</td>
                      <td width="50px"><input type="button" onclick="funcEdit()" name="donate" class="btn btn-warning" value="Donate"></td>
                    </tr>';
            }
          }else{
            echo "<br><h3 align='center'>No Data</h3>";
            echo "<br><br><br><br><br><br><br><br><br>";
          }
        }
				echo '</tbody></table></div>';
			}
		?>

  </div>
  <!-- container end -->

  
    <script type="text/javascript">
			function funcEdit(){

				var rowVal="";
				var myTable = document.getElementById('result_tbl');
				myTable.addEventListener('click', function (e) {
					var button = e.target;
					var cell = button.parentNode;
					var row = cell.parentNode;
					var Cells = row.getElementsByTagName("td");
					rowVal = Cells[1].innerText;

					document.cookie='request_id='+ rowVal; 
					document.location.href='./donationView.php';

				}, false);
			}
		</script>
  
  




  <!-- footer -->
  <div class="footer-div">
    <?php require_once("../footer.php"); ?>
  </div>
  <!-- footer end -->

  
</body>
</html>