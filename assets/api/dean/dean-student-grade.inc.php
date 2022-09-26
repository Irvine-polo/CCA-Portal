<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "dean");

if (isset($_GET["getAcademicYears"])) {
	$request = $_REQUEST;
	$institute = $_SESSION["institute"];

	$sql = "SELECT * FROM academic_years ";

	if (!empty($request["search"]["value"])) {
		$sql .= "WHERE CONCAT(academic_year, ' ', semester) LIKE '%" . $request["search"]["value"] . "%' ";
	}

	$result = mysqli_query($conn, $sql);

	$totalData = mysqli_num_rows($result);
	$totalFilter = $totalData;

	$sql .= "ORDER BY CONCAT(academic_year, ' ', semester) DESC ";
	$sql .= "LIMIT " . $request["start"] . ", " . $request["length"];

	$result = mysqli_query($conn, $sql);

	$data = array();
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$subdata = array();

			$subdata[] = $row["academic_year"];
			$subdata[] = $row["semester"];

			$academicYear = $row["academic_year"];
			$semester = $row["semester"];

			$subdata[] = strtoupper($institute);

			$sql2 = "SELECT * FROM student_grades WHERE academic_year = '$academicYear' AND semester = '$semester' AND institute = '$institute' LIMIT 1";
			$result2 = mysqli_query($conn, $sql2);
			
			if (mysqli_num_rows($result2) > 0) {
				$subdata[] = "<span class='badge bg-success'>imported</span>";
				$subdata[] = "<a class='btn btn-info btn-sm' href='./view/dean-student-grades?academicYear=" . $academicYear . "&semester=" . $semester . "' title='view'>
					<i class='fa-solid fa-eye'></i>
				</a>";
			} else {
				$subdata[] = "<span class='badge bg-secondary'>not imported</span>";
				$subdata[] = "<a class='btn btn-info btn-sm' href='./view/dean-student-grades?academicYear=" . $academicYear . "&semester=" . $semester . "' title='view'>
					<i class='fa-solid fa-eye'></i>
				</a>";
			}

			$data[] = $subdata;
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

if (isset($_GET["getClassRecords"])) {
	$request = $_REQUEST;
	$institute = $_SESSION["institute"];

	$academicYear = sanitize($_GET["academicYear"]);
	$semester = sanitize($_GET["semester"]);

	$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND institute = '$institute' ";

	if (!empty($request["search"]["value"])) {
		$sql .= "AND (faculty_name LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR class_code LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR status LIKE '%" . $request["search"]["value"] . "%') ";
	}

	$result = mysqli_query($conn, $sql);

	$totalData = mysqli_num_rows($result);
	$totalFilter = $totalData;

	$sql .= "ORDER BY faculty_name ASC, class_code ASC ";
	$sql .= "LIMIT " . $request["start"] . ", " . $request["length"];

	$result = mysqli_query($conn, $sql);

	$data = array();
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$subdata = array();

			$subdata[] = $row["academic_year"];
			$subdata[] = $row["semester"];
			$subdata[] = $row["faculty_name"];
			$subdata[] = $row["class_code"];
			$subdata[] = $row["subject_title"];

			if ($row["status"] == "finalized") {
				$subdata[] = "<span class='badge bg-success'>finalized</span>";
			} else {
				$subdata[] = "<span class='badge bg-secondary'>not finalized</span>";
			}

			$data[] = $subdata;
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