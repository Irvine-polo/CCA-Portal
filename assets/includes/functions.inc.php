<?php

function page($page, $active) {
	if ($page == $active) {
		return "active";
	}
}

function value($get) {
	if (isset($_GET[$get])) {
		return $_GET[$get];
	}
}

function selected($row, $value) {
	if ($row == $value) {
		return "selected";
	}
}

function sanitize($variable) {
	global $conn;
	
	return trim(mysqli_real_escape_string($conn, $variable));
}

function allowedRole($baseUrl, $role) {
	if ($_SESSION["role"] != $role) {
		header("Location: " . $baseUrl);
		exit();
	}
}

function alert() {
	if (isset($_GET["success"])) {
		$message = trim(htmlspecialchars($_GET["success"]));

		return "<div class='alert alert-success alert-dismissible fade show' role='alert'>
			<strong>Success!</strong> " . $message . ".
			<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
		</div>";
	}

	if (isset($_GET["error"])) {
		$message = trim(htmlspecialchars($_GET["error"]));

		return "<div class='alert alert-danger alert-dismissible alert-sm fade show' role='alert'>
			<strong>Error!</strong> " . $message . ".
			<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
		</div>";
	}
}

function sortByGWA($item1, $item2) {
    if ($item1["GWA"] == $item2["GWA"]) {
    	if ($item1["student_name"] > $item2["student_name"]) {
    		return 1;
    	} else {
    		return -1;
    	}
    } else {
    	return 0;
    }

    return ($item1["GWA"] > $item2["GWA"]) ? 1 : -1;
}

// function sortByGWA($item1, $item2) {
//     if ($item1["GWA"] == $item2["GWA"]) return 0;
//     return ($item1["GWA"] > $item2["GWA"]) ? 1 : -1;
// }

function getInstitute($course) {
	switch (strtoupper($course)) {
		case "BACHELOR OF SCIENCE IN INFORMATION SYSTEMS":
		case "BSIS":
		case "BACHELOR OF SCIENCE IN COMPUTER SCIENCE":
		case "BSCS":
		case "BACHELOR OF LIBRARY AND INFORMATION SCIENCE":
		case "BLIS":
		case "ASSOCIATE DEGREE IN COMPUTER TECHNOLOGY":
		case "ASSOCIATE IN COMPUTER TECHNOLOGY":
			$institute = "INSTITUTE OF COMPUTING STUDIES AND LIBRARY INFORMATION SCIENCE";
			break;
		case "BACHELOR OF SCIENCE IN TOURISM MANAGEMENT":
		case "BSTM":
		case "BACHELOR OF SCIENCE IN ENTREPRENEURSHIP":
		case "BSE":
		case "BACHELOR OF SCIENCE IN ACCOUNTANCY":
		case "BSA":
		case "BACHELOR OF SCIENCE IN ACCOUNTING INFORMATION SYSTEM":
		case "BSAIS":
			$institute = "INSTITUTE OF BUSINESS AND MANAGEMENT";
			break;
		case "BACHELOR OF PHYSICAL EDUCATION":
		case "BPE":
		case "BACHELOR OF TECHNICAL-VOCATIONAL TEACHER EDUCATION":
		case "BACHELOR OF TECHNICAL VOCATIONAL TEACHER EDUCATION":
		case "BTVTED":
		case "BACHELOR OF ARTS IN ENGLISH LANGUAGE STUDIES":
		case "BAELS":
		case "BACHELOR OF PERFORMING ARTS":
		case "BPA":
		case "BACHELOR OF SPECIAL NEEDS EDUCATION":
		case "BSNE":
		case "BACHELOR OF SCIENCE IN PSYCHOLOGICAL EDUCATION":
		case "BSPE":
		case "BACHELOR OF SCIENCE IN PSYCHOLOGY":
		case "BSPSYCH":
		case "BACHELOR OF SCIENCE IN MATHEMATICS":
		case "BSM":
		case "METHODS OF TEACHING":
		case "METHODS":
			$institute = "INSTITUTE OF EDUCATION, ARTS AND SCIENCES";
			break;
		default:
			$institute = "INSTITUTE NOT FOUND";
	}

	return $institute;
}

