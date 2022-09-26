<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "admin");

if (isset($_POST["submitImportStudentGrades"])) {
	$academicYear = sanitize($_POST["academicYear"]);
	$semester = sanitize($_POST["semester"]);

	$data = [];

	$sql = "DELETE FROM student_grades WHERE academic_year = '$academicYear' AND semester = '$semester'";
	
	if (!mysqli_query($conn, $sql)) {
		$data["type"] = "error";
		$data["value"] = "Delete <b>STUDENT GRADES</b> error";

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

		$studentNumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[0]));
		$studentName = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[1]));
		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[2]));
		$subjectCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[3]));
		$subjectTitle = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[4]));
		$midtermGrade = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[5]));
		$finalGrade = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[6]));
		$units = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[7]));

		$midtermGrade = floatval($midtermGrade);
		$midtermGrade = number_format($midtermGrade, 2);

		$finalGrade = floatval($finalGrade);
		$finalGrade = number_format($finalGrade, 2);

		switch (strval($finalGrade)) {
			case "1.00":
			case "1.25":
			case "1.50":
			case "1.75":
			case "2.00":
			case "2.25":
			case "2.50":
			case "2.75":
			case "3.00":
				$remarks = "PASSED";
				break;
			case "5.00":
				$remarks = "FAILED";
				break;
			case "6.00":
				$remarks = "FA";
				break;
			case "7.00":
				$remarks = "NFE";
				break;
			case "8.00":
				$remarks = "UW";
				break;
			case "9.00":
				$remarks = "DROPPED";
				break;
			case "LOA":
				$remarks = "LOA";
				break;
			case "CRD":
				$remarks = "CREDITED";
				break;
			default:
				$remarks = "Wrong input";
		}

		if ($units == "-3") {
			$units = "(3)";
		}

		$sql = "INSERT INTO student_grades (academic_year, semester, student_number, student_name, class_code, subject_code, subject_title, midterm_grade, final_grade, units, remarks) VALUES ('$academicYear', '$semester', '$studentNumber', '$studentName', '$classCode', '$subjectCode', '$subjectTitle', '$midtermGrade', '$finalGrade', '$units', '$remarks')";
		
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT GRADES</b> error";

			echo json_encode($data);
			exit();
		}

		$status = "finalized";

		$sql = "UPDATE class_schedules SET status = '$status' WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode'";
		
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Update <b>CLASS SCHEDULE</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$data["type"] = "success";
	$data["value"] = "Imported <b>STUDENT GRADES</b> successfully";

	echo json_encode($data);
	exit();
}

if (isset($_POST["updateStudentGrade"])) {
	$username = $_SESSION["username"];
	$academicYear = sanitize($_POST["academicYear"]);
	$semester = sanitize($_POST["semester"]);
	// $institute = $_SESSION["institute"];
	$studentNumber = sanitize($_POST["studentNumber"]);
	$studentName = sanitize($_POST["studentName"]);
	$classCode = sanitize($_POST["classCode"]);
	// subject code
	// subject title
	$midtermGrade = "";
	$finalGrade = strtoupper(sanitize($_POST["finalGrade"]));
	// units
	$password = sanitize($_POST["password"]);

	$sql = "SELECT * FROM users WHERE username = '$username'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			if (!password_verify($password, $row["password"])) {
				header("Location: ../../../admin/edit/student-grade?academicYear=" . $academicYear . "&semester=" . $semester . "&classCode=" . $classCode . "&studentNumber=" . $studentNumber . "&error=Incorrect Password");
				exit();
			}
		}
	}

	$data = [];

	$sql = "SELECT * FROM student_grades WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode' AND student_number = '$studentNumber'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$oldFinalGrade = $row["final_grade"];
		}
	} else {
	    $oldFinalGrade = "none";
	}

	$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$institute = $row["institute"];
			$referenceNumber = $row["reference_number"];
			$section = $row["section"];
			$subjectCode = $row["subject_code"];
			$subjectTitle = $row["subject_title"];
			$units = $row["units"];
		}
	}

	switch ($finalGrade) {
		case "1.00":
		case "1.25":
		case "1.50":
		case "1.75":
		case "2.00":
		case "2.25":
		case "2.50":
		case "2.75":
		case "3.00":
			$remarks = "PASSED";
			break;
		case "5.00":
			$remarks = "FAILED";
			break;
		case "6.00":
			$remarks = "FA";
			break;
		case "7.00":
			$remarks = "NFE";
			break;
		case "8.00":
			$remarks = "UW";
			break;
		case "9.00":
			$remarks = "DROPPED";
			break;
		case "LOA":
			$remarks = "LOA";
			break;
		case "CRD":
			$remarks = "CREDITED";
			break;
		default:
			$remarks = "Wrong input";
	}


	$sql = "SELECT * FROM student_grades WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode' AND student_number = '$studentNumber'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		// UPDATE
		$sql2 = "UPDATE student_grades SET final_grade = '$finalGrade', remarks = '$remarks' WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode' AND student_number = '$studentNumber'";
		
		if (!mysqli_query($conn, $sql2)) {
			header("Location: ../../../admin/edit/student-grade?academicYear=" . $academicYear . "&semester=" . $semester . "&classCode=" . $classCode . "&studentNumber=" . $studentNumber . "&error=Update <b>STUDENT GRADE</b> error");
			exit();
		}
	} else {
		// INSERT
		$sql2 = "INSERT INTO student_grades (academic_year, semester, institute, student_number, student_name, class_code, subject_code, subject_title, midterm_grade, final_grade, units, remarks) VALUES ('$academicYear', '$semester', '$institute', '$studentNumber', '$studentName', '$classCode', '$subjectCode', '$subjectTitle', '$midtermGrade', '$finalGrade', '$units', '$remarks')";
		
		if (!mysqli_query($conn, $sql2)) {
			header("Location: ../../../admin/edit/student-grade?academicYear=" . $academicYear . "&semester=" . $semester . "&classCode=" . $classCode . "&studentNumber=" . $studentNumber . "&error=Insert <b>STUDENT GRADE</b> error");
			exit();
		}
	}

	$sql = "SELECT * FROM users WHERE (role = 'dean' AND institute = '$institute') OR role = 'vpaa' OR username = '$referenceNumber' AND is_active = 1";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$username = $row["username"];
			$title = "Student Grade";
			$description =  "<b>" . $studentNumber . " | " . $studentName . "\'s</b> Grade in " . "Class Code <b>" . $classCode . " [" . $section . " | " . $subjectCode . "]</b> has been updated from <b>" . $oldFinalGrade . "</b> to <b>" . $finalGrade . "</b>";
			$createdAt = date("Y-m-d H:i:s", time());
			$hasSeen = 0;

			$sql = "INSERT INTO notifications (username, title, description, created_at, has_seen) VALUES ('$username', '$title', '$description', '$createdAt', $hasSeen)";
				
			if (!mysqli_query($conn, $sql)) {
				header("Location: ../../../admin/edit/student-grade?academicYear=" . $academicYear . "&semester=" . $semester . "&classCode=" . $classCode . "&studentNumber=" . $studentNumber . "&error=Insert <b>NOTIFICATION</b> error");
				exit();
			}
		}
	}			

	header("Location: ../../../admin/edit/student-grade?academicYear=" . $academicYear . "&semester=" . $semester . "&classCode=" . $classCode . "&studentNumber=" . $studentNumber . "&success=Updated <b>STUDENT GRADE</b> successfully");
	exit();
}