<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "admin");

if (isset($_GET["getCourses"])) {
	$academicYearFull = sanitize($_GET["academicYearFull"]);

	echo "<div class='card d-print-none'>
		<div class='card-body'>
			<h5 class='card-title'>Courses</h5>

			<div class='d-flex justify-content-between align-items-center'>
				<select class='form-select w-auto' id='coursesSelect'>";

					$sql = "SELECT * FROM student_courses WHERE CONCAT(academic_year, ' ', semester) LIKE '%$academicYearFull%' GROUP BY course ORDER BY course ASC";
					$result = mysqli_query($conn, $sql);
					
					if (mysqli_num_rows($result) > 0) {
						echo "<option value='select'>--Select Course--</option>";

						while ($row = mysqli_fetch_assoc($result)) {
							echo "<option value='" . $row["course"] . "'>" . properCaseCourse($row["course"]) . "</option>";
						}
					} else {
						echo "<option value=''>No Courses available</option>";
					}

				echo "</select>

				<div  class='d-flex justify-content-between align-items-center'>
					<label>Order By:&nbsp;</label>
					<select class='form-select w-auto' id='sortHonorStudentsSelect'>
						<option value='name'>Name</option>
						<option value='gwa'>GWA</option>
					</select>
				</div>
			</div>
		</div>
	</div>";
}

