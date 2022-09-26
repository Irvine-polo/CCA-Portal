<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "faculty");

// if (isset($_POST["submitImportFinalizedGrades"])) {
// 	$classCode = sanitize($_POST["classCode"]);
// 	$subjectCode = sanitize($_POST["subjectCode"]);
// 	$subjectTitle = sanitize($_POST["subjectTitle"]);
// 	$units = sanitize($_POST["units"]);
// 	$remarks = "";

// 	$sql = "SELECT * FROM academic_years WHERE is_active = 1";
// 	$result = mysqli_query($conn, $sql);
	
// 	if (mysqli_num_rows($result) > 0) {
// 		while ($row = mysqli_fetch_assoc($result)) {
// 			$academicYear = $row["academic_year"];
// 			$semester = $row["semester"];
// 		}
// 	}

// 	$sql = "DELETE FROM student_grades WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode'";
	
// 	if (!mysqli_query($conn, $sql)) {
// 		echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
// 			<strong>Error!</strong> Delete Class Code error.
// 			<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
// 		</div>";
// 		exit();
// 	}

// 	$fileExtension = explode(".", $_FILES["csv"]["name"]);
// 	$fileExtension = end($fileExtension);
// 	$fileExtension = strtolower($fileExtension);

// 	if ($fileExtension != "csv") {
// 		echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
// 			<strong>Error!</strong> Invalid file type.
// 			<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
// 		</div>";
// 		exit();
// 	}

// 	$handle = fopen($_FILES["csv"]["tmp_name"], "r");

// 	$counter = 1;

// 	while ($row = fgetcsv($handle)) {
// 		if ($counter <= 1) {
// 			$counter++;

// 			continue;
// 		}

// 		$studentNumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[0]));
// 		$studentName = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[1]));
// 		$midtermGrade = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[2]));
// 		$finalGrade = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[3]));

// 		if ($midtermGrade != "") {
// 			$midtermGrade = floatval($midtermGrade);
// 			$midtermGrade = number_format($midtermGrade, 2);

// 			if ($midtermGrade <= 3.00) {
// 				$remarks = "PASSED";
// 			} else if ($midtermGrade == 5.00) {
// 				$remarks = "FAILED";
// 			} else if ($midtermGrade == 6.00) {
// 				$remarks = "FA";
// 			} else if ($midtermGrade == -7.00) {
// 				$remarks = "INC";
// 			} else if ($midtermGrade == 7.00) {
// 				$remarks = "NFE";
// 			} else if ($midtermGrade == 8.00) {
// 				$remarks = "UW";
// 			} else if ($midtermGrade == 9.00) {
// 				$remarks = "DRP";
// 			}
// 		}
		
// 		if ($finalGrade != "") {
// 			$finalGrade = floatval($finalGrade);
// 			$finalGrade = number_format($finalGrade, 2);

// 			if ($finalGrade <= 3.00) {
// 				$remarks = "PASSED";
// 			} else if ($finalGrade == 5.00) {
// 				$remarks = "FAILED";
// 			} else if ($finalGrade == 6.00) {
// 				$remarks = "FA";
// 			} else if ($finalGrade == -7.00) {
// 				$remarks = "INC";
// 			} else if ($finalGrade == 7.00) {
// 				$remarks = "NFE";
// 			} else if ($finalGrade == 8.00) {
// 				$remarks = "UW";
// 			} else if ($finalGrade == 9.00) {
// 				$remarks = "DRP";
// 			}
// 		}

// 		$sql = "INSERT INTO student_grades (academic_year, semester, student_number, student_name, class_code, subject_code, subject_title, midterm_grade, final_grade, units, remarks) VALUES ('$academicYear', '$semester', '$studentNumber', '$studentName', '$classCode', '$subjectCode', '$subjectTitle', '$midtermGrade', '$finalGrade', '$units', '$remarks')";
		
// 		if (!mysqli_query($conn, $sql)) {
// 			echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
// 				<strong>Error!</strong> Import Finalized Grades error.
// 				<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
// 			</div>";
// 			exit();
// 		}
// 	}

// 	echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
// 		<strong>Success!</strong> Imported Finalized Grades successfully.
// 		<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
// 	</div>";
// 	exit();
// }