function properCaseCourse($course) {
	switch (strtoupper($course)) {
		case "BACHELOR OF SCIENCE IN INFORMATION SYSTEMS":
		case "BSIS":
			$course = "Bachelor of Science in Information Systems";
			break;
		case "BACHELOR OF SCIENCE IN COMPUTER SCIENCE":
		case "BSCS":
			$course = "Bachelor of Science in Computer Science";
			break;
		case "BACHELOR OF LIBRARY AND INFORMATION SCIENCE":
		case "BLIS":
			$course = "Bachelor of Library and Information Science";
			break;
		case "ASSOCIATE DEGREE IN COMPUTER TECHNOLOGY":
		case "ADCT":
		case "ASSOCIATE IN COMPUTER TECHNOLOGY":
		case "ACT":
			$course = "Associate Degree in Computer Technology";
			break;
		case "BACHELOR OF SCIENCE IN TOURISM MANAGEMENT":
		case "BSTM":
			$course = "Bachelor of Science in Tourism Management";
			break;
		case "BACHELOR OF SCIENCE IN ENTREPRENEURSHIP":
		case "BSE":
			$course = "Bachelor of Science in Entrepreneurship";
			break;
		case "BACHELOR OF SCIENCE IN ACCOUNTANCY":
		case "BSA":
			$course = "Bachelor of Science in Accountancy";
			break;
		case "BACHELOR OF SCIENCE IN ACCOUNTING INFORMATION SYSTEM":
		case "BSAIS":
			$course = "Bachelor of Science in Accounting Information System";
			break;
		case "BACHELOR OF PHYSICAL EDUCATION":
		case "BPE":
			$course = "Bachelor of Physical Education";
			break;
		case "BACHELOR OF TECHNICAL-VOCATIONAL TEACHER EDUCATION":
		case "BACHELOR OF TECHNICAL VOCATIONAL TEACHER EDUCATION":
		case "BTVTED":
			$course = "Bachelor of Technical-Vocational Teacher Education";
			break;
		case "BACHELOR OF ARTS IN ENGLISH LANGUAGE STUDIES":
		case "BAELS":
			$course = "Bachelor of Arts in English Language Studies";
			break;
		case "BACHELOR OF PERFORMING ARTS":
		case "BPA":
			$course = "Bachelor of Performing Arts";
			break;
		case "BACHELOR OF SPECIAL NEEDS EDUCATION":
		case "BSNE":
			$course = "Bachelor of Special Needs Education";
			break;
		case "BACHELOR OF SCIENCE IN PSYCHOLOGICAL EDUCATION":
		case "BSPE":
			$course = "Bachelor of Science in Psychological Education";
			break;
		case "BACHELOR OF SCIENCE IN PSYCHOLOGY":
		case "BSPSYCH":
			$course = "Bachelor of Science in Psychology";
			break;
		case "BACHELOR OF SCIENCE IN MATHEMATICS":
		case "BSM":
			$course = "Bachelor of Science in Mathematics";
			break;
		case "METHODS OF TEACHING":
		case "METHODS":
			$course = "Methods of Teaching";
			break;
		default:
			$course = "Course Not Found";
	}

	return $course;
}

function getPercentageGrade($grade) {
	if($grade == 0) { $percentageGrade = 50;}
	if($grade == 1) { $percentageGrade = 51;}
	if($grade == 2) { $percentageGrade = 51;}
	if($grade == 3) { $percentageGrade = 52;}
	if($grade == 4) { $percentageGrade = 52;}
	if($grade == 5) { $percentageGrade = 53;}
	if($grade == 6) { $percentageGrade = 53;}
	if($grade == 7) { $percentageGrade = 54;}
	if($grade == 8) { $percentageGrade = 54;}
	if($grade == 9) { $percentageGrade = 55;}
	if($grade == 10) { $percentageGrade = 55;}
	if($grade == 11) { $percentageGrade = 56;}
	if($grade == 12) { $percentageGrade = 56;}
	if($grade == 13) { $percentageGrade = 57;}
	if($grade == 14) { $percentageGrade = 57;}
	if($grade == 15) { $percentageGrade = 58;}
	if($grade == 16) { $percentageGrade = 58;}
	if($grade == 17) { $percentageGrade = 59;}
	if($grade == 18) { $percentageGrade = 59;}
	if($grade == 19) { $percentageGrade = 60;}
	if($grade == 20) { $percentageGrade = 60;}
	if($grade == 21) { $percentageGrade = 61;}
	if($grade == 22) { $percentageGrade = 61;}
	if($grade == 23) { $percentageGrade = 62;}
	if($grade == 24) { $percentageGrade = 62;}
	if($grade == 25) { $percentageGrade = 63;}
	if($grade == 26) { $percentageGrade = 63;}
	if($grade == 27) { $percentageGrade = 64;}
	if($grade == 28) { $percentageGrade = 64;}
	if($grade == 29) { $percentageGrade = 65;}
	if($grade == 30) { $percentageGrade = 65;}
	if($grade == 31) { $percentageGrade = 66;}
	if($grade == 32) { $percentageGrade = 66;}
	if($grade == 33) { $percentageGrade = 67;}
	if($grade == 34) { $percentageGrade = 67;}
	if($grade == 35) { $percentageGrade = 68;}
	if($grade == 36) { $percentageGrade = 68;}
	if($grade == 37) { $percentageGrade = 69;}
	if($grade == 38) { $percentageGrade = 69;}
	if($grade == 39) { $percentageGrade = 70;}
	if($grade == 40) { $percentageGrade = 70;}
	if($grade == 41) { $percentageGrade = 71;}
	if($grade == 42) { $percentageGrade = 71;}
	if($grade == 43) { $percentageGrade = 72;}
	if($grade == 44) { $percentageGrade = 72;}
	if($grade == 45) { $percentageGrade = 73;}
	if($grade == 46) { $percentageGrade = 73;}
	if($grade == 47) { $percentageGrade = 74;}
	if($grade == 48) { $percentageGrade = 74;}
	if($grade == 49) { $percentageGrade = 74;}
	if($grade == 50) { $percentageGrade = 75;}
	if($grade == 51) { $percentageGrade = 75;}
	if($grade == 52) { $percentageGrade = 76;}
	if($grade == 53) { $percentageGrade = 76;}
	if($grade == 54) { $percentageGrade = 76;}
	if($grade == 55) { $percentageGrade = 76;}
	if($grade == 56) { $percentageGrade = 77;}
	if($grade == 57) { $percentageGrade = 77;}
	if($grade == 58) { $percentageGrade = 77;}
	if($grade == 59) { $percentageGrade = 78;}
	if($grade == 60) { $percentageGrade = 78;}
	if($grade == 61) { $percentageGrade = 78;}
	if($grade == 62) { $percentageGrade = 79;}
	if($grade == 63) { $percentageGrade = 79;}
	if($grade == 64) { $percentageGrade = 80;}
	if($grade == 65) { $percentageGrade = 80;}
	if($grade == 66) { $percentageGrade = 81;}
	if($grade == 67) { $percentageGrade = 81;}
	if($grade == 68) { $percentageGrade = 82;}
	if($grade == 69) { $percentageGrade = 82;}
	if($grade == 70) { $percentageGrade = 83;}
	if($grade == 71) { $percentageGrade = 83;}
	if($grade == 72) { $percentageGrade = 84;}
	if($grade == 73) { $percentageGrade = 84;}
	if($grade == 74) { $percentageGrade = 85;}
	if($grade == 75) { $percentageGrade = 85;}
	if($grade == 76) { $percentageGrade = 86;}
	if($grade == 77) { $percentageGrade = 86;}
	if($grade == 78) { $percentageGrade = 87;}
	if($grade == 79) { $percentageGrade = 87;}
	if($grade == 80) { $percentageGrade = 88;}
	if($grade == 81) { $percentageGrade = 88;}
	if($grade == 82) { $percentageGrade = 89;}
	if($grade == 83) { $percentageGrade = 89;}
	if($grade == 84) { $percentageGrade = 90;}
	if($grade == 85) { $percentageGrade = 90;}
	if($grade == 86) { $percentageGrade = 91;}
	if($grade == 87) { $percentageGrade = 91;}
	if($grade == 88) { $percentageGrade = 92;}
	if($grade == 89) { $percentageGrade = 92;}
	if($grade == 90) { $percentageGrade = 93;}
	if($grade == 91) { $percentageGrade = 93;}
	if($grade == 92) { $percentageGrade = 94;}
	if($grade == 93) { $percentageGrade = 94;}
	if($grade == 94) { $percentageGrade = 95;}
	if($grade == 95) { $percentageGrade = 95;}
	if($grade == 96) { $percentageGrade = 96;}
	if($grade == 97) { $percentageGrade = 97;}
	if($grade == 98) { $percentageGrade = 98;}
	if($grade == 99) { $percentageGrade = 99;}
	if($grade == 100) { $percentageGrade = 100;}

	return $percentageGrade;
}

function getEquivalent($grade) {
	$percentageGrade = getPercentageGrade($grade);

	if ($percentageGrade == 50) { $equivalent = 5.00;}
	if ($percentageGrade == 51) { $equivalent = 5.00;}
	if ($percentageGrade == 52) { $equivalent = 5.00;}
	if ($percentageGrade == 53) { $equivalent = 5.00;}
	if ($percentageGrade == 54) { $equivalent = 5.00;}
	if ($percentageGrade == 55) { $equivalent = 5.00;}
	if ($percentageGrade == 56) { $equivalent = 5.00;}
	if ($percentageGrade == 57) { $equivalent = 5.00;}
	if ($percentageGrade == 58) { $equivalent = 5.00;}
	if ($percentageGrade == 59) { $equivalent = 5.00;}
	if ($percentageGrade == 60) { $equivalent = 5.00;}
	if ($percentageGrade == 61) { $equivalent = 5.00;}
	if ($percentageGrade == 62) { $equivalent = 5.00;}
	if ($percentageGrade == 63) { $equivalent = 5.00;}
	if ($percentageGrade == 64) { $equivalent = 5.00;}
	if ($percentageGrade == 65) { $equivalent = 5.00;}
	if ($percentageGrade == 66) { $equivalent = 5.00;}
	if ($percentageGrade == 67) { $equivalent = 5.00;}
	if ($percentageGrade == 68) { $equivalent = 5.00;}
	if ($percentageGrade == 69) { $equivalent = 5.00;}
	if ($percentageGrade == 70) { $equivalent = 5.00;}
	if ($percentageGrade == 71) { $equivalent = 5.00;}
	if ($percentageGrade == 72) { $equivalent = 5.00;}
	if ($percentageGrade == 73) { $equivalent = 5.00;}
	if ($percentageGrade == 74) { $equivalent = 5.00;}
	if ($percentageGrade == 75) { $equivalent = 3.00;}
	if ($percentageGrade == 76) { $equivalent = 2.75;}
	if ($percentageGrade == 77) { $equivalent = 2.75;}
	if ($percentageGrade == 78) { $equivalent = 2.75;}
	if ($percentageGrade == 79) { $equivalent = 2.50;}
	if ($percentageGrade == 80) { $equivalent = 2.50;}
	if ($percentageGrade == 81) { $equivalent = 2.50;}
	if ($percentageGrade == 82) { $equivalent = 2.25;}
	if ($percentageGrade == 83) { $equivalent = 2.25;}
	if ($percentageGrade == 84) { $equivalent = 2.25;}
	if ($percentageGrade == 85) { $equivalent = 2.00;}
	if ($percentageGrade == 86) { $equivalent = 2.00;}
	if ($percentageGrade == 87) { $equivalent = 2.00;}
	if ($percentageGrade == 88) { $equivalent = 1.75;}
	if ($percentageGrade == 89) { $equivalent = 1.75;}
	if ($percentageGrade == 90) { $equivalent = 1.75;}
	if ($percentageGrade == 91) { $equivalent = 1.50;}
	if ($percentageGrade == 92) { $equivalent = 1.50;}
	if ($percentageGrade == 93) { $equivalent = 1.50;}
	if ($percentageGrade == 94) { $equivalent = 1.25;}
	if ($percentageGrade == 95) { $equivalent = 1.25;}
	if ($percentageGrade == 96) { $equivalent = 1.25;}
	if ($percentageGrade == 97) { $equivalent = 1.00;}
	if ($percentageGrade == 98) { $equivalent = 1.00;}
	if ($percentageGrade == 99) { $equivalent = 1.00;}
	if ($percentageGrade == 100) { $equivalent = 1.00;}

	return number_format($equivalent, 2);
}

function getRemarks($grade) {
	$equivalent = getEquivalent($grade);

	if ($equivalent <= 3.00) {
		$remarks = "PASSED";
	}

	if ($equivalent == 5.00) {
		$remarks = "FAILED";
	}

	if ($equivalent == 6.00) {
		$remarks = "FA";
	}

	if ($equivalent == 7.00) {
		$remarks = "NFE";
	}

	if ($equivalent == 8.00) {
		$remarks = "UW";
	}

	if ($equivalent == 9.00) {
		$remarks = "DROPPED";
	}

	if ($equivalent == "LOA") {
		$remarks = "LOA";
	}

	return $remarks;
}

function getClassRecordType($subjectCode) {
	switch (strtoupper($subjectCode)) {
		case "7ISPRAC":
			$classRecordType = "ICSLIS Lec";
			break;
		case "":
			$classRecordType = "ICSLIS Lec Lab";
			break;
		case "":
			$classRecordType = "ICSLIS Cisco";
			break;
		case "":
			$classRecordType = "IEAS";
			break;
		case "":
			$classRecordType = "IBM";
			break;
		default:
			$classRecordType = "No Class Record";
	}

	return $classRecordType;
}