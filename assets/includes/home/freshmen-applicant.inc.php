<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

if (isset($_POST["submitSignInApplicant"])) {
	$username = sanitize($_POST["username"]);
	$password = sanitize($_POST["password"]);

	$data = [];

	$sql = "SELECT * FROM applicant_profiles ORDER BY academic_year DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$academicYear = $row["academic_year"];
		}
	}

	$sql = "SELECT * FROM applicant_profiles WHERE email_address = '$username'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$hashedPassword = $row["password"];
			$expiredAt = $row["expired_at"];

			$today = date("Y-m-d", time());

			if ($expiredAt < $today) {
				$data["type"] = "error";
				$data["value"] = "Account expired";

				echo json_encode($data);
				exit();
			}

			if (!password_verify($password, $hashedPassword)) {
				$data["type"] = "error";
				$data["value"] = "Incorrect password";

				echo json_encode($data);
				exit();
			}

			session_regenerate_id();

			$_SESSION["controlNumber"] = $row["control_number"];
			$_SESSION["academicYear"] = $row["academic_year"];

			session_write_close();
		}
	} else {
		$data["type"] = "error";
		$data["value"] = "Email not found";

		echo json_encode($data);
		exit();
	}

	$data["type"] = "redirect";
	$data["value"] = "applicant/edit/application";

	echo json_encode($data);
	exit();
}

if (isset($_GET["signOut"])) {
	session_destroy();

	header("Location: " . $baseUrl . "applicant");
	exit();	
}

if (isset($_POST["submitUpdateApplicantProfile"])) {
	$controlNumber = $_SESSION["controlNumber"];
	$academicYear = $_SESSION["academicYear"];

	$fullname = sanitize($_POST["fullname"]);
	$address = sanitize($_POST["address"]);
	$barangay = sanitize($_POST["barangay"]);
	$city = sanitize($_POST["city"]);
	$contactNumber = sanitize($_POST["contactNumber"]);
	$age = sanitize($_POST["age"]);
	$civilStatus = sanitize($_POST["civilStatus"]);
	$sex = sanitize($_POST["sex"]);
	$nationality = sanitize($_POST["nationality"]);
	$religion = sanitize($_POST["religion"]);
	$isPWD = sanitize($_POST["isPWD"]);
	$placeOfBirth = sanitize($_POST["placeOfBirth"]);

	$otherBarangay = sanitize($_POST["otherBarangay"]);

	if ($barangay == "Other") {
		$barangay = $otherBarangay;
	}

	$sql = "UPDATE applicant_profiles SET
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
		place_of_birth = '$placeOfBirth'
		WHERE control_number = '$controlNumber' AND academic_year = '$academicYear';
	";

	if (!mysqli_query($conn, $sql)) {
		$data["type"] = "error";
		$data["value"] = "Update <b>APPLICANT'S PROFILE</b> error";

		echo json_encode($data);
		exit();
	}

	$data["type"] = "success";
	$data["value"] = "Updated <b>APPLICANT'S PROFILE</b> successfully";

	echo json_encode($data);
	exit();
}

if (isset($_POST["submitUpdateApplicantEducationalBackground"])) {
	$controlNumber = $_SESSION["controlNumber"];
	$academicYear = $_SESSION["academicYear"];

	$fullname = sanitize($_POST["fullname"]);
	$typeOfApplicant = sanitize($_POST["typeOfApplicant"]);
	$currentG12School = "";
	$currentG12GraduationYear = "";
	$graduateG12School = "";
	$graduateG12GraduationYear = "";
	$graduateHsSchool = "";
	$graduateHsGraduationYear = "";
	$graduateCollegeLastSchool = "";
	$graduateCollegeLastGraduationYear = "";
	$graduateCollegeHsOrShsSchool = "";
	$graduateCollegeHsOrShsGraduationYear = "";
	$graduateAlsYearPassed = "";

	if ($typeOfApplicant == "Current Grade 12") {
		$currentG12School = sanitize($_POST["currentG12School"]);
		$currentG12GraduationYear = sanitize($_POST["currentG12GraduationYear"]);
	} else if ($typeOfApplicant == "Grade 12 Graduate") {
		$graduateG12School = sanitize($_POST["graduateG12School"]);
		$graduateG12GraduationYear = sanitize($_POST["graduateG12GraduationYear"]);
	} else if ($typeOfApplicant == "High School Graduate 2016 or Earlier") {
		$graduateHsSchool = sanitize($_POST["graduateHsSchool"]);
		$graduateHsGraduationYear = sanitize($_POST["graduateHsGraduationYear"]);
	} else if ($typeOfApplicant == "College Graduate Willing to Start as Freshmen") {
		$graduateCollegeLastSchool = sanitize($_POST["graduateCollegeLastSchool"]);
		$graduateCollegeLastGraduationYear = sanitize($_POST["graduateCollegeLastGraduationYear"]);
		$graduateCollegeHsOrShsSchool = sanitize($_POST["graduateCollegeHsOrShsSchool"]);
		$graduateCollegeHsOrShsGraduationYear = sanitize($_POST["graduateCollegeHsOrShsGraduationYear"]);
	} else if ($typeOfApplicant == "ALS Graduate") {
		$graduateAlsYearPassed = sanitize($_POST["graduateAlsYearPassed"]);
	}

	$sql = "UPDATE applicant_educational_backgrounds SET 
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
		graduate_als_year_passed = '$graduateAlsYearPassed'
		WHERE control_number = '$controlNumber' AND academic_year = '$academicYear';
	";

	if (!mysqli_query($conn, $sql)) {
		$data["type"] = "error";
		$data["value"] = "Update <b>APPLICANT'S EDUCATIONAL BACKGROUND</b> error";

		echo json_encode($data);
		exit();
	}

	$data["type"] = "success";
	$data["value"] = "Updated <b>APPLICANT'S EDUCATIONAL BACKGROUND</b> successfully";

	echo json_encode($data);
	exit();
}

if (isset($_POST["submitUpdateApplicantEmergencyInformation"])) {
	$controlNumber = $_SESSION["controlNumber"];
	$academicYear = $_SESSION["academicYear"];

	$fullname = sanitize($_POST["fullname"]);
	$nameOfGuardian = sanitize($_POST["nameOfGuardian"]);
	$relationshipWithGuardian = sanitize($_POST["relationshipWithGuardian"]);
	$addressOfGuardian = sanitize($_POST["addressOfGuardian"]);
	$emailAddressOfGuardian = sanitize($_POST["emailAddressOfGuardian"]);
	$contactNumberOfGuardian = sanitize($_POST["contactNumberOfGuardian"]);
	$occupationOfGuardian = sanitize($_POST["occupationOfGuardian"]);

	$sql = "UPDATE applicant_emergency_informations SET 
		fullname = '$fullname',
		name_of_guardian = '$nameOfGuardian',
		relationship_with_guardian = '$relationshipWithGuardian',
		address_of_guardian = '$addressOfGuardian',
		email_address_of_guardian = '$emailAddressOfGuardian',
		contact_number_of_guardian = '$contactNumberOfGuardian',
		occupation_of_guardian = '$occupationOfGuardian'
		WHERE control_number = '$controlNumber' AND academic_year = '$academicYear';
	";
	
	if (!mysqli_query($conn, $sql)) {
		$data["type"] = "error";
		$data["value"] = "Update <b>APPLICANT'S EMERGENCY INFORMATION</b> error";

		echo json_encode($data);
		exit();
	}

	$data["type"] = "success";
	$data["value"] = "Updated <b>APPLICANT'S EMERGENCY INFORMATION</b> successfully";

	echo json_encode($data);
	exit();
}