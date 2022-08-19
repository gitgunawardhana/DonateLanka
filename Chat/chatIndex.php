<?php

  session_start();
	include_Once('../config.php');

  if (empty($_SESSION)) {
    $usertype = "user";
    $_SESSION["usertype"] = "user";
  }elseif ($_SESSION["usertype"] == "user") {
    $usertype = "user";
  }

  if ($_SESSION["usertype"] == "user"){
    header("location:../index.php");
  }elseif ($_SESSION["usertype"] == "authorizer"){
    header("location:../Authorizer/authorizerHome.php");
  }elseif ($_SESSION["usertype"] == "admin"){
    header("location:../Admin/adminHome.php");
  }

	$req_nic = $_SESSION['nic'];
	$usertype = $_SESSION['usertype'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DONATE LANKA</title>
  
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
	<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
	<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
	<!-- <script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script> -->
	<!-- <link rel="shortcut icon" href="favicon.ico"> -->
	<!-- <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'> -->
	<script src="../js/modernizr-2.6.2.min.js"></script>	

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

  <style>

    #myModal{
      z-index: 10 !important;
    }

    .modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

	.chat_message_area
	{
		position: relative;
		width: 100%;
		height: auto;
		background-color: #FFF;
		border: 1px solid #CCC;
		border-radius: 3px;
		padding: 10px;
	}

  .table-striped .label{
    padding: 5px;
    color: white;
    border-radius: 5px;
    background-color: #44B432;
  }

  .table-striped .label-danger{
    border-radius: 5px;
    background-color: #FF342A;
    padding: 5px;
  }

  .table-striped th {
    background-color: #f1815934;
  }

  .close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
  }

  .modal-content .user_dialog{
    margin: 20px 0px 0px 0px;
    width: 100%;
  }
  .modal-backdrop .fade .in {
    z-index: 0 !important;
  }
  .modal-backdrop .fade .show {
    z-index: 0 !important;
  }
  .modal-backdrop .fade .show {
    z-index: 0 !important;
  }
	</style> 