if (isset($_POST["submitImportFinalizedGrades"])) {
	$institute = $_SESSION["institute"];
	$classCode = sanitize($_POST["classCode"]);
	$subjectCode = sanitize($_POST["subjectCode"]);
	$subjectTitle = sanitize($_POST["subjectTitle"]);
	$units = sanitize($_POST["units"]);
	$remarks = "";

	$data = [];

	$sql = "SELECT * FROM academic_years WHERE is_active = 1";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$academicYear = $row["academic_year"];
			$semester = $row["semester"];
		}
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

	$studentNumbers = array();

	$sql = "SELECT * FROM student_subjects WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($studentNumbers, $row["student_number"]);
		}
	}

	$counter = 1;

	while ($row = fgetcsv($handle)) {
		if ($counter <= 1) {
			$counter++;

			continue;
		}

		$studentNumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[0]));
		$studentName = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[1]));
		$equivalent = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[2]));
		$units = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[3]));
		$remarks = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[4]));
		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[5]));

		if (($key = array_search($studentNumber, $studentNumbers)) !== false) {
			unset($studentNumbers[$key]);
		} else {
			array_push($studentNumbers, $studentNumber);
		}
	}

	if (count($studentNumbers) > 0) {
		$data["type"] = "error";
		$data["value"] = "Please make sure that the <b>STUDENT NUMBERS IN YOUR CSV FILE</b> matches the <b>STUDENT NUMBERS IN THE CLASS LIST</b>";

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
		$midtermGrade = "";
		$finalGrade = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[2]));
		$units = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[3]));
		$remarks = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[4]));
		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[5]));

		$sql = "SELECT * FROM student_grades WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode' AND student_number = '$studentNumber'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			$sql2 = "UPDATE student_grades SET final_grade = '$finalGrade', units = '$units', remarks = '$remarks' WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode' AND student_number = '$studentNumber'";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Update <b>GRADES</b> error";

				echo json_encode($data);
				exit();
			}
			
		} else {
			$sql2 = "INSERT INTO student_grades (academic_year, semester, institute, student_number, student_name, class_code, subject_code, subject_title, midterm_grade, final_grade, units, remarks) VALUES ('$academicYear', '$semester', '$institute', '$studentNumber', '$studentName', '$classCode', '$subjectCode', '$subjectTitle', '$midtermGrade', '$finalGrade', '$units', '$remarks')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>GRADES</b> error";

				echo json_encode($data);
				exit();
			}
		}
	}

	$data["type"] = "success";
	$data["value"] = "Imported <b>GRADES</b> successfully";

	echo json_encode($data);
	exit();
}

if (isset($_POST["updateStudentGrade"])) {
	$academicYear = sanitize($_POST["academicYear"]);
	$semester = sanitize($_POST["semester"]);
	$institute = $_SESSION["institute"];
	$studentNumber = sanitize($_POST["studentNumber"]);
	$studentName = sanitize($_POST["studentName"]);
	$classCode = sanitize($_POST["classCode"]);
	// subject code
	// subject title
	$midtermGrade = "";
	$finalGrade = strtoupper(sanitize($_POST["finalGrade"]));
	// units

	$data = [];

	$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
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
		case "":
			$remarks = "";
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
			$data["type"] = "error";
			$data["value"] = "Update <b>STUDENT GRADE</b> error";

			echo json_encode($data);
			exit();
		}
	} else {
		// INSERT
		$sql2 = "INSERT INTO student_grades (academic_year, semester, institute, student_number, student_name, class_code, subject_code, subject_title, midterm_grade, final_grade, units, remarks) VALUES ('$academicYear', '$semester', '$institute', '$studentNumber', '$studentName', '$classCode', '$subjectCode', '$subjectTitle', '$midtermGrade', '$finalGrade', '$units', '$remarks')";
		
		if (!mysqli_query($conn, $sql2)) {
			$data["type"] = "error";
			$data["value"] = "Update <b>STUDENT GRADE</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$data["type"] = "success";
	$data["value"] = "Updated <b>STUDENT GRADE</b> successfully";
	$data["equivalent"] = $finalGrade;
	$data["units"] = $units;
	$data["remarks"] = $remarks;

	echo json_encode($data);
	exit();
}

if (isset($_GET["submitfinalizeGrades"])) {
	$classCode = sanitize($_GET["classCode"]);

	$academicYear = sanitize($_GET["academicYear"]);
	$semester = sanitize($_GET["semester"]);

	$sql = "SELECT * FROM student_subjects WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$studentNumber = $row["student_number"];

			$sql2 = "SELECT * FROM student_grades WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode' AND student_number = '$studentNumber' AND final_grade <> '' AND remarks <> ''";
			$result2 = mysqli_query($conn, $sql2);
			
			if (mysqli_num_rows($result2) == 0) {
				header("Location: " . $baseUrl . "faculty/view/student-grades?academicYear=" . $academicYear . "&semester=" . $semester . "&error=Incomplete <b>STUDENT GRADES</b> error");
				exit();	
			}
		}
	}

	$status = "finalized";

	$sql = "UPDATE class_schedules SET status = '$status' WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode'";
	
	if (!mysqli_query($conn, $sql)) {
		header("Location: " . $baseUrl . "faculty/view/student-grades?academicYear=" . $academicYear . "&semester=" . $semester . "&error=Update <b>CLASS SCHEDULE</b> status error");
		exit();
	}

	header("Location: " . $baseUrl . "faculty/view/student-grades?academicYear=" . $academicYear . "&semester=" . $semester . "&success=Finalized <b>STUDENT GRADES</b> successfully");
	exit();
}