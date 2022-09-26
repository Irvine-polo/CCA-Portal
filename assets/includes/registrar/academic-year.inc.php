<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "registrar");

if (isset($_POST["submitAddAcademicYear"])) {
	$academicYearStart = sanitize($_POST["academicYearStart"]);
	$semester = sanitize($_POST["semester"]);
	$isActive = 0;

	$data = [];

	$academicYearFull = $academicYearStart . "-" . ($academicYearStart + 1);

	$sql = "SELECT * FROM academic_years WHERE academic_year = '$academicYearFull' AND semester = '$semester'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$data["type"] = "error";
			$data["value"] = "<b>ACADEMIC YEAR</b> is already used";

			echo json_encode($data);
			exit();
		}
	}

	if (isset($_POST["setCurrentAcademicYear"])) {
		$isActive = 1;

		$sql = "UPDATE academic_years SET is_active = 0";
		
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Update <b>ACADEMIC YEAR</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$sql = "INSERT INTO academic_years (academic_year, semester, is_active) VALUES ('$academicYearFull', '$semester', $isActive)";
	
	if (!mysqli_query($conn, $sql)) {
		$data["type"] = "error";
		$data["value"] = "Insert <b>ACADEMIC YEAR</b> error";

		echo json_encode($data);
		exit();
	}

	$data["type"] = "success";
	$data["value"] = "Added <b>ACADEMIC YEAR</b> successfully";

	echo json_encode($data);
	exit();
}

if (isset($_GET["activateAcademicYear"])) {
	$academicYearId = sanitize($_GET["id"]);

	$sql = "UPDATE academic_years SET is_active = 0";
	
	if (!mysqli_query($conn, $sql)) {
		header("Location: " . $baseUrl . "registrar/academic-years?error=Activate Academic Year error");
		exit();
	}

	$sql = "UPDATE academic_years SET is_active = 1 WHERE id = $academicYearId";
	
	if (!mysqli_query($conn, $sql)) {
		header("Location: " . $baseUrl . "registrar/academic-years?error=Activate Academic Year error");
		exit();
	}

	header("Location: " . $baseUrl . "registrar/academic-years?success=Activated Academic Year successfully");
	exit();
}