if (isset($_GET["getHonorStudents"])) {
	$academicYearFull = sanitize($_GET["academicYearFull"]);
	$course = sanitize($_GET["course"]);
	$sortHonorStudentsSelect = sanitize($_GET["sortHonorStudentsSelect"]);

	$academicYear = explode(" ", $academicYearFull);
	$academicYear = current($academicYear);
	$semester = explode(" ", $academicYearFull);
	$semester = end($semester);

	$semesterFull = $semester;

	if ($semester != "Summer") {
		$semesterFull .= " Semester";
	}

	if ($course == "select") {
		echo "<div class='card cca-card'>
			<div class='card-body text-center'>
				Select Course
			</div>
		</div>";
	} else {
		$sql = "SELECT * FROM student_courses WHERE CONCAT(academic_year, ' ', semester) LIKE '%$academicYearFull%' AND course = '$course' AND status = 'regular' ORDER BY course ASC, lastname ASC, firstname ASC, middlename ASC";
		$result = mysqli_query($conn, $sql);

		$honorStudents = array();

		echo "<div class='card cca-card'>
			<div class='card-body'>
				<div class='text-center'>
					<img class='w-90px' src='../assets/images/photos/cca-logo.png'>

					<h4 class='fw-bold mb-1'>CITY COLLEGE OF ANGELES</h4>
					<h5 class='text-uppercase fw-bold mb-3'>OFFICE OF THE REGISTRAR</h5>

					<h6 class='fw-bold mb-0'>LIST OF HONOR STUDENTS</h6>
					<h6 class='fw-bold small mb-3'>" . $semesterFull . ", Academic Year " . $academicYear . "</h6>
				</div>

				<h5 class='mb-2'><span class='fw-bold'>Course: </span>" . properCaseCourse($course) . "</h5>

				<div class='table-responsive mb-3'>
					<table class='table table-bordered table-border-dark table-striped table-sm w-100 small mb-0'>
						<thead class='text-center'>
							<tr class='bg-secondary text-white'>
								<th width='2%'>#</th>
								<th width='8%'>Student Number</th>
								<th>Student Name</th>
								<th>Course</th>
								<th width='11%'>Year Level</th>
								<th width='8%'>GWA</th>
								<th width='8%'>Units</th>
								<th width='8%'>Remarks</th>
							</tr>
						</thead>";

							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) {
									$academicYear = $row["academic_year"];
									$semester = $row["semester"];
									$studentNumber = $row["student_number"];
									$studentName = $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"];
									$course = $row["course"];
									$yearLevel = $row["year_level"];

									$GxU = array();
									$UNITS = array();
									$UNITS_WITH_PE = array();

									$excludedSubjects = array(
										"KAPCUL",
										"NSTP1",
										"NSTP2",
										"PE 1",
										"PE 2",
										"PE 3",
										"PE 4",
										"PE1",
										"PE2",
										"PE3",
										"PE4"
									);

									$excludedSubjectsWithPE = array(
										"KAPCUL",
										"NSTP1",
										"NSTP2"
									);

									$isLister = true;

									$sql2 = "SELECT * FROM student_grades WHERE academic_year = '$academicYear' AND semester = '$semester' AND student_number = '$studentNumber'";
									$result2 = mysqli_query($conn, $sql2);
									
									if (mysqli_num_rows($result2) > 0) {
										while ($row2 = mysqli_fetch_assoc($result2)) {
											if (!in_array(strtoupper($row2["subject_code"]), $excludedSubjects)) {
												array_push($GxU, $row2["final_grade"] * intval($row2["units"]));
												array_push($UNITS, intval($row2["units"]));
											}

											if (!in_array(strtoupper($row2["subject_code"]), $excludedSubjectsWithPE)) {
												array_push($UNITS_WITH_PE, intval($row2["units"]));
											}

											if ($row2["final_grade"] > 2.00) {
												$isLister = false;
											}
										}
									}

									if (array_sum($UNITS) != 0) {
										if ($isLister && (number_format(array_sum($GxU) / array_sum($UNITS), 2) <= 1.75)) {
											$honorStudent = array();

											$honorStudent["student_number"] = strval($studentNumber);
											$honorStudent["student_name"] = $studentName;
											$honorStudent["course"] = properCaseCourse($course);
											$honorStudent["year_level"] = $yearLevel;
											$honorStudent["GWA"] = strval(number_format(array_sum($GxU) / array_sum($UNITS), 2));
											$honorStudent["units"] = array_sum($UNITS_WITH_PE);

											if (number_format(array_sum($GxU) / array_sum($UNITS), 2) <= 1.25) {
												$honorStudent["remarks"] = "PL";
											} else if (number_format(array_sum($GxU) / array_sum($UNITS), 2) <= 1.75) {
												$honorStudent["remarks"] = "DL";
											}

											array_push($honorStudents, $honorStudent);
										}
									}
								}
							}

							if ($sortHonorStudentsSelect == "gwa") {
								array_multisort(
									array_column($honorStudents, 'GWA'), SORT_ASC,
	                				array_column($honorStudents, 'student_name'), SORT_ASC,
	                				$honorStudents
	                			);
							}

						echo "<tbody>";
							$counter = 0;

							foreach ($honorStudents as $row) {
								echo "<tr class='text-center'>";
									$counter++;

									echo "<td>" . $counter . "</td>
									<td>" . $row["student_number"] . "</td>
									<td class='text-start'>" . $row["student_name"] . "</td>
									<td class='text-start'>" . $row["course"] . "</td>
									<td>" . $row["year_level"] . "</td>
									<td>" . $row["GWA"] . "</td>
									<td>" . $row["units"] . "</td>
									<td>" . $row["remarks"] . "</td>
								</tr>";
							}

							if (count($honorStudents) == 0) {
								echo "<tr class='text-center'>
									<td colspan='100%'>No Honor Students available</td>
								</tr>";
							}

						echo "</tbody>
					</table>
				</div>

				<div class='d-flex justify-content-between align-items-center align-items-sm-between flex-row gap-2'>
					<div class='d-flex flex-column text-center mw-250px'>
						<h6 class='fw-bold m-0'>MARIA REGINA DIAZ (Esgd.)</h6>
						<hr class='m-0'>
						<small class='fw-bold'>Registrar Staff</small>
					</div>

					<div class='d-flex flex-column text-center mw-250px'>
						<h6 class='fw-bold m-0'>LESSANDRO YUZON (Esgd.)</h6>
						<hr class='m-0'>
						<small class='fw-bold'>College Registrar</small>
					</div>
				</div>

				<p class='small text-end d-none d-print-block mt-5'>" . date('m/d/Y', time()) . "</p>
			</div>
		</div>";
	}
}