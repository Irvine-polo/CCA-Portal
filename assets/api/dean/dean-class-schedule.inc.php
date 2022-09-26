<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "dean");

if (isset($_GET["getAcademicYears"])) {
	$request = $_REQUEST;
	$institute = strtoupper($_SESSION["institute"]);

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
			$subdata[] = $institute;

			if ($row["is_active"] == 1) {
				$subdata[] = "<span class='badge bg-success'>active</span>";
				$subdata[] = "<div class='btn-group'>
					<a class='btn btn-info btn-sm' href='./view/dean-class-schedules?academicYear=" . $row["academic_year"] . "&semester=" . $row["semester"] . "' title='view'>
						<i class='fa-solid fa-eye'></i>
					</a>
					<a class='btn btn-success btn-sm' href='./import/dean-class-schedules?academicYear=" . $row["academic_year"] . "&semester=" . $row["semester"] . "' title='import/reimport'>
						<i class='fa-solid fa-upload'></i>
					</a>
				</div>";

			} else {
				$subdata[] = "<span class='badge bg-danger'>inactive</span>";
				$subdata[] = "<div class='btn-group'>
					<a class='btn btn-info btn-sm' href='./view/dean-class-schedules?academicYear=" . $row["academic_year"] . "&semester=" . $row["semester"] . "' title='view'>
						<i class='fa-solid fa-eye'></i>
					</a>
					<a class='btn btn-success btn-sm disabled' href='./import/dean-class-schedules?academicYear=" . $row["academic_year"] . "&semester=" . $row["semester"] . "' title='import/reimport'>
						<i class='fa-solid fa-upload'></i>
					</a>
				</div>";
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

if (isset($_GET["getClassSchedules"])) {
	$request = $_REQUEST;
	$academicYear = sanitize($_GET["academicYear"]);
	$semester = sanitize($_GET["semester"]);
	$institute = strtoupper($_SESSION["institute"]);

	$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND institute = '$institute' ";

	if (!empty($request["search"]["value"])) {
		$sql .= "AND (class_code LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR reference_number LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR faculty_name LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR section LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR class_code LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR subject_code LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR subject_title LIKE '%" . $request["search"]["value"] . "%') ";
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
			
			$sql2 = "SELECT * FROM academic_years WHERE academic_year = '$academicYear' AND semester = '$semester' AND is_active = 1";
			$result2 = mysqli_query($conn, $sql2);
			
			if (mysqli_num_rows($result2) > 0) {
				$subdata[] = "<a class='btn btn-primary btn-sm' href='../edit/dean-class-schedule?academicYear=" . $academicYear . "&semester=" . $semester . "&id=" . $row["id"] . "'>
					<i class='fa-solid fa-pen-to-square'></i>
				</a>";
			} else {
				$subdata[] = "<a class='btn btn-primary btn-sm disabled' href='../edit/dean-class-schedule?academicYear=" . $academicYear . "&semester=" . $semester . "&id=" . $row["id"] . "'>
					<i class='fa-solid fa-pen-to-square'></i>
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