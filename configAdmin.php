<?php

include_Once('./config.php');
$hashedPassword = password_hash('ishan123', PASSWORD_DEFAULT);
$sql = "INSERT INTO admin (full_name, nic, username, password) VALUES ('Ishan Tharindu', '981242360v', 'admin_ishan', '$hashedPassword')";

$result = mysqli_query($con, $sql);

?>