</head>
<body>

  <!-- navbar -->
  <nav class="navbar navbar-expand-lg shadow-sm fixed-top" style="background-color: white;">
    <div class="container-fluid">
      <a class="navbar-brand" <?php if($usertype == "admin") {?>  href="../Admin/adminHome.php" <?php }elseif($usertype == "requester") {?> href="../Requester/requesterHome.php" <?php }elseif($usertype == "donor") {?> href="../Donor/donorHome.php"  <?php }elseif($usertype == "authorizer") {?> href="../Authorizer/authorizerHome.php" <?php }else {?> href="../index.php" <?php } ?>> 
        <h2 style="font-weight:600; color: #F18259;">DONATE LANKA</h2>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0" <?php if($_SESSION['usertype'] != "user"){ ?> style="margin-right: 20px;" <?php } ?>>
          <?php if($usertype == "donor") {?> 
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../Donor/donorHome.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../Donor/donorSearchRequests.php">Search Request</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../Donor/donorConfirmedDonations.php">Confirmed Donations</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../contact.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../about.php">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../logout.php">Logout</a>
            </li>
          <?php }else if($usertype == "authorizer") {?> 
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../Authorizer/authorizerHome.php">Dashboard</a>
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
              <a class="nav-link active" aria-current="page" href="../contact.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../about.php">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../logout.php">Logout</a>
            </li>
          <?php } else {?> 
            <li class="nav-item">
              <a class="nav-link" href="../Requester/requesterHome.php">
                Dashboard
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Request
              </a>
              <ul class="nav-item dropdown-menu dropdown-menu-light shadow-sm" aria-labelledby="navbarDarkDropdownMenuLink">
                <li><a class="nav-link" href="../Requester/requestForm.php">Create Request</a></li>
                <li><a class="nav-link" href="../viewRequest.php">View Request</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./chatIndex.php">
                Chat
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
          <?php } ?>          
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
    <!-- <div class="container col-md-8 text-center heading-section">
      <h3>Admin</h3>
      <p>Sample test Sample test Sample test Sample test Sample test Sample test Sample test Sample test</p>
    </div> -->
    <!-- <hr style="height:3px; width:100px; background-color:#FF6A33; color:#FF6A33; margin: auto;"> -->
    
    <br />
    <br />
    <div class="row">
      <div class="col-md-2 col-sm-3">
        <input type="hidden" id="is_active_group_chat_window" value="no" />
      </div>
    </div>
    <div class="table-responsive">
      <div id="user_details" style="overflow-y: scroll;"></div>
      <!-- <div class="user_model_details " id="user_model_details"></div> -->
      <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="padding: 0px;">
          <button type="button" class="close" data-dismiss="modal" style="z-index: 1;">&times;</button>
        <!-- </div> -->
        <div class="modal-body">
          <div class="user_model_details " id="user_model_details"></div>
        </div>
      </div>
      
    </div>
  </div>
    </div>
    <br />
    <br />
  </div>

  <script>  
    $(document).ready(function(){

      fetch_user();

      setInterval(function(){
        update_last_activity();
        fetch_user();
        update_chat_history_data();
      }, 1000);

      function fetch_user()
      {
        $.ajax({
          url:"fetch_user.php",
          method:"POST",
          success:function(data){
            $('#user_details').html(data);
          }
        })
      }

      function update_last_activity()
      {
        $.ajax({
          url:"update_last_activity.php",
          success:function()
          {

          }
        })
      }

      function make_chat_dialog_box(to_user_id, to_user_name)
      {
        var modal_content = '<div id="user_dialog_'+to_user_id+'" class="modal-content user_dialog" title="You have chat with '+to_user_name+'"><b>You have chat with '+to_user_name+'</b>';
        modal_content += '<div style="height:300px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:20px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
        modal_content += fetch_user_chat_history(to_user_id);
        modal_content += '</div>';
        modal_content += '<div class="form-group">';
        modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message"></textarea>';
        modal_content += '</div><div class="form-group" align="right">';
        modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
        $('#user_model_details').html(modal_content);
      }

      $(document).on('click', '.start_chat', function(){
        var to_user_id = $(this).data('touserid');
        var to_user_name = $(this).data('tousername');
        make_chat_dialog_box(to_user_id, to_user_name);
        $("#user_dialog_"+to_user_id).dialog({
          autoOpen:false,
          width:400
        });
        $('#user_dialog_'+to_user_id).dialog('open');
        
      });

      $(document).on('click', '.send_chat', function(){
        var to_user_id = $(this).attr('id');
        var chat_message = $('#chat_message_'+to_user_id).val();
        $.ajax({
          url:"insert_chat.php",
          method:"POST",
          data:{to_user_id:to_user_id, chat_message:chat_message},
          success:function(data)
          {
            //$('#chat_message_'+to_user_id).val('');
            var element = $('#chat_message_'+to_user_id).emojioneArea();
            element[0].emojioneArea.setText('');
            $('#chat_history_'+to_user_id).html(data);
          }
        })

        // $('#chat_message_'+to_user_id).value="";
         $('#chat_message_'+to_user_id).val('');
      });

      function fetch_user_chat_history(to_user_id)
      {
        $.ajax({
          url:"fetch_user_chat_history.php",
          method:"POST",
          data:{to_user_id:to_user_id},
          success:function(data){
            $('#chat_history_'+to_user_id).html(data);
          }
        })
      }

      function update_chat_history_data()
      {
        $('.chat_history').each(function(){
          var to_user_id = $(this).data('touserid');
          fetch_user_chat_history(to_user_id);
        });
      }

      $(document).on('click', '.ui-button-icon', function(){
        $('.user_dialog').dialog('destroy').remove();
        $('#is_active_group_chat_window').val('no');
      });

      $(document).on('focus', '.chat_message', function(){
        var is_type = 'yes';
        $.ajax({
          url:"update_is_type_status.php",
          method:"POST",
          data:{is_type:is_type},
          success:function()
          {

          }
        })
      });

      $(document).on('blur', '.chat_message', function(){
        var is_type = 'no';
        $.ajax({
          url:"update_is_type_status.php",
          method:"POST",
          data:{is_type:is_type},
          success:function()
          {
            
          }
        })
      });

      $('#group_chat_dialog').dialog({
        autoOpen:false,
        width:400
      });

      
    });  
  </script>
  <br><br>
  <!-- container end -->

  <!-- footer -->
  <div class="footer-div">
    <?php require_once("../footer.php"); ?>
  </div>
  <!-- footer end -->
  
</body>
</html>