<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "admin");

if (isset($_GET["recoverUser"])) {
	$userId = sanitize($_GET["id"]);

	$sql = "SELECT * FROM users WHERE id = $userId";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$username = $row["username"];
		}
	}

	$initialPassword = bin2hex(openssl_random_pseudo_bytes(4));
	$hashedInitialPassword = password_hash($initialPassword, PASSWORD_DEFAULT);

	$sql = "UPDATE users SET initial_password = '$hashedInitialPassword' WHERE id = $userId";
	
	if (!mysqli_query($conn, $sql)) {
		header("Location: " . $baseUrl . "admin/users?error=Recover User error&username=" . $username . "&initialPassword=" . $initialPassword);
		exit();
	}

	header("Location: " . $baseUrl . "admin/recover/user?success=Recovered User successfully&username=" . $username . "&initialPassword=" . $initialPassword);
	exit();
}

if (isset($_GET["disableUser"])) {
	$userId = sanitize($_GET["id"]);

	$sql = "UPDATE users SET is_active = 0 WHERE id = $userId";
	
	if (!mysqli_query($conn, $sql)) {
		header("Location: " . $baseUrl . "admin/users?error=Disable User error");
		exit();
	}

	header("Location: " . $baseUrl . "admin/users?success=Disabled User successfully");
	exit();
}

if (isset($_GET["enableUser"])) {
	$userId = sanitize($_GET["id"]);

	$sql = "UPDATE users SET is_active = 1 WHERE id = $userId";
	
	if (!mysqli_query($conn, $sql)) {
		header("Location: " . $baseUrl . "admin/users?error=Enable User error");
		exit();
	}

	header("Location: " . $baseUrl . "admin/users?success=Enabled User successfully");
	exit();
}

if (isset($_POST["submitImportUsers"])) {
	$fileExtension = explode(".", $_FILES["csv"]["name"]);
	$fileExtension = end($fileExtension);
	$fileExtension = strtolower($fileExtension);

	$data = [];

	if ($fileExtension != "csv") {
		$data["type"] = "error";
		$data["value"] = "Invalid file type";

		echo json_encode($data);
		exit();
	}

	$handle = fopen($_FILES["csv"]["tmp_name"], "r");

	$counter = 1;

	while ($row = fgetcsv($handle)) {
		if ($counter <= 1) {
			$counter++;

			continue;
		}

		$avatar = "avatar.png";
		$lastname = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[2]));
		$firstname = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[3]));
		$middlename = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[4]));
		$institute = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[0]));
		$emailAddress = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[7]));
		$username = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[1]));
		$initialPassword = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[6]));
		$password = "";
		$role = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[5]));
		$role = strtolower($role);
		$status = "";
		$isActive = 1;
		$lastLogin	= date("Y-m-d H:i:s", time());
		$currentLogin	= date("Y-m-d H:i:s", time());

		if ($username == "") {
			continue;
		}

		$sql = "SELECT * FROM users WHERE username = '$username'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			continue;
		}

		$initialPassword = password_hash($initialPassword, PASSWORD_DEFAULT);

		$sql = "INSERT INTO users (avatar, lastname, firstname, middlename, institute, email_address, username, initial_password, password, role, status, is_active, last_login, current_login) VALUES ('$avatar', '$lastname', '$firstname', '$middlename', '$institute', '$emailAddress', '$username', '$initialPassword', '$password', '$role', '$status', $isActive, '$lastLogin', '$currentLogin')";
		
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>USERS</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$data["type"] = "success";
	$data["value"] = "Imported <b>USERS</b> successfully";

	echo json_encode($data);
	exit();
}

if (isset($_POST["submitEditUser"])) {
    $userId = sanitize($_POST["userId"]);
    $institute = strtoupper(sanitize($_POST["institute"]));
    $role = strtolower(sanitize($_POST["role"]));
    $status = sanitize($_POST["status"]);
    $username = sanitize($_POST["username"]);
    $emailAddress = sanitize($_POST["emailAddress"]);
    $firstname = sanitize($_POST["firstname"]);
    $middlename = sanitize($_POST["middlename"]);
    $lastname = sanitize($_POST["lastname"]);
    
    $sql = "UPDATE users SET institute = '$institute', role = '$role', status = '$status', email_address = '$emailAddress', firstname = '$firstname', middlename = '$middlename', lastname = '$lastname' WHERE username = '$username'";

    if (!mysqli_query($conn, $sql)) {
    	header("Location: " . $baseUrl . "admin/edit/user?userId=" . $userId . "&error=Upadate <b>USER</b> error");
    	exit();
    }
    
    header("Location: " . $baseUrl . "admin/edit/user?userId=" . $userId . "&success=Upadated <b>USER</b> successfully");
	exit();
}