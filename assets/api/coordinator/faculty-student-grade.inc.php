<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "coordinator");

if (isset($_GET["getAcademicYears"])) {
	$request = $_REQUEST;

	$referenceNumber = $_SESSION["username"];

	$sql = "SELECT * FROM class_schedules WHERE (reference_number = '$referenceNumber' OR substitute_reference_number = '$referenceNumber') ";

	if (!empty($request["search"]["value"])) {
		$sql .= "AND CONCAT(academic_year, ' ', semester) LIKE '%" . $request["search"]["value"] . "%' ";
	}

	$result = mysqli_query($conn, $sql);

	$totalData = mysqli_num_rows($result);
	$totalFilter = $totalData;

	$sql .= "GROUP BY academic_year, semester ";
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

			$sql2 = "SELECT * FROM academic_years WHERE academic_year = '$academicYear' AND semester = '$semester'";
			$result2 = mysqli_query($conn, $sql2);
			
			if (mysqli_num_rows($result2) > 0) {
				while ($row2 = mysqli_fetch_assoc($result2)) {
					if ($row2["is_active"] == 1) {
						$subdata[] = "<span class='badge bg-success'>active</span>";
						$subdata[] = "<a class='btn btn-info btn-sm' href='./view/faculty-student-grades?academicYear=" . $academicYear . "&semester=" . $semester . "' title='view'>
							<i class='fa-solid fa-eye'></i>
						</a>";
					} else {
						$subdata[] = "<span class='badge bg-danger'>inactive</span>";
						$subdata[] = "<a class='btn btn-info btn-sm' href='./view/faculty-student-grades?academicYear=" . $academicYear . "&semester=" . $semester . "' title='view'>
							<i class='fa-solid fa-eye'></i>
						</a>";
					}
				}
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

	$referenceNumber = $_SESSION["username"];

	$academicYear = sanitize($_GET["academicYear"]);
	$semester = sanitize($_GET["semester"]);

	$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND (reference_number = '$referenceNumber' OR substitute_reference_number = '$referenceNumber') ";

	if (!empty($request["search"]["value"])) {
		$sql .= "AND (coordinator_name LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR class_code LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR status LIKE '%" . $request["search"]["value"] . "%') ";
	}

	$result = mysqli_query($conn, $sql);

	$totalData = mysqli_num_rows($result);
	$totalFilter = $totalData;

	$sql .= "ORDER BY class_code ASC ";
	$sql .= "LIMIT " . $request["start"] . ", " . $request["length"];

	$result = mysqli_query($conn, $sql);

	$data = array();
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$subdata = array();

			$subdata[] = $row["academic_year"];
			$subdata[] = $row["semester"];
			$subdata[] = $row["section"];
			$subdata[] = $row["class_code"];
			$subdata[] = $row["subject_code"];

			if ($row["status"] == "finalized") {
				$subdata[] = "<span class='badge bg-success'>finalized</span>";
				$subdata[] = 	"<div class='btn-group'>
									<a class='btn btn-success btn-sm disabled' href='../import/faculty-finalized-grades?academicYear=" . $academicYear . "&semester=" . $semester . "&classCode=" . $row["class_code"] . "' title='import/reimport'>
										<i class='fa-solid fa-upload'></i>
									</a>
									<a class='btn btn-info btn-sm' href='./faculty-finalized-grades?academicYear=" . $academicYear . "&semester=" . $semester . "&classCode=" . $row["class_code"] . "' title='view'>
										<i class='fa-solid fa-eye'></i>
									</a>
									<button type='button' class='btn btn-main btn-sm disabled' data-bs-toggle='modal' data-bs-target='#finalizeModal' data-bs-name='" . $row["class_code"] . "' data-bs-href='../../assets/includes/coordinator/faculty-finalized-grade.inc.php?submitfinalizeGrades&academicYear=" . $academicYear . "&semester=" . $semester . "&classCode=" . $row["class_code"] . "' title='finalize'>
										<i class='fa-solid fa-flag'></i>
									</button>
								</div>";
			} else {
				$subdata[] = "<span class='badge bg-secondary'>not finalized</span>";
				$subdata[] = "<div class='btn-group'>
					<a class='btn btn-success btn-sm' href='../import/faculty-finalized-grades?academicYear=" . $academicYear . "&semester=" . $semester . "&classCode=" . $row["class_code"] . "' title='import/reimport'>
						<i class='fa-solid fa-upload'></i>
					</a>
					<a class='btn btn-info btn-sm' href='../edit/faculty-finalized-grades?academicYear=" . $academicYear . "&semester=" . $semester . "&classCode=" . $row["class_code"] . "' title='encode manually'>
						<i class='fa-solid fa-pen-to-square'></i>
					</a>
					<button type='button' class='btn btn-main btn-sm' data-bs-toggle='modal' data-bs-target='#finalizeModal' data-bs-name='" . $row["class_code"] . "' data-bs-href='../../assets/includes/coordinator/faculty-finalized-grade.inc.php?submitfinalizeGrades&academicYear=" . $academicYear . "&semester=" . $semester . "&classCode=" . $row["class_code"] . "' title='finalize'>
						<i class='fa-solid fa-flag'></i>
					</button>
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