<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "admin");

if (isset($_POST["submitImportFreshmenApplicantProfiles"])) {
	$data = [];

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

		$academicYear = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[0]));
		$controlNumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[1]));
		$fullname = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[2]));
		$course = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[3]));
		$emailAddress = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[4]));
		$address = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[5]));
		$barangay = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[6]));
		$city = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[7]));
		$contactNumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[8]));
		$age = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[8]));
		$civilStatus = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[10]));
		$sex = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[11]));
		$nationality = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[12]));
		$religion = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[13]));
		$isPWD = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[14]));
		$placeOfBirth = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[15]));
		$password = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[16]));
		$appliedAt = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[17]));
		$expiredAt = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[18]));

		$password = password_hash($password, PASSWORD_DEFAULT);
		
		if ($controlNumber == "" || $controlNumber == "0") {
		    continue;
		}

		$sql = "SELECT * FROM applicant_profiles WHERE academic_year = '$academicYear' AND control_number = '$controlNumber'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			$sql2 = "UPDATE applicant_profiles SET 
				fullname = '$fullname',
				course = '$course',
				address = '$address',
				barangay = '$barangay',
				city = '$city',
				contact_number = '$contactNumber',
				age = '$age',
				civil_status = '$civilStatus',
				sex = '$sex',
				nationality = '$nationality',
				religion = '$religion',
				is_pwd = '$isPWD',
				place_of_birth = '$placeOfBirth',
				password = '$password',
				applied_at = '$appliedAt',
				expired_at = '$expiredAt'
				WHERE control_number = '$controlNumber' AND academic_year = '$academicYear'
			";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Update <b>APPLICANTS' PROFILES</b> error";

				echo json_encode($data);
				exit();
			}
		} else {
			$sql2 = "INSERT INTO applicant_profiles (academic_year, control_number, fullname, course, email_address, address, barangay, city, contact_number, age, civil_status, sex, nationality, religion, is_pwd, place_of_birth, password, applied_at, expired_at) VALUES ('$academicYear', '$controlNumber', '$fullname', '$course', '$emailAddress', '$address', '$barangay', '$city', '$contactNumber', '$age', '$civilStatus', '$sex', '$nationality', '$religion', '$isPWD', '$placeOfBirth', '$password', '$appliedAt', '$expiredAt')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>APPLICANTS' PROFILES</b> error";

				echo json_encode($data);
				exit();
			}
		}
	}
	
	$data["type"] = "success";
	$data["value"] = "Imported <b>APPLICANTS' PROFILES</b> successfully";

	echo json_encode($data);
	exit();
}

