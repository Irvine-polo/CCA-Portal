<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "admin");

if (isset($_POST["submitImportClassSchedules"])) {
	$academicYear = sanitize($_POST["academicYear"]);
	$semester = sanitize($_POST["semester"]);

	$data = [];

	$sql = "DELETE FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester'";
	
	if (!mysqli_query($conn, $sql)) {
		$data["type"] = "error";
		$data["value"] = "Delete <b>CLASS SCHEDULES</b> error";

		echo json_encode($data);
		exit();
	}

	$fileExtension = explode(".", $_FILES["csv"]["name"]);
	$fileExtension = end($fileExtension);
	$fileExtension = strtolower($fileExtension);

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

		$institute = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[0]));
		$referenceNumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[1]));
		$facultyName = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[2]));
		$section = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[3]));
		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[4]));
		$subjectCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[5]));
		$subjectTitle = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[6]));
		$lecHours = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[7]));
		$labHours = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[8]));
		$units = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[9]));
		$syncDay = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[10]));
		$syncTime = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[11]));
		$asyncDay = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[12]));
		$asyncTime = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[13]));
		$status = "not finalized";

		if (empty($institute) && empty($referenceNumber) && empty($facultyName) && empty($section) && empty($classCode) && empty($subjectCode) && empty($subjectTitle) && empty($lecHours) && empty($labHours) && empty($units) && empty($syncDay) && empty($syncTime) && empty($asyncDay) && empty($asyncTime)) {
			continue;
		}

		if ($units == "-3") {
			$units = "(3)";
		}

		$sql = "INSERT INTO class_schedules (institute, academic_year, semester, reference_number, faculty_name, section, class_code, subject_code, subject_title, lec_hours, lab_hours, units, sync_day, sync_time, async_day, async_time, status) VALUES ('$institute', '$academicYear', '$semester', '$referenceNumber', '$facultyName', '$section', '$classCode', '$subjectCode', '$subjectTitle', '$lecHours', '$labHours', '$units', '$syncDay', '$syncTime', '$asyncDay', '$asyncTime', '$status')";
		
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>CLASS SCHEDULES</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$data["type"] = "success";
	$data["value"] = "Imported <b>CLASS SCHEDULES</b> successfully";

	echo json_encode($data);
	exit();
}