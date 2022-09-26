<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "faculty");

if (isset($_POST["submitImportAssessments"])) {
	$academicYear = sanitize($_POST["academicYear"]);
	$semester = sanitize($_POST["semester"]);
	$classCode = sanitize($_POST["classCode"]);
	$gradingPeriod = sanitize($_POST["gradingPeriod"]);
	$assessmentType = sanitize($_POST["assessmentType"]);

	$fileExtension = explode(".", $_FILES["csv"]["name"]);
	$fileExtension = end($fileExtension);
	$fileExtension = strtolower($fileExtension);

	if ($fileExtension != "csv") {
		echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
			<strong>Error!</strong> Invalid file type.
			<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
		</div>";
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
		$assessmentNumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[2]));
		$assessmentTotal = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[3]));
		$assessmentScore = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[4]));

		if ($counter == 2) {
			$sql = "DELETE FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode' AND grading_period = '$gradingPeriod' AND assessment_type = '$assessmentType' AND assessment_number = '$assessmentNumber'";
			
			if (!mysqli_query($conn, $sql)) {
				echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
					<strong>Error!</strong> Delete Assessment error.
					<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
				</div>";
				exit();
			}
			
			$counter++;
		}

		$sql = "INSERT INTO assessments (academic_year, semester, student_number, student_name, class_code, grading_period, assessment_type, assessment_number, assessment_total, assessment_score) VALUES ('$academicYear', '$semester', '$studentNumber', '$studentName', '$classCode', '$gradingPeriod', '$assessmentType', '$assessmentNumber', '$assessmentTotal', '$assessmentScore')";
		
		if (!mysqli_query($conn, $sql)) {
			echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
				<strong>Error!</strong> Import Assessments error.
				<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
			</div>";
			exit();
		}
	}

	echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
		<strong>Success!</strong> Imported Assessments successfully.
		<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
	</div>";
	exit();
}

if (isset($_GET["deleteAssessment"])) {
	$classCode = sanitize($_GET["classCode"]);
	$gradingPeriod = sanitize($_GET["gradingPeriod"]);
	$assessmentType = sanitize($_GET["assessmentType"]);
	$assessmentNumber = sanitize($_GET["assessmentNumber"]);

	$sql = "SELECT * FROM academic_years WHERE is_active = 1";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$academicYear = $row["academic_year"];
			$semester = $row["semester"];
		}
	}

	$sql = "DELETE FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode' AND grading_period = '$gradingPeriod' AND assessment_type = '$assessmentType' AND assessment_number = '$assessmentNumber'";
	
	if (!mysqli_query($conn, $sql)) {
		header("Location: " . $baseUrl . "faculty/view/assessments/" . $gradingPeriod . "?classCode=" . $classCode . "&error=Delete Assessment error");
		exit();
	}

	header("Location: " . $baseUrl . "faculty/view/assessments/" . $gradingPeriod . "?classCode=" . $classCode . "&success=Deleted Assessment successfully");
	exit();
}