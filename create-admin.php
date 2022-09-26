<?php

include "./assets/includes/dbh.inc.php";

$avatar = "cca-avatar.png";
$lastname = "Admin";
$firstname = "CCA";
$middlename = "";
$institute = "MIS";
$username = "CCA-Admin";
$initialPassword = "changed";
$password = "CCATotalisHumanae2011";
$role = "admin";
$isActive = 1;
$lastLogin	= date("Y-m-d H:i:s", time());
$currentLogin	= date("Y-m-d H:i:s", time());

$password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (avatar, lastname, firstname, middlename, institute, username, initial_password, password, role, is_active, last_login, current_login) VALUES ('$avatar', '$lastname', '$firstname', '$middlename', '$institute', '$username', '$initialPassword', '$password', '$role', '$isActive', '$lastLogin', '$currentLogin')";

if (!mysqli_query($conn, $sql)) {
	echo "error";
} else {
	echo "success";
}

?>