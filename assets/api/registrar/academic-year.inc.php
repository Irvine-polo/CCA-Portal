<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "registrar");

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

	$data = array();
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$subdata = array();

			$subdata[] = $row["academic_year"];
			$subdata[] = $row["semester"];

			if ($row["is_active"] != 1) {
				$subdata[] = "<span class='badge bg-danger'>inactive</span>";
			} else {
				$subdata[] = "<span class='badge bg-success'>active</span>";
			}

			$subdata[] =	"<button type='button' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#activateModal' data-bs-name='A.Y " . $row["academic_year"] . ", " . $row["semester"] . " Semester' data-bs-href='../assets/includes/registrar/academic-year.inc.php?activateAcademicYear&id=" . $row["id"] . "'>
								<i class='fa-solid fa-toggle-on'></i>
							</button>";

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