<?php 

$baseUrl = "../../";

include $baseUrl . "assets/includes/dbh.inc.php";

if (isset($_POST["submitSignIn"])) {
	$username = sanitize($_POST["username"]);
	$password = sanitize($_POST["password"]);

	$data = [];

	$sql = "SELECT * FROM users WHERE username = '$username' OR email_address = '$username'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			if ($row["is_active"] != 1) {
				$data["type"] = "error";
				$data["value"] = "Your account is disabled";

				echo json_encode($data);
				exit();
			}

			if ($row["initial_password"] != "changed") {
				if (!password_verify($password, $row["initial_password"])) {
					$data["type"] = "error";
					$data["value"] = "Incorrect initial password";

					echo json_encode($data);
					exit();
				}

				session_regenerate_id();

				$_SESSION["user_id"] = $row["id"];
				$_SESSION["role"] = "setPassword";

				session_write_close();

				$data["type"] = "redirect";
				$data["value"] = "set-password";

				echo json_encode($data);
				exit();
			}

			if (!password_verify($password, $row["password"])) {
				$data["type"] = "error";
				$data["value"] = "Incorrect password";

				echo json_encode($data);
				exit();
			}

			session_regenerate_id();

			$_SESSION["user_id"] = $row["id"];
			$_SESSION["institute"] = $row["institute"];
			$_SESSION["username"] = $row["username"];
			$_SESSION["firstname"] = $row["firstname"];
			$_SESSION["middlename"] = $row["middlename"];
			$_SESSION["lastname"] = $row["lastname"];
			$_SESSION["role"] = $row["role"];

			session_write_close();

			$userId = $row["id"];
			$currentLogin = $row["current_login"];
			$today = date("Y-m-d H:i:s", time());

			$sql = "UPDATE users SET last_login = '$currentLogin', current_login = '$today' WHERE id = $userId";
			
			if (!mysqli_query($conn, $sql)) {
				$data["type"] = "error";
				$data["value"] = "Update Last Login error";

				echo json_encode($data);
				exit();
			}
		}
	} else {
		$data["type"] = "error";
		$data["value"] = "Username/Email not found";

		echo json_encode($data);
		exit();
	}

	if ($_SESSION["role"] == "student") {
		$data["type"] = "redirect";
		$data["value"] = "student";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "faculty") {
		$data["type"] = "redirect";
		$data["value"] = "faculty";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "coordinator") {
		$data["type"] = "redirect";
		$data["value"] = "coordinator";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "secretary") {
		$data["type"] = "redirect";
		$data["value"] = "secretary";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "dean") {
		$data["type"] = "redirect";
		$data["value"] = "dean";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "hr") {
		$data["type"] = "redirect";
		$data["value"] = "hr";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "registrar") {
		$data["type"] = "redirect";
		$data["value"] = "registrar";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "vpaa") {
		$data["type"] = "redirect";
		$data["value"] = "vpaa";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "admin") {
		$data["type"] = "redirect";
		$data["value"] = "admin";

		echo json_encode($data);
		exit();
	}
}

if (isset($_GET["signOut"])) {
	session_destroy();
	
	$signOut = sanitize($_GET["signOut"]);

	if (empty($_GET["signOut"])) {
		header("Location: " . $baseUrl);
		exit();	
	} else {
		header("Location: " . $baseUrl . "?session=" . $_GET["signOut"]);
		exit();	
	}
}

if (isset($_POST["submitSetPassword"])) {
	$userId = $_SESSION["user_id"];
	$password = sanitize($_POST["password"]);
	$confirmPassword = sanitize($_POST["confirmPassword"]);

	$data = [];

	if ($password != $confirmPassword) {
		$data["type"] = "error";
		$data["value"] = "Passwords mismatch";

		echo json_encode($data);
		exit();
	}

	$password = password_hash($password, PASSWORD_DEFAULT);

	$sql = "UPDATE users SET initial_password = 'changed', password = '$password' WHERE id = $userId";
	
	if (!mysqli_query($conn, $sql)) {
		$data["type"] = "error";
		$data["value"] = "Update Password error";

		echo json_encode($data);
		exit();
	}

	$sql = "SELECT * FROM users WHERE id = $userId";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			session_regenerate_id();

			$_SESSION["user_id"] = $row["id"];
			$_SESSION["institute"] = $row["institute"];
			$_SESSION["username"] = $row["username"];
			$_SESSION["firstname"] = $row["firstname"];
			$_SESSION["middlename"] = $row["middlename"];
			$_SESSION["lastname"] = $row["lastname"];
			$_SESSION["role"] = $row["role"];

			session_write_close();

			$userId = $row["id"];
			$currentLogin = $row["current_login"];
			$today = date("Y-m-d H:i:s", time());

			$sql = "UPDATE users SET last_login = '$currentLogin', current_login = '$today' WHERE id = $userId";
			
			if (!mysqli_query($conn, $sql)) {
				$data["type"] = "error";
				$data["value"] = "Update Last Login error";

				echo json_encode($data);
				exit();
			}
		}
	}

	if ($_SESSION["role"] == "student") {
		$data["type"] = "redirect";
		$data["value"] = "student";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "faculty") {
		$data["type"] = "redirect";
		$data["value"] = "faculty";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "coordinator") {
		$data["type"] = "redirect";
		$data["value"] = "coordinator";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "secretary") {
		$data["type"] = "redirect";
		$data["value"] = "secretary";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "dean") {
		$data["type"] = "redirect";
		$data["value"] = "dean";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "hr") {
		$data["type"] = "redirect";
		$data["value"] = "hr";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "registrar") {
		$data["type"] = "redirect";
		$data["value"] = "registrar";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "vpaa") {
		$data["type"] = "redirect";
		$data["value"] = "vpaa";

		echo json_encode($data);
		exit();
	} else if ($_SESSION["role"] == "admin") {
		$data["type"] = "redirect";
		$data["value"] = "admin";

		echo json_encode($data);
		exit();
	}
}