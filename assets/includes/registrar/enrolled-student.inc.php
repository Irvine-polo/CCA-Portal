<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "registrar");

if (isset($_POST["submitImportEnrolledStudents"])) {
	$academicYear = sanitize($_POST["academicYear"]);
	$semester = sanitize($_POST["semester"]);

	$data = [];

	$sql = "DELETE FROM student_courses WHERE academic_year = '$academicYear' AND semester = '$semester'";
	
	if (!mysqli_query($conn, $sql)) {
		$data["type"] = "error";
		$data["value"] = "Delete <b>STUDENT COURSES</b> error";

		echo json_encode($data);
		exit();
	}

	$sql = "DELETE FROM student_subjects WHERE academic_year = '$academicYear' AND semester = '$semester'";
	
	if (!mysqli_query($conn, $sql)) {
		$data["type"] = "error";
		$data["value"] = "Delete <b>STUDENT SUBJECTS</b> error";

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
		$lastname = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[1]));
		$firstname = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[2]));
		$middlename = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[3]));
		$emailAddress = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[4]));
		$sex = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[5]));
		$course = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[6]));
		$yearLevel = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[7]));
		$section = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[8]));
		$status = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[9]));
		$isPWD = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[10]));

		$sql = "INSERT INTO student_courses (academic_year, semester, student_number, lastname, firstname, middlename, email_address, sex, course, year_level, section, status, is_pwd) VALUES ('$academicYear', '$semester', '$studentNumber', '$lastname', '$firstname', '$middlename', '$emailAddress', '$sex', '$course', '$yearLevel', '$section', '$status', '$isPWD')";
		
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT COURSES</b> error";

			echo json_encode($data);
			exit();
		}

		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[11]));

		if (!($classCode == "" OR $classCode == "0")) {
			$sql2 = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

				echo json_encode($data);
				exit();
			}
		}

		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[12]));

		if (!($classCode == "" OR $classCode == "0")) {
			$sql2 = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

				echo json_encode($data);
				exit();
			}
		}

		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[13]));

		if (!($classCode == "" OR $classCode == "0")) {
			$sql2 = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

				echo json_encode($data);
				exit();
			}
		}

		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[14]));

		if (!($classCode == "" OR $classCode == "0")) {
			$sql2 = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

				echo json_encode($data);
				exit();
			}
		}

		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[15]));

		if (!($classCode == "" OR $classCode == "0")) {
			$sql2 = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

				echo json_encode($data);
				exit();
			}
		}

		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[16]));

		if (!($classCode == "" OR $classCode == "0")) {
			$sql2 = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

				echo json_encode($data);
				exit();
			}
		}

		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[17]));

		if (!($classCode == "" OR $classCode == "0")) {
			$sql2 = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

				echo json_encode($data);
				exit();
			}
		}

		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[18]));

		if (!($classCode == "" OR $classCode == "0")) {
			$sql2 = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

				echo json_encode($data);
				exit();
			}
		}

		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[19]));

		if (!($classCode == "" OR $classCode == "0")) {
			$sql2 = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

				echo json_encode($data);
				exit();
			}
		}

		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[20]));

		if (!($classCode == "" OR $classCode == "0")) {
			$sql2 = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

				echo json_encode($data);
				exit();
			}
		}

		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[21]));

		if (!($classCode == "" OR $classCode == "0")) {
			$sql2 = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

				echo json_encode($data);
				exit();
			}
		}

		$classCode = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[22]));

		if (!($classCode == "" OR $classCode == "0")) {
			$sql2 = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

				echo json_encode($data);
				exit();
			}
		}	
	}

	$data["type"] = "success";
	$data["value"] = "Imported <b>ENROLLED STUDENTS</b> successfully";

	echo json_encode($data);
	exit();
}

if (isset($_POST["submitAddEnrolledStudent"])) {
	$academicYear = sanitize($_POST["academicYear"]);
	$semester = sanitize($_POST["semester"]);
	$studentNumber = sanitize($_POST["studentNumber"]);
	$emailAddress = sanitize($_POST["emailAddress"]);
	$firstname = sanitize($_POST["firstname"]);
	$middlename = sanitize($_POST["middlename"]);
	$lastname = sanitize($_POST["lastname"]);
	$course = sanitize($_POST["course"]);
	$yearLevel = sanitize($_POST["yearLevel"]);
	$section = sanitize($_POST["section"]);
	$sex = sanitize($_POST["sex"]);
	$status = sanitize($_POST["status"]);
	$isPWD = sanitize($_POST["isPWD"]);
	$subject1 = sanitize($_POST["subject1"]);
	$subject2 = sanitize($_POST["subject2"]);
	$subject3 = sanitize($_POST["subject3"]);
	$subject4 = sanitize($_POST["subject4"]);
	$subject5 = sanitize($_POST["subject5"]);
	$subject6 = sanitize($_POST["subject6"]);
	$subject7 = sanitize($_POST["subject7"]);
	$subject8 = sanitize($_POST["subject8"]);
	$subject9 = sanitize($_POST["subject9"]);
	$subject10 = sanitize($_POST["subject10"]);
	$subject11 = sanitize($_POST["subject11"]);
	$subject12 = sanitize($_POST["subject12"]);

	$sql = "INSERT INTO student_courses (academic_year, semester, student_number, lastname, firstname, middlename, email_address, sex, course, year_level, section, status, is_pwd) VALUES ('$academicYear', '$semester', '$studentNumber', '$lastname', '$firstname', '$middlename', '$emailAddress', '$sex', '$course', '$yearLevel', '$section', '$status', '$isPWD')";
		
	if (!mysqli_query($conn, $sql)) {
		$data["type"] = "error";
		$data["value"] = "Import <b>STUDENT COURSE</b> error";

		echo json_encode($data);
		exit();
	}

	$classCode = $subject1;

	if (!($classCode == "" OR $classCode == "0")) {
		$sql = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$classCode = $subject2;

	if (!($classCode == "" OR $classCode == "0")) {
		$sql = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$classCode = $subject3;

	if (!($classCode == "" OR $classCode == "0")) {
		$sql = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$classCode = $subject4;

	if (!($classCode == "" OR $classCode == "0")) {
		$sql = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$classCode = $subject5;

	if (!($classCode == "" OR $classCode == "0")) {
		$sql = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$classCode = $subject6;

	if (!($classCode == "" OR $classCode == "0")) {
		$sql = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$classCode = $subject7;

	if (!($classCode == "" OR $classCode == "0")) {
		$sql = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$classCode = $subject8;

	if (!($classCode == "" OR $classCode == "0")) {
		$sql = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$classCode = $subject9;

	if (!($classCode == "" OR $classCode == "0")) {
		$sql = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$classCode = $subject10;

	if (!($classCode == "" OR $classCode == "0")) {
		$sql = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$classCode = $subject11;

	if (!($classCode == "" OR $classCode == "0")) {
		$sql = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$classCode = $subject12;

	if (!($classCode == "" OR $classCode == "0")) {
		$sql = "INSERT INTO student_subjects (academic_year, semester, student_number, class_code) VALUES ('$academicYear', '$semester', '$studentNumber', '$classCode')";
			
		if (!mysqli_query($conn, $sql)) {
			$data["type"] = "error";
			$data["value"] = "Import <b>STUDENT SUBJECTS</b> error";

			echo json_encode($data);
			exit();
		}
	}

	$data = [];

	$data["type"] = "success";
	$data["value"] = "Imported <b>ENROLLED STUDENTS</b> successfully";

	echo json_encode($data);
	exit();
}