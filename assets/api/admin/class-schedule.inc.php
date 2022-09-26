<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "admin");

if (isset($_GET["getAcademicYears"])) {
	$request = $_REQUEST;

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

	$data = [];
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$subdata = array();

			$subdata[] = $row["academic_year"];
			$subdata[] = $row["semester"];

			$academicYear = $row["academic_year"];
			$semester = $row["semester"];

			$sql2 = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' LIMIT 1";
			$result2 = mysqli_query($conn, $sql2);
			
			if (mysqli_num_rows($result2) > 0) {
				$subdata[] = "<span class='badge bg-success'>imported</span>";
			} else {
				$subdata[] = "<span class='badge bg-secondary'>not imported</span>";
			}

			$subdata[] = "<a class='btn btn-success btn-sm' href='./import/class-schedules?academicYear=" . $academicYear . "&semester=" . $semester . "' title='import/reimport'>
				<i class='fa-solid fa-upload'></i>
			</a>";

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