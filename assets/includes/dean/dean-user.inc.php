<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "dean");

if (isset($_POST["submitAddUser"])) {
	$avatar = "avatar.png";
	$lastname = sanitize($_POST["lastname"]);
	$firstname = sanitize($_POST["firstname"]);
	$middlename = sanitize($_POST["middlename"]);
	$institute = $_SESSION["institute"];
	$emailAddress = sanitize($_POST["emailAddress"]);
	$username = sanitize($_POST["username"]);
	$password = "";
	$role = sanitize($_POST["role"]);
	$isActive = 1;
	$lastLogin	= date("Y-m-d H:i:s", time());
	$currentLogin	= date("Y-m-d H:i:s", time());

	$initialPassword = bin2hex(openssl_random_pseudo_bytes(4));
	$hashedInitialPassword = password_hash($initialPassword, PASSWORD_DEFAULT);

	$sql = "SELECT * FROM users WHERE username = '$username' OR email_address = '$emailAddress'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		header("Location: " . $baseUrl . "dean/add/dean-user?error=Username or Email is already taken");
		exit();
	}

	$sql = "INSERT INTO users (avatar, lastname, firstname, middlename, institute, email_address, username, initial_password, password, role, is_active, last_login, current_login) VALUES ('$avatar', '$lastname', '$firstname', '$middlename', '$institute', '$emailAddress', '$username', '$hashedInitialPassword', '$password', '$role', '$isActive', '$lastLogin', '$currentLogin')";
	
	if (!mysqli_query($conn, $sql)) {
		header("Location: " . $baseUrl . "dean/add/dean-user?error=Create <b>USER</b> error");
		exit();		
	}

	header("Location: " . $baseUrl . "dean/add/dean-user?success=Created user successfully&username=" . $username . "&initialPassword=" . $initialPassword);
	exit();
}

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
		header("Location: " . $baseUrl . "dean/dean-users?error=Recover User error&username=" . $username . "&initialPassword=" . $initialPassword);
		exit();
	}

	header("Location: " . $baseUrl . "dean/recover/dean-user?success=Recovered User successfully&username=" . $username . "&initialPassword=" . $initialPassword);
	exit();
}

if (isset($_GET["disableUser"])) {
	$userId = sanitize($_GET["id"]);

	$sql = "UPDATE users SET is_active = 0 WHERE id = $userId";
	
	if (!mysqli_query($conn, $sql)) {
		header("Location: " . $baseUrl . "dean/dean-users?error=Disable User error");
		exit();
	}

	header("Location: " . $baseUrl . "dean/dean-users?success=Disabled User successfully");
	exit();
}

if (isset($_GET["enableUser"])) {
	$userId = sanitize($_GET["id"]);

	$sql = "UPDATE users SET is_active = 1 WHERE id = $userId";
	
	if (!mysqli_query($conn, $sql)) {
		header("Location: " . $baseUrl . "dean/dean-users?error=Enable User error");
		exit();
	}

	header("Location: " . $baseUrl . "dean/dean-users?success=Enabled User successfully");
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
		$institute = $_SESSION["institute"];
		$lastname = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[1]));
		$firstname = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[2]));
		$middlename = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[3]));
		$emailAddress = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[6]));
		$username = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[0]));
		$initialPassword = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[5]));
		$password = "";
		$role = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[4]));
		$role = strtolower($role);
		$isActive = 1;
		$lastLogin	= date("Y-m-d H:i:s", time());
		$currentLogin	= date("Y-m-d H:i:s", time());

		if (empty($username)) {
			continue;
		}
		
		if (!($role == "faculty" || $role == "coordinator")) {
		    $data["type"] = "error";
			$data["value"] = "Import <b>USERS</b> error. Their roles should be <b>FACULTY OR COORDINATOR</b>";

			echo json_encode($data);
			exit();
		}

		$sql = "SELECT * FROM users WHERE username = '$username'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			continue;
		}

		$initialPassword = password_hash($initialPassword, PASSWORD_DEFAULT);

		$sql = "INSERT INTO users (avatar, lastname, firstname, middlename, institute, email_address, username, initial_password, password, role, is_active, last_login, current_login) VALUES ('$avatar', '$lastname', '$firstname', '$middlename', '$institute', '$emailAddress', '$username', '$initialPassword', '$password', '$role', $isActive, '$lastLogin', '$currentLogin')";
		
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
    	header("Location: " . $baseUrl . "dean/edit/dean-user?userId=" . $userId . "&error=Upadate <b>USER</b> error");
    	exit();
    }
    
    header("Location: " . $baseUrl . "dean/edit/dean-user?userId=" . $userId . "&success=Upadated <b>USER</b> successfully");
	exit();
}