<?php 

session_start();
date_default_timezone_set("Asia/Manila");
set_time_limit(0);

$conn = mysqli_connect("localhost", "root", "", "cca_portal_db");

if (!$conn) {
	die("connection failed: " . mysqli_connect_errno());
	die("connection failed: " . mysqli_connect_error());
}

include "functions.inc.php";