<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "admin");

if (isset($_GET["freshmenApplicantProfiles"])) {
	$request = $_REQUEST;

	$academicYear = "";

	if (isset($_POST["academicYear"])) {
		$academicYear = $_POST["academicYear"];
	}

	$sql = "SELECT * FROM applicant_profiles WHERE academic_year = '$academicYear' ";

	if (!empty($request["search"]["value"])) {
		$sql .= "AND (control_number LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR fullname LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR course LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR email_address LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR address LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR barangay LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR city LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR contact_number LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR age LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR civil_status LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR sex LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR nationality LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR religion LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR is_pwd LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR place_of_birth LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR applied_at LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR expired_at LIKE '%" . $request["search"]["value"] . "%') ";
	}

	if (!($_POST["dateStart"] == "" && $_POST["dateEnd"] == "")) {
		$dateStart = $_POST["dateStart"];
		$dateEnd = $_POST["dateEnd"];

		$sql .= "AND applied_at BETWEEN '$dateStart' AND '$dateEnd' ";
	}

	$result = mysqli_query($conn, $sql);

	$totalData = mysqli_num_rows($result);
	$totalFilter = $totalData;

	$sql .= "ORDER BY control_number ASC ";
	$sql .= "LIMIT " . $request["start"] . ", " . $request["length"];

	$result = mysqli_query($conn, $sql);

	$data = [];
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$subdata = array();

			$subdata[] = $row["academic_year"];
			$subdata[] = $row["control_number"];
			$subdata[] = $row["fullname"];
			$subdata[] = $row["course"];
			$subdata[] = $row["email_address"];
			$subdata[] = $row["address"];
			$subdata[] = $row["barangay"];
			$subdata[] = $row["city"];
			$subdata[] = $row["contact_number"];
			$subdata[] = $row["age"];
			$subdata[] = $row["civil_status"];
			$subdata[] = $row["sex"];
			$subdata[] = $row["nationality"];
			$subdata[] = $row["religion"];
			$subdata[] = $row["is_pwd"];
			$subdata[] = $row["place_of_birth"];
			$subdata[] = $row["applied_at"];
			$subdata[] = $row["expired_at"];

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

if (isset($_GET["freshmenApplicantEducationalBackgrounds"])) {
	$request = $_REQUEST;

	if (isset($_POST["academicYear"])) {
		$academicYear = $_POST["academicYear"];
	}

	$sql = "SELECT * FROM applicant_educational_backgrounds WHERE academic_year = '$academicYear' ";

	if (!empty($request["search"]["value"])) {
		$sql .= "AND (control_number LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR fullname LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR type_of_applicant LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR current_g12_school LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR current_g12_graduation_year LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR graduate_g12_school LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR graduate_g12_graduation_year LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR graduate_hs_school LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR graduate_hs_graduation_year LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR graduate_college_last_school LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR graduate_college_last_graduation_year LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR graduate_college_hs_or_shs_school LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR graduate_college_hs_or_shs_graduation_year LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR graduate_als_year_passed LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR applied_at LIKE '%" . $request["search"]["value"] . "%') ";
	}

	if (!($_POST["dateStart"] == "" && $_POST["dateEnd"] == "")) {
		$dateStart = $_POST["dateStart"];
		$dateEnd = $_POST["dateEnd"];

		$sql .= "AND applied_at BETWEEN '$dateStart' AND '$dateEnd' ";
	}

	$result = mysqli_query($conn, $sql);

	$totalData = mysqli_num_rows($result);
	$totalFilter = $totalData;

	$sql .= "ORDER BY control_number ASC ";
	$sql .= "LIMIT " . $request["start"] . ", " . $request["length"];

	$result = mysqli_query($conn, $sql);

	$data = [];
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$subdata = array();

			$subdata[] = $row["academic_year"];
			$subdata[] = $row["control_number"];
			$subdata[] = $row["fullname"];
			$subdata[] = $row["type_of_applicant"];
			$subdata[] = $row["current_g12_school"];
			$subdata[] = $row["current_g12_graduation_year"];
			$subdata[] = $row["graduate_g12_school"];
			$subdata[] = $row["graduate_g12_graduation_year"];
			$subdata[] = $row["graduate_hs_school"];
			$subdata[] = $row["graduate_hs_graduation_year"];
			$subdata[] = $row["graduate_college_last_school"];
			$subdata[] = $row["graduate_college_last_graduation_year"];
			$subdata[] = $row["graduate_college_hs_or_shs_school"];
			$subdata[] = $row["graduate_college_hs_or_shs_graduation_year"];
			$subdata[] = $row["graduate_als_year_passed"];
			$subdata[] = $row["applied_at"];

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

if (isset($_GET["freshmenApplicantEmergencyInformations"])) {
	$request = $_REQUEST;

	if (isset($_POST["academicYear"])) {
		$academicYear = $_POST["academicYear"];
	}

	$sql = "SELECT * FROM applicant_emergency_informations WHERE academic_year = '$academicYear' ";

	if (!empty($request["search"]["value"])) {
		$sql .= "AND (control_number LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR fullname LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR name_of_guardian LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR relationship_with_guardian LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR address_of_guardian LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR email_address_of_guardian LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR contact_number_of_guardian LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR occupation_of_guardian LIKE '%" . $request["search"]["value"] . "%' ";
		$sql .= "OR applied_at LIKE '%" . $request["search"]["value"] . "%') ";
	}

	if (!($_POST["dateStart"] == "" && $_POST["dateEnd"] == "")) {
		$dateStart = $_POST["dateStart"];
		$dateEnd = $_POST["dateEnd"];

		$sql .= "AND applied_at BETWEEN '$dateStart' AND '$dateEnd' ";
	}

	$result = mysqli_query($conn, $sql);

	$totalData = mysqli_num_rows($result);
	$totalFilter = $totalData;

	$sql .= "ORDER BY control_number ASC ";
	$sql .= "LIMIT " . $request["start"] . ", " . $request["length"];

	$result = mysqli_query($conn, $sql);

	$data = [];
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$subdata = array();

			$subdata[] = $row["academic_year"];
			$subdata[] = $row["control_number"];
			$subdata[] = $row["fullname"];
			$subdata[] = $row["name_of_guardian"];
			$subdata[] = $row["relationship_with_guardian"];
			$subdata[] = $row["address_of_guardian"];
			$subdata[] = $row["email_address_of_guardian"];
			$subdata[] = $row["contact_number_of_guardian"];
			$subdata[] = $row["occupation_of_guardian"];
			$subdata[] = $row["applied_at"];

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