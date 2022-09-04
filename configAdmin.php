<?php

include_Once('./config.php');

// get next admin id - start
$sql_get_count = "SELECT MAX(id) FROM admin";
$result_get_count = mysqli_query($con, $sql_get_count);
$row_info = $result_get_count->fetch_assoc();
$next_img_id = $row_info['MAX(id)'] + 1;
// get next admin id - end

$dst_db = "Upload/Avatar/Admin/".$next_img_id."avatar.jpg";

$hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);

$sql = "INSERT INTO admin (full_name, nic, username, profile_picture, password) VALUES ('Ishan Tharindu', '981242360v', 'admin', '$dst_db', '$hashedPassword')";

$result = mysqli_query($con, $sql);

?>