if (isset($_POST["submitImportFreshmenApplicantEducationalBackgrounds"])) {
	$data = [];

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

		$academicYear = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[0]));
		$controlNumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[1]));
		$fullname = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[2]));
		$typeOfApplicant = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[3]));
		$currentG12School = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[4]));
		$currentG12GraduationYear = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[5]));
		$graduateG12School = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[6]));
		$graduateG12GraduationYear = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[7]));
		$graduateHsSchool = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[8]));
		$graduateHsGraduationYear = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[9]));
		$graduateCollegeLastSchool = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[10]));
		$graduateCollegeLastGraduationYear = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[11]));
		$graduateCollegeHsOrShsSchool = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[12]));
		$graduateCollegeHsOrShsGraduationYear = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[13]));
		$graduateAlsYearPassed = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[14]));
		$appliedAt = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[15]));
		
		if ($controlNumber == "" || $controlNumber == "0") {
		    continue;
		}

		$sql = "SELECT * FROM applicant_educational_backgrounds WHERE academic_year = '$academicYear' AND control_number = '$controlNumber'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			$sql2 = "UPDATE applicant_educational_backgrounds SET 
				fullname = '$fullname',
				type_of_applicant = '$typeOfApplicant',
				current_g12_school = '$currentG12School',
				current_g12_graduation_year = '$currentG12GraduationYear',
				graduate_g12_school = '$graduateG12School',
				graduate_g12_graduation_year = '$graduateG12GraduationYear',
				graduate_hs_school = '$graduateHsSchool',
				graduate_hs_graduation_year = '$graduateHsGraduationYear',
				graduate_college_last_school = '$graduateCollegeLastSchool',
				graduate_college_last_graduation_year = '$graduateCollegeLastGraduationYear',
				graduate_college_hs_or_shs_school = '$graduateCollegeHsOrShsSchool',
				graduate_college_hs_or_shs_graduation_year = '$graduateCollegeHsOrShsGraduationYear',
				graduate_als_year_passed = '$graduateAlsYearPassed',
				applied_at = '$appliedAt'
				WHERE control_number = '$controlNumber' AND academic_year = '$academicYear'
			";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Update <b>APPLICANTS' EDUCATIONAL BACKGROUNDS</b> error";

				echo json_encode($data);
				exit();
			}
		} else {
			$sql2 = "INSERT INTO applicant_educational_backgrounds (academic_year, control_number, fullname, type_of_applicant, current_g12_school, current_g12_graduation_year, graduate_g12_school, graduate_g12_graduation_year, graduate_hs_school, graduate_hs_graduation_year, graduate_college_last_school, graduate_college_last_graduation_year, graduate_college_hs_or_shs_school, graduate_college_hs_or_shs_graduation_year, graduate_als_year_passed, applied_at) VALUES ('$academicYear', '$controlNumber', '$fullname', '$typeOfApplicant', '$currentG12School', '$currentG12GraduationYear', '$graduateG12School', '$graduateG12GraduationYear', '$graduateHsSchool', '$graduateHsGraduationYear', '$graduateCollegeLastSchool', '$graduateCollegeLastGraduationYear', '$graduateCollegeHsOrShsSchool', '$graduateCollegeHsOrShsGraduationYear', '$graduateAlsYearPassed', '$appliedAt')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>APPLICANTS' EDUCATIONAL BACKGROUNDS</b> error";

				echo json_encode($data);
				exit();
			}
		}
	}
	
	$data["type"] = "success";
	$data["value"] = "Imported <b>APPLICANTS' EDUCATIONAL BACKGROUNDS</b> successfully";

	echo json_encode($data);
	exit();
}

if (isset($_POST["submitImportFreshmenApplicantEmergencyInformations"])) {
	$data = [];

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

		$academicYear = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[0]));
		$controlNumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[1]));
		$fullname = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[2]));
		$nameOfGuardian = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[3]));
		$relationshipWithGuardian = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[4]));
		$addressOfGuardian = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[5]));
		$emailAddressOfGuardian = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[6]));
		$contactNumberOfGuardian = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[7]));
		$occupationOfGuardian = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[8]));
		$appliedAt = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', sanitize($row[9]));
		
		if ($controlNumber == "" || $controlNumber == "0") {
		    continue;
		}

		$sql = "SELECT * FROM applicant_emergency_informations WHERE academic_year = '$academicYear' AND control_number = '$controlNumber'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			$sql2 = "UPDATE applicant_emergency_informations SET 
				fullname = '$fullname',
				name_of_guardian = '$nameOfGuardian',
				relationship_with_guardian = '$relationshipWithGuardian',
				address_of_guardian = '$addressOfGuardian',
				email_address_of_guardian = '$emailAddressOfGuardian',
				contact_number_of_guardian = '$contactNumberOfGuardian',
				occupation_of_guardian = '$occupationOfGuardian',
				applied_at = '$appliedAt'
				WHERE control_number = '$controlNumber' AND academic_year = '$academicYear'
			";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Update <b>APPLICANTS' EMERGENCY INFORMATIONS</b> error";

				echo json_encode($data);
				exit();
			}
		} else {
			$sql2 = "INSERT INTO applicant_emergency_informations (academic_year, control_number, fullname, name_of_guardian, relationship_with_guardian, address_of_guardian, email_address_of_guardian, contact_number_of_guardian, occupation_of_guardian, applied_at) VALUES ('$academicYear', '$controlNumber', '$fullname', '$nameOfGuardian', '$relationshipWithGuardian', '$addressOfGuardian', '$emailAddressOfGuardian', '$contactNumberOfGuardian', '$occupationOfGuardian', '$appliedAt')";
			
			if (!mysqli_query($conn, $sql2)) {
				$data["type"] = "error";
				$data["value"] = "Import <b>APPLICANTS' EMERGENCY INFORMATIONS</b> error";

				echo json_encode($data);
				exit();
			}
		}
	}
	
	$data["type"] = "success";
	$data["value"] = "Imported <b>APPLICANTS' EMERGENCY INFORMATIONS</b> successfully";

	echo json_encode($data);
	exit();
}