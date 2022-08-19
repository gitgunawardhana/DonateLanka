<?php
	session_start();
	session_destroy();
	session_start();
	$_SESSION["usertype"] = "user";
	header("Location:./login.php");

?>