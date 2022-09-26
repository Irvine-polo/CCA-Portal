<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "dean");

if (isset($_POST["submitImportClassSchedules"])) {
	$academicYear = sanitize($_POST["academicYear"]);
	$semester = sanitize($_POST["semester"]);
	$institute = strtoupper($_SESSION["institute"]);

	$data = [];

	$sql = "DELETE FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND institute = '$institute'";
	
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

		$referenceNumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[0]));
		$facultyName = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[1]));
		$section = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[2]));
		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[3]));
		$subjectCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[4]));
		$subjectTitle = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[5]));
		$lecHours = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[6]));
		$labHours = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[7]));
		$units = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[8]));
		$syncDay = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[9]));
		$syncTime = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[10]));
		$asyncDay = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[11]));
		$asyncTime = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[12]));
		$status = "not finalized";

		if (empty($referenceNumber) && empty($facultyName) && empty($section) && empty($classCode) && empty($subjectCode) && empty($subjectTitle) && empty($lecHours) && empty($labHours) && empty($units) && empty($syncDay) && empty($syncTime) && empty($asyncDay) && empty($asyncTime)) {
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

if (isset($_POST["submitEditClassSchedule"])) {
	$classScheduleId = sanitize($_POST["classScheduleId"]);
	$academicYear = sanitize($_POST["academicYear"]);
	$semester = sanitize($_POST["semester"]);
	$institute = sanitize($_POST["institute"]);
	$referenceNumber = sanitize($_POST["referenceNumber"]);
	$facultyName = sanitize($_POST["facultyName"]);
	$substituteReferenceNumber = sanitize($_POST["substituteReferenceNumber"]);
	$substituteFacultyName = sanitize($_POST["substituteFacultyName"]);
	$section = sanitize($_POST["section"]);
	$classCode = sanitize($_POST["classCode"]);
	$subjectCode = sanitize($_POST["subjectCode"]);
	$subjectTitle = sanitize($_POST["subjectTitle"]);
	$lecHours = sanitize($_POST["lecHours"]);
	$labHours = sanitize($_POST["labHours"]);
	$units = sanitize($_POST["units"]);
	$syncDay = sanitize($_POST["syncDay"]);
	$syncTime = sanitize($_POST["syncTime"]);
	$asyncDay = sanitize($_POST["asyncDay"]);
	$asyncTime = sanitize($_POST["asyncTime"]);

	$data = [];

	$sql = "SELECT * FROM class_schedules WHERE id = $classScheduleId";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$oldReferenceNumber = $row["reference_number"];
			$newReferenceNumber = $referenceNumber;
		}
	}

	$sql = "
	UPDATE class_schedules 
	SET 
		institute = '$institute', 
		reference_number = '$referenceNumber', 
		faculty_name = '$facultyName', 
		substitute_reference_number = '$substituteReferenceNumber', 
		substitute_faculty_name = '$substituteFacultyName', 
		section = '$section', 
		class_code = '$classCode', 
		subject_code = '$subjectCode', 
		subject_title = '$subjectTitle', 
		lec_hours = '$lecHours', 
		lab_hours = '$labHours', 
		units = '$units', 
		sync_day = '$syncDay', 
		sync_time = '$syncTime', 
		async_day = '$asyncDay', 
		async_time = '$asyncTime' 
	WHERE 
		id = $classScheduleId";
	
	if (!mysqli_query($conn, $sql)) {
		header("Location: " . $baseUrl . "dean/edit/dean-class-schedule?academicYear=" . $academicYear . "&semester=" . $semester . "&id=" . $classScheduleId . "&error=Update <b>CLASS SCHEDULE</b> error");
		exit();
	}

	$title = "Class Schedule";
	$description = "Class Code <b>" . $classCode . " [" . $section . " | " . $subjectCode . "]</b> has been updated.";
	$createdAt = date("Y-m-d H:i:s", time());
	$hasSeen = 0;

	if ($oldReferenceNumber == $newReferenceNumber) {
		$sql = "INSERT INTO notifications (username, title, description, created_at, has_seen) VALUES ('$oldReferenceNumber', '$title', '$description', '$createdAt', $hasSeen)";
		
		if (!mysqli_query($conn, $sql)) {
			header("Location: " . $baseUrl . "dean/edit/dean-class-schedule?academicYear=" . $academicYear . "&semester=" . $semester . "&id=" . $classScheduleId . "&error=Insert <b>NOTIFICATION</b> error");
			exit();
		}
	} else {
		$sql = "INSERT INTO notifications (username, title, description, created_at, has_seen) VALUES ('$oldReferenceNumber', '$title', '$description', '$createdAt', $hasSeen)";
		
		if (!mysqli_query($conn, $sql)) {
			header("Location: " . $baseUrl . "dean/edit/dean-class-schedule?academicYear=" . $academicYear . "&semester=" . $semester . "&id=" . $classScheduleId . "&error=Insert <b>NOTIFICATION</b> error");
			exit();
		}

		$sql = "INSERT INTO notifications (username, title, description, created_at, has_seen) VALUES ('$newReferenceNumber', '$title', '$description', '$createdAt', $hasSeen)";
		
		if (!mysqli_query($conn, $sql)) {
			header("Location: " . $baseUrl . "dean/edit/dean-class-schedule?academicYear=" . $academicYear . "&semester=" . $semester . "&id=" . $classScheduleId . "&error=Insert <b>NOTIFICATION</b> error");
			exit();
		}
	}
	
	if ($substituteReferenceNumber !== "") {
	    $sql = "INSERT INTO notifications (username, title, description, created_at, has_seen) VALUES ('$substituteReferenceNumber', '$title', '$description', '$createdAt', $hasSeen)";
		
		if (!mysqli_query($conn, $sql)) {
			header("Location: " . $baseUrl . "dean/edit/dean-class-schedule?academicYear=" . $academicYear . "&semester=" . $semester . "&id=" . $classScheduleId . "&error=Insert <b>NOTIFICATION</b> error");
			exit();
		}
	}

	header("Location: " . $baseUrl . "dean/edit/dean-class-schedule?academicYear=" . $academicYear . "&semester=" . $semester . "&id=" . $classScheduleId . "&success=Updated <b>CLASS SCHEDULE</b> successfully");
	exit();
}