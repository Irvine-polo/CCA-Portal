<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "admin");

if (isset($_GET["getStudentNumbers"])) {
	$academicYearFull = sanitize($_GET["academicYearFull"]);

	echo "<div class='card d-print-none'>
		<div class='card-body'>
			<h5 class='card-title'>Student Number</h5>

			<div class='d-flex justify-content-between align-items-center'>
				<div>
					<select class='form-select' id='studentNumberSelect' autofocus>";

						$sql = "SELECT * FROM student_grades WHERE CONCAT(academic_year, ' ', semester) LIKE '%$academicYearFull%' AND student_number <> '' AND final_grade <> '' GROUP BY student_number ORDER BY student_number ASC";
						$result = mysqli_query($conn, $sql);
						
						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								echo "<option value='" . $row["student_number"] . "'>" . $row["student_number"] . "</option>";
							}
						} else {
							echo "<option value=''>No Student Number available</option>";
						}

					echo "</select>
				</div>

				<div  class='d-flex justify-content-between align-items-center'>
					<label>Search:&nbsp;</label>
					<input class='form-control' id='studentNumberInput' type='text'>
				</div>
			</div>
		</div>
	</div>";
}

if (isset($_GET["getReportCards"])) {
	$academicYearFull = sanitize($_GET["academicYearFull"]);
	$studentNumberSelect = sanitize($_GET["studentNumberSelect"]);
	$studentNumberInput = sanitize($_GET["studentNumberInput"]);

	$studentNumber = $studentNumberInput == "" ? $studentNumberSelect : $studentNumberInput;

	if ($academicYearFull != "") {
		$sql = "SELECT * FROM student_grades WHERE CONCAT(academic_year, ' ', semester) LIKE '%$academicYearFull%' AND student_number = '$studentNumber' GROUP BY CONCAT(academic_year, ' ', semester) ORDER BY CONCAT(academic_year, ' ', semester) ASC";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$academic_year = $row["academic_year"];
				$semester = $row["semester"];

				echo "<div class='card cca-card'>
					<div class='card-body'>
						<div class='text-center'>
							<img class='w-90px' src='../assets/images/photos/cca-logo.png'>

							<h4 class='fw-bold mb-1'>CITY COLLEGE OF ANGELES</h4>
							<h5 class='fw-bold mb-3'>OFFICE OF THE REGISTRAR</h5>

							<h6 class='fw-bold mb-0'>REPORT CARD</h6>
							<h6 class='fw-bold small mb-3'>" . $row["semester"] . " Semester, Academic Year " . $row["academic_year"] . "</h6>
						</div>

						<div class='table-responsive mb-3'>
							<table class='table table-bordered table-border-dark table-striped-light table-sm text-center small w-100 mb-0'>";

								$sql2 = "SELECT * FROM student_courses WHERE academic_year = '$academic_year' AND semester = '$semester' AND student_number = '$studentNumber'";
								$result2 = mysqli_query($conn, $sql2);
								
								if (mysqli_num_rows($result2) > 0) {
									echo "<tbody class='text-center'>";

										while ($row2 = mysqli_fetch_assoc($result2)) {
											echo "<tr class='tr-none'>
												<th width='13%'></th>
												<th width='13%'></th>
												<th width='28%'></th>
												<th width='7%'></th>
												<th width='13%'></th>
												<th width='13%'></th>
												<th width='13%'></th>
											</tr>
											<tr class='bg-secondary text-uppercase text-white'>
												<th>Student Number</th>
												<th colspan='2'>Student Name</th>
												<th colspan='3'>Course</th>
												<th>Year Level</th>
											</tr>
											<tr>
												<th>" . $row2["student_number"] . "</th>
												<th class='text-uppercase' colspan='2'>" . $row2["lastname"] . ", " . $row2["firstname"] . " " . $row2["middlename"] . "</th>
												<th colspan='3'>" . properCaseCourse($row2["course"]) . "</th>
												<th>" . $row2["year_level"] . "</th>
											</tr>
											<tr>
												<th class='bg-gray-100' colspan='100%'>&zwj;</th>
											</tr>";
										}
									} else {
										echo "<tr class='tr-none'>
											<th width='13%'></th>
											<th width='13%'></th>
											<th width='28%'></th>
											<th width='7%'></th>
											<th width='13%'></th>
											<th width='13%'></th>
											<th width='13%'></th>
										</tr>
										<tr class='bg-secondary text-white'>
											<th>Student Number</th>
											<th colspan='2'>Student Name</th>
											<th colspan='3'>Course</th>
											<th>Year Level</th>
										</tr>
										<tr>
											<th>-</th>
											<th colspan='2'>-</th>
											<th colspan='3'>-</th>
											<th>-</th>
										</tr>
										<tr>
											<th class='bg-gray-100' colspan='100%'>&zwj;</th>
										</tr>";
									}

									$sql3 = "SELECT * FROM student_grades WHERE academic_year = '$academic_year' AND semester = '$semester' AND student_number = '$studentNumber' ORDER BY class_code ASC";
									$result3 = mysqli_query($conn, $sql3);

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
									
									if (mysqli_num_rows($result3) > 0) {
										echo "<tr>
											<th>CLASS CODE</th>
											<th>COURSE CODE</th>
											<th colspan='2'>COURSE TITLE</th>
											<th>GRADE</th>
											<th>UNITS</th>
											<th>REMARKS</th>
										</tr>";

										while ($row3 = mysqli_fetch_assoc($result3)) {
											if (!in_array(strtoupper($row3["subject_code"]), $excludedSubjects)) {
												array_push($GxU, $row3["final_grade"] * intval($row3["units"]));
												array_push($UNITS, intval($row3["units"]));
											}

											if (!in_array(strtoupper($row3["subject_code"]), $excludedSubjectsWithPE)) {
												array_push($UNITS_WITH_PE, intval($row3["units"]));
											}

											if ($row3["final_grade"] > 2.00) {
												$isLister = false;
											}

											echo "<tr>
												<td>" . $row3["class_code"] . "</td>
												<td class='text-uppercase'>" . $row3["subject_code"] . "</td>
												<td class='text-start' colspan='2'>" . $row3["subject_title"] . "</td>
												<td>" . $row3["final_grade"] . "</td>
												<td>" . $row3["units"] . "</td>
												<td>" . $row3["remarks"] . "</td>
											</tr>";
										}
									}

									if (array_sum($UNITS) == 0) {
										echo "<th class='bg-white text-end' colspan='4'>General Weighted Average</th>
										<th class='bg-white text-center'>0.00</th>
										<th class='bg-white text-center'>" . array_sum($UNITS_WITH_PE) . "</th>
										<th class='bg-white text-center'></th>";
									} else {
										echo "<tr>
											<th class='bg-white text-end' colspan='4'>General Weighted Average</th>
											<th class='bg-white text-center'>" . number_format(array_sum($GxU) / array_sum($UNITS), 2) . "</th>
											<th class='bg-white text-center'>" . array_sum($UNITS_WITH_PE) . "</th>";

											if ($isLister) {
												if (number_format(array_sum($GxU) / array_sum($UNITS), 2) <= 0.00) {
													echo "<th class='bg-white text-center'></th>";
												} else if (number_format(array_sum($GxU) / array_sum($UNITS), 2) <= 1.25) {
													echo "<th class='bg-white text-center'>PL</th>";
												} else if (number_format(array_sum($GxU) / array_sum($UNITS), 2) <= 1.75) {
													echo "<th class='bg-white text-center'>DL</th>";
												} else {
													echo "<th class='bg-white text-center'></th>";
												}
											} else {
												echo "<th class='bg-white text-center'></th>";
											}

										echo "</tr>";
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
					</div>
				</div>";
			}
		} else {
			echo "<div class='card'>
				<div class='card-body text-center'>
					Student Not Found
				</div>
			</div>";
		}
	} else {
		$sql = "SELECT * FROM student_grades WHERE CONCAT(academic_year, ' ', semester) LIKE '%$academicYearFull%' AND student_number = '$studentNumber' GROUP BY CONCAT(academic_year, ' ', semester) ORDER BY CONCAT(academic_year, ' ', semester) ASC";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			echo "<div class='card cca-card'>
				<div class='card-body'>
					<div class='text-center'>
						<img class='w-90px' src='../assets/images/photos/cca-logo.png'>

						<h4 class='fw-bold mb-1'>CITY COLLEGE OF ANGELES</h4>
						<h5 class='fw-bold mb-3'>OFFICE OF THE REGISTRAR</h5>

						<h6 class='fw-bold mb-3'>COPY OF GRADES</h6>
					</div>

					<div class='table-responsive mb-3'>
						<table class='table table-bordered table-border-dark table-striped-light table-sm small w-100 mb-0'>
							<tbody class='text-center'>
								<tr class='tr-none'>
									<th width='13%'></th>
									<th width='13%'></th>
									<th width='28%'></th>
									<th width='7%'></th>
									<th width='13%'></th>
									<th width='13%'></th>
									<th width='13%'></th>
								</tr>
								<tr class='bg-secondary text-uppercase text-white'>
									<th>Student Number</th>
									<th colspan='3'>Student Name</th>
									<th colspan='3'>Course</th>
								</tr>";

								$sql2 = "SELECT * FROM student_courses WHERE CONCAT(academic_year, ' ', semester) LIKE '%$academicYearFull%' AND student_number = '$studentNumber' ORDER BY semester DESC LIMIT 1";
								$result2 = mysqli_query($conn, $sql2);

								if (mysqli_num_rows($result2) > 0) {
									while ($row2 = mysqli_fetch_assoc($result2)) {
										echo "<tr>
											<th>" . $row2["student_number"] . "</th>
											<th class='text-uppercase' colspan='3'>" . $row2["lastname"] . ", " . $row2["firstname"] . " " . $row2["middlename"] . "</th>
											<th colspan='3'>" . properCaseCourse($row2["course"]) . "</th>
										</tr>";
									}
								}

								while ($row = mysqli_fetch_assoc($result)) {
									$academic_year = $row["academic_year"];
									$semester = $row["semester"];

									$semesterFull = $semester;

									if ($semester != "Summer") {
										$semesterFull .= " Semester";
									}

									$sql2 = "SELECT * FROM student_courses WHERE academic_year = '$academic_year' AND semester = '$semester' AND student_number = '$studentNumber'";
									$result2 = mysqli_query($conn, $sql2);

									if (mysqli_num_rows($result2) > 0) {
										while ($row2 = mysqli_fetch_assoc($result2)) {
											echo "<tr>
												<th class='bg-gray-100' colspan='100%'>&zwj;</th>
											</tr>
											<tr>
												<th class='bg-white' colspan='100%'>" . $row2["year_level"] . " - " . $semesterFull . "</th>
											</tr>";
										}
									}

									$sql3 = "SELECT * FROM student_grades WHERE academic_year = '$academic_year' AND semester = '$semester' AND student_number = '$studentNumber' ORDER BY class_code ASC";
									$result3 = mysqli_query($conn, $sql3);

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
									
									if (mysqli_num_rows($result3) > 0) {
										echo "<tr>
											<th>CLASS CODE</th>
											<th>COURSE CODE</th>
											<th colspan='2'>COURSE TITLE</th>
											<th>GRADE</th>
											<th>UNITS</th>
											<th>REMARKS</th>
										</tr>";

										while ($row3 = mysqli_fetch_assoc($result3)) {
											if (!in_array(strtoupper($row3["subject_code"]), $excludedSubjects)) {
												array_push($GxU, $row3["final_grade"] * intval($row3["units"]));
												array_push($UNITS, intval($row3["units"]));
											}

											if (!in_array(strtoupper($row3["subject_code"]), $excludedSubjectsWithPE)) {
												array_push($UNITS_WITH_PE, intval($row3["units"]));
											}

											if ($row3["final_grade"] > 2.00) {
												$isLister = false;
											}

											echo "<tr>
												<td>" . $row3["class_code"] . "</td>
												<td class='text-uppercase'>" . $row3["subject_code"] . "</td>
												<td class='text-start' colspan='2'>" . $row3["subject_title"] . "</td>
												<td>" . $row3["final_grade"] . "</td>
												<td>" . $row3["units"] . "</td>
												<td>" . $row3["remarks"] . "</td>
											</tr>";
										}
									}

									if (array_sum($UNITS) == 0) {
										echo "<th class='bg-white text-end' colspan='4'>General Weighted Average</th>
										<th class='bg-white text-center'>0.00</th>
										<th class='bg-white text-center'>" . array_sum($UNITS_WITH_PE) . "</th>
										<th class='bg-white text-center'></th>";
									} else {
										echo "<tr>
											<th class='bg-white text-end' colspan='4'>General Weighted Average</th>
											<th class='bg-white text-center'>" . number_format(array_sum($GxU) / array_sum($UNITS), 2) . "</th>
											<th class='bg-white text-center'>" . array_sum($UNITS_WITH_PE) . "</th>";

											if ($isLister) {
												if (number_format(array_sum($GxU) / array_sum($UNITS), 2) <= 0.00) {
													echo "<th class='bg-white text-center'></th>";
												} else if (number_format(array_sum($GxU) / array_sum($UNITS), 2) <= 1.25) {
													echo "<th class='bg-white text-center'>PL</th>";
												} else if (number_format(array_sum($GxU) / array_sum($UNITS), 2) <= 1.75) {
													echo "<th class='bg-white text-center'>DL</th>";
												} else {
													echo "<th class='bg-white text-center'></th>";
												}
											} else {
												echo "<th class='bg-white text-center'></th>";
											}

										echo "</tr>";
									}

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
				</div>
			</div>";
		} else {
			echo "<div class='card'>
				<div class='card-body text-center'>
					Student Not Found
				</div>
			</div>";
		}
	}
}