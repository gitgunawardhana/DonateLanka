<?php
// Opens a connection to a MySQL server.
$con=mysqli_connect("localhost:3308", 'root', '','donate_lanka');
date_default_timezone_set('Asia/Kolkata');
if (!$con) {
		die('Not connected : ' . mysqli_connect_error());
}

?>