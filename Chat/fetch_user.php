<?php

//fetch_user.php

	include('database_connection.php');

	session_start();

	$logtype = $_SESSION['usertype'];

	if ($logtype == "requester") {
		$query = "SELECT * FROM donor";
		//$query2 = "SELECT * FROM authorizer";
		$tableName1 = "Donors";
		//$tableName2 = "Authorizers";

	}else if ($logtype == "donor"){
		$query = "SELECT * FROM requester";
		//$query2 = "SELECT * FROM authorizer";
		$tableName1 = "Requesters";
		//$tableName2 = "Authorizers";
	}

	$statement = $connect->prepare($query);

	$statement->execute();

	$result = $statement->fetchAll();

	$output = '<h3>'. $tableName1 . '</h3>
				<table class="table table-bordered table-striped">
				<tr>
					<th width="70%">Name</td>
					<th width="20%">Status</td>
					<th width="10%">Action</td>
				</tr>';

	foreach($result as $row)
	{
		$status = '';
		$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
		$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
		$user_last_activity = fetch_user_last_activity($row['nic'], $connect);
		if($user_last_activity > $current_timestamp)
		{
			$status = '<span class="label label-success">Online</span>';
		}
		else
		{
			$status = '<span class="label label-danger">Offline</span>';
		}
		$output .= '
		<tr>
			<td>'.$row['first_name'].' '.$row['last_name'].' '.count_unseen_message($row['nic'], $_SESSION['nic'], $connect).' '.fetch_is_type_status($row['nic'], $connect).'</td>
			<td>'.$status.'</td>
			<td><button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['nic'].'" data-tousername="'.$row['first_name'].' '.$row['last_name'].'">Start Chat</button></td>
		</tr>';
	}

	$output .= '</table>';

	echo $output;

	echo '<br>';

?>