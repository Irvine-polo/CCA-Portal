<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "coordinator");

if (isset($_GET["getFinalizedGrades"])) {
	$request = $_REQUEST;

	$academicYear = sanitize($_GET["academicYear"]);
	$semester = sanitize($_GET["semester"]);
	$classCode = sanitize($_GET["classCode"]);

	$sql = "SELECT * FROM student_subjects LEFT JOIN student_courses ON student_subjects.student_number = student_courses.student_number WHERE student_courses.academic_year = '$academicYear' AND student_courses.semester = '$semester' AND student_subjects.class_code = '$classCode' ORDER BY student_courses.lastname ASC, student_courses.firstname ASC, student_courses.middlename ASC ";

	$result = mysqli_query($conn, $sql);

	$totalData = mysqli_num_rows($result);
	$totalFilter = $totalData;

	$sql .= "LIMIT " . $request["start"] . ", " . $request["length"];

	$result = mysqli_query($conn, $sql);

	$data = [];

	$counter = 1;
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$studentNumber = $row["student_number"];

			$subdata = array();

			$subdata[] = $counter;
			$subdata[] = $row["student_number"];
			$subdata[] = strtoupper($row["lastname"]) . ", " . strtoupper($row["firstname"]) . " " . strtoupper($row["middlename"]);
			$subdata[] = $row["class_code"];

			$sql2 = "SELECT * FROM student_grades WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode' AND student_number = '$studentNumber'";
			$result2 = mysqli_query($conn, $sql2);

			if (mysqli_num_rows($result2) > 0) {
				while ($row2 = mysqli_fetch_assoc($result2)) {
					$subdata[] = "<span class='d-none'>" . $row2["final_grade"] . "</span>" . "<input class='w-100 text-center form-control' value='" . $row2["final_grade"] . "'>";
					$subdata[] = $row2["remarks"];
				}
			} else {
				$subdata[] = "<span class='d-none'></span>" . "<input class='w-100 text-center form-control' value=''>";
				$subdata[] = "";
			}

			$data[] = $subdata;

			$counter++;
		}
	}

	$jsonData = array(
		"draw"				=> intval($request['draw']),
		"recordsTotal"		=> intval($totalData),
		"recordsFiltered"	=> intval($totalFilter),
		"data"				=> $data
	);

	echo json_encode($jsonData);
}