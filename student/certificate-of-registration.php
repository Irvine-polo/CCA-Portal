<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "certificateOfRegistration";

include $baseUrl . "assets/templates/student/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Certificate of Registration</h1>

	<button class="btn btn-primary d-flex justify-content-between align-items-center" onclick="window.print();">
		<i class="fa-solid fa-print me-2"></i>
		Print
	</button>
</div>

<?php

$sql = "SELECT * FROM academic_years WHERE is_active = 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$academicYear = $row["academic_year"];
		$semester = $row["semester"];
	}
}

$studentNumber = $_SESSION["username"];

$sql = "SELECT * FROM student_courses WHERE academic_year = '$academicYear' AND semester = '$semester' AND student_number = '$studentNumber'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$institute = getInstitute($row["course"]);

		echo "<div class='card cca-card'>
			<div class='card-body'>
				<div class='text-center'>
					<img class='w-90px' src='../assets/images/photos/cca-logo.png'>

					<h4 class='fw-bold mb-1'>CITY COLLEGE OF ANGELES</h4>
					<h5 class='text-uppercase fw-bold mb-3'>" . $institute . "</h5>

					<h6 class='fw-bold mb-0'>CERTIFICATE OF REGISTRATION</h6>
					<h6 class='fw-bold small mb-3'>" . $semester . " Semester, Academic Year " . $academicYear . "</h6>
				</div>

				<div class='table-responsive mb-3'>
					<table class='table table-bordered table-border-dark table-striped table-sm small w-100 mb-0'>
						<thead class='text-center'>
							<tr class='tr-none'>
								<th width='5%'></th>
								<th width='9%'></th>
								<th width='20%'></th>
								<th width='4%'></th>
								<th width='4%'></th>
								<th width='4%'></th>
								<th width='5%'></th>
								<th width='12%'></th>
								<th width='5%'></th>
								<th width='12%'></th>
								<th width='10%'></th>
								<th width='10%'></th>
							</tr>
							<tr class='bg-secondary text-white'>
								<th colspan='2'>STUDENT NUMBER</th>
								<th>STUDENT NAME</th>
								<th colspan='4'>COURSE</th>
								<th>YEAR LEVEL</th>
								<th>SEX</th>
								<th>STATUS</th>
								<th>SECTION</th>
								<th>PWD</th>
							</tr>
							<tr>
								<th colspan='2'>" . $row["student_number"] . "</th>
								<th class='text-uppercase'>" . $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "</th>
								<th colspan='4'>" . properCaseCourse($row["course"]) . "</th>
								<th>" . $row["year_level"] . "</th>
								<th>" . $row["sex"] . "</th>
								<th>" . $row["status"] . "</th>
								<th>" . $row["section"] . "</th>
								<th>" . $row["is_pwd"] . "</th>
							</tr>
							<tr>
								<th class='bg-gray-100' colspan='100%'>ENROLLED SUBJECTS</th>
							</tr>
						</thead>

						<tbody class='text-center'>
							<tr>
								<th rowspan='2'>CLASS CODE</th>
								<th rowspan='2'>COURSE CODE</th>
								<th rowspan='2'>COURSE TITLE</th>
								<th rowspan='2'>LEC <span class='text-xs'>HOURS</span></th>
								<th rowspan='2'>LAB <span class='text-xs'>HOURS</span></th>
								<th rowspan='2'><small>UNITS</small></th>
								<th colspan='2'>SYNCHRONOUS</th>
								<th colspan='2'>ASYNCHRONOUS</th>
								<th colspan='2' rowspan='2'>INSTRUCTOR</th>
							</tr>
							<tr>
								<th>DAY</th>
								<th>TIME</th>
								<th>DAY</th>
								<th>TIME</th>
							</tr>";

							$sql2 = "SELECT * FROM student_subjects WHERE academic_year = '$academicYear' AND semester = '$semester' AND student_number = '$studentNumber'";
							$result2 = mysqli_query($conn, $sql2);

							$totalLecHours = 0;
							$totalLabHours = 0;
							$totalUnits = 0;
							
							if (mysqli_num_rows($result2) > 0) {
								while ($row2 = mysqli_fetch_assoc($result2)) {
									$classCode = $row2["class_code"];

									$sql3 = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode' ORDER BY class_code ASC";
									$result3 = mysqli_query($conn, $sql3);
									
									if (mysqli_num_rows($result3) > 0) {
										while ($row3 = mysqli_fetch_assoc($result3)) {
											$totalLecHours += $row3["lec_hours"];
											$totalLabHours += $row3["lab_hours"];

											$excludedSubjects = array(
												"NSTP1",
												"NSTP2"
											);

											if (!in_array(strtoupper($row3["subject_code"]), $excludedSubjects)) {
												$totalUnits += preg_replace('/\(|\)/', '', trim(htmlspecialchars($row3["units"])));
											} else {
												if ($institute == "INSTITUTE OF BUSINESS AND MANAGEMENT") {
													$totalUnits += preg_replace('/\(|\)/', '', trim(htmlspecialchars($row3["units"])));	
												}
											}

											echo "<tr>
												<td>" . $row3["class_code"] . "</td>
												<td class='text-uppercase'>" . $row3["subject_code"] . "</td>
												<td class='text-start'>" . $row3["subject_title"] . "</td>
												<td>" . $row3["lec_hours"] . "</td>
												<td>" . $row3["lab_hours"] . "</td>
												<td>" . $row3["units"] . "</td>
												<td>" . $row3["sync_day"] . "</td>
												<td>" . $row3["sync_time"] . "</td>
												<td>" . $row3["async_day"] . "</td>
												<td>" . $row3["async_time"] . "</td>
												<td class='text-start text-uppercase' colspan='2'>" . $row3["faculty_name"] . "</td>
											</tr>";
										}
									}
								}
							}

						echo "</tbody>

						<tfoot>
							<tr>
								<th class='bg-white' colspan='2'></th>
								<th class='bg-white text-end'>Total</th>
								<th class='bg-white text-center'>" . $totalLecHours . "</th>
								<th class='bg-white text-center'>" . $totalLabHours . "</th>
								<th class='bg-white text-center'>" . $totalUnits . "</th>
								<th class='bg-white' colspan='6'></th>
							</tr>
						</tfoot>
					</table>
				</div>

				<div class='d-flex justify-content-between align-items-center align-items-sm-between flex-row gap-2'>
					<div class='d-flex flex-column text-center mw-250px'>
						<h6 class='text-uppercase fw-bold m-0'>" . $row["firstname"] . " " . $row["middlename"] . " " . $row["lastname"] . "</h6>
						<hr class='m-0'>
						<small class='fw-bold'>Student Signature</small>
					</div>

					<div class='d-flex flex-column text-center mw-250px'>
						<h6 class='fw-bold m-0'>LESSANDRO YUZON (Esgd.)</h6>
						<hr class='m-0'>
						<small class='fw-bold'>Registrar's Approval</small>
					</div>
				</div>
			</div>
		</div>";
	}
} else {
	echo "<div class='card'>
		<div class='card-body text-center'>
			Not Enrolled!
		</div>
	</div>";
}

?>

<?php

include $baseUrl . "assets/templates/student/footer.inc.php";

?>