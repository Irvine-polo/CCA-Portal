<?php

$baseUrl = "../../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "classSchedules";

include $baseUrl . "assets/templates/faculty/header.inc.php";

?>

<?php

$classCode = sanitize($_GET["classCode"]);

$sql = "SELECT * FROM academic_years WHERE is_active = 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$academicYear = $row["academic_year"];
		$semester = $row["semester"];
	}
}

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">View Class Records</h1>

	<a class="btn btn-primary" onclick="history.back()">Back</a>
</div>

<div class="card">
	<div class="card-header">
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="">Midterms</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="">Finals</a>
			</li>
		</ul>
	</div>
	<div class="card-body">
		<div class="table-responsive">

			<?php

			$sql = "SELECT * FROM academic_years WHERE is_active = 1";
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$academicYear = $row["academic_year"];
					$semester = $row["semester"];
				}
			}

			$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode'";
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {

					if (getClassRecordType($row["subject_code"]) == "IEAS" || getClassRecordType($row["subject_code"]) == "ICSLIS Lec") {						
						$classStandingColspan = mysqli_num_rows($result) + 7;

						// CLASS STANDINGS
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'class standing' GROUP BY assessment_type, assessment_number ORDER BY assessment_number ASC";
						$result = mysqli_query($conn, $sql);

						$classStandingColspan = mysqli_num_rows($result) + 2;
						
						$quizColspan = mysqli_num_rows($result) + 2;
						
						$classStandingNumbers = array();
						$classStandingTotals = array();

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								array_push($classStandingNumbers, $row["assessment_number"]);
								array_push($classStandingTotals, $row["assessment_total"]);
							}
						}

						// EXAMS
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_type, assessment_number ORDER BY assessment_number ASC";
						$result = mysqli_query($conn, $sql);
						
						$examColspan = mysqli_num_rows($result) + 2;

						$examNumbers = array();
						$examTotals = array();

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								array_push($examNumbers, $row["assessment_number"]);
								array_push($examTotals, $row["assessment_total"]);
							}
						}

						echo "<table class='table table-bordered table-border-dark table-sm text-center small w-100 mb-0'>
							<thead class='small'>
								<tr class='bg-green text-white'>
									<th rowspan='2' width='30'>#</th>
									<th rowspan='2' width='60'>STUDENT NUMBER</th>
									<th rowspan='2' width='240'>STUDENT NAME</th>
									<th colspan='" . $classStandingColspan . "'>CLASS STANDING (60%)</th>
									<th colspan='" . $examColspan . "'>MIDTERM EXAM (40%)</th>
									<th rowspan='2' width='60'>MIDTERM GRADE</th>
									<th rowspan='2' width='60'>PERCENTAGE GRADE</th>
									<th rowspan='2' width='60'>EQUIVALENT</th>
									<th rowspan='2' width='60'>REMARKS</th>
								</tr>
								<tr>";
									foreach ($classStandingNumbers as $classStandingNumber) {
										echo "<th class='bg-secondary text-white'>" . $classStandingNumber . "</th>";
									}

									echo "<th class='bg-secondary text-white'>T</th>
									<th class='bg-secondary text-white'>60%</th>";

									foreach ($examNumbers as $examNumber) {
										echo "<th class='bg-secondary text-white'>" . $examNumber . "</th>";
									}

									echo "<th class='bg-secondary text-white'>T</th>
									<th class='bg-secondary text-white'>40%</th>
								</tr>
								<tr>
									<th class='bg-secondary text-white text-end fst-italic' colspan='3'>Total Items</th>";

									foreach ($classStandingTotals as $classStandingTotal) {
										echo "<th class='bg-secondary text-white'>" . $classStandingTotal . "</th>";
									}

									echo "<th class='bg-secondary text-white'>" . array_sum($classStandingTotals) . "</th>
									<th class='bg-secondary text-white'>60.00</th>";

									foreach ($examTotals as $examTotal) {
										echo "<th class='bg-secondary text-white'>" . $examTotal . "</th>";
									}

									echo "<th class='bg-secondary text-white'>" . array_sum($examTotals) . "</th>
									<th class='bg-secondary text-white'>40.00</th>
									<th class='bg-secondary text-white' colspan='100%'></th>
								</tr>
							</thead>

							<tbody>
								<tr class='bg-gray-100'>
									<td class='fw-bold' colspan='3'>MALE</td>
									<td colspan='100%'></td>
								</tr>";

								$sql = "SELECT * FROM student_subjects LEFT JOIN student_courses ON student_subjects.student_number = student_courses.student_number WHERE student_courses.academic_year = '$academicYear' AND student_courses.semester = '$semester' AND student_subjects.class_code = '$classCode' AND student_courses.sex = 'Male' ORDER BY student_courses.lastname ASC, student_courses.firstname ASC, student_courses.middlename ASC";
								$result = mysqli_query($conn, $sql);
								
								$counter = 1;

								if (mysqli_num_rows($result) > 0) {
									while ($row = mysqli_fetch_assoc($result)) {
										$studentNumber = $row["student_number"];
										$studentClassStandingScoreTotals = array();
										$examScoreTotals = array();
										echo "<tr>
											<td class='bg-gray-50'>" . $counter . "</td>
											<td class='bg-gray-50'>" . $row["student_number"] . "</td>
											<td class='bg-gray-50 text-start'>" . $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "</td>";
											
											foreach ($classStandingNumbers as $classStandingNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'class standing' AND assessment_number = '$classStandingNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentClassStandingScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($classStandingTotals != null) {
												$classStandingPercentage = number_format(array_sum($studentClassStandingScoreTotals) / array_sum($classStandingTotals) * 60, 2);
											} else {
												$classStandingPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentClassStandingScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $classStandingPercentage . "</td>";

											foreach ($examNumbers as $examNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' AND assessment_number = '$examNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($examScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($examTotals != null) {
												$examPercentage = number_format(array_sum($examScoreTotals) / array_sum($examTotals) * 40, 2);
											} else {
												$examPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($examScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $examPercentage . "</td>";

											$midtermGrade = number_format($classStandingPercentage + $examPercentage, 2);
											$percentageGrade = getPercentageGrade(number_format($midtermGrade, 0));
											$equivalentGrade = getEquivalent(number_format($midtermGrade, 0));
											$remarks = getRemarks(number_format($midtermGrade, 0));

											echo "<td class='bg-gray-50 fw-bold'>" . $midtermGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $percentageGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $equivalentGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $remarks . "</td>
										</tr>";

										$counter++;
									}
								}

								echo "<tr class='bg-gray-100'>
									<td class='fw-bold' colspan='3'>FEMALE</td>
									<td colspan='100%'></td>
								</tr>";

								$sql = "SELECT * FROM student_subjects LEFT JOIN student_courses ON student_subjects.student_number = student_courses.student_number WHERE student_courses.academic_year = '$academicYear' AND student_courses.semester = '$semester' AND student_subjects.class_code = '$classCode' AND student_courses.sex = 'Female' ORDER BY student_courses.lastname ASC, student_courses.firstname ASC, student_courses.middlename ASC";
								$result = mysqli_query($conn, $sql);
								
								$counter = 1;

								if (mysqli_num_rows($result) > 0) {
									while ($row = mysqli_fetch_assoc($result)) {
										$studentNumber = $row["student_number"];
										$studentClassStandingScoreTotals = array();
										$examScoreTotals = array();

										echo "<tr>
											<td class='bg-gray-50'>" . $counter . "</td>
											<td class='bg-gray-50'>" . $row["student_number"] . "</td>
											<td class='bg-gray-50 text-start'>" . $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "</td>";
											
											foreach ($classStandingNumbers as $classStandingNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'class standing' AND assessment_number = '$classStandingNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentClassStandingScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($classStandingTotals != null) {
												$classStandingPercentage = number_format(array_sum($studentClassStandingScoreTotals) / array_sum($classStandingTotals) * 60, 2);
											} else {
												$classStandingPercentage = 0.00;
											}	

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentClassStandingScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $classStandingPercentage . "</td>";

											foreach ($examNumbers as $examNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' AND assessment_number = '$examNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($examScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($examTotals != null) {
												$examPercentage = number_format(array_sum($examScoreTotals) / array_sum($examTotals) * 40, 2);
											} else {
												$examPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($examScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $examPercentage . "</td>";

											$midtermGrade = number_format($classStandingPercentage + $examPercentage, 2);
											$percentageGrade = getPercentageGrade(number_format($midtermGrade, 0));
											$equivalentGrade = getEquivalent(number_format($midtermGrade, 0));
											$remarks = getRemarks(number_format($midtermGrade, 0));

											echo "<td class='bg-gray-50 fw-bold'>" . $midtermGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $percentageGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $equivalentGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $remarks . "</td>
										</tr>";

										$counter++;
									}
								}
							echo "</tbody>
						</table>";
					}

					else if (getClassRecordType($row["subject_code"]) == "ICSLIS Lec Lab") {
						// CLASS STANDING
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type <> 'exam' GROUP BY assessment_type, assessment_number";
						$result = mysqli_query($conn, $sql);
						
						$classStandingColspan = mysqli_num_rows($result) + 7;

						// QUIZZES
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'quiz' GROUP BY assessment_type, assessment_number ORDER BY assessment_number ASC";
						$result = mysqli_query($conn, $sql);
						
						$quizColspan = mysqli_num_rows($result) + 2;
						
						$quizNumbers = array();
						$quizTotals = array();

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								array_push($quizNumbers, $row["assessment_number"]);
								array_push($quizTotals, $row["assessment_total"]);
							}
						}

						// LABORATORY
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'lab' GROUP BY assessment_type, assessment_number ORDER BY assessment_number ASC";
						$result = mysqli_query($conn, $sql);
						
						$labColspan = mysqli_num_rows($result) + 2;

						$labNumbers = array();
						$labTotals = array();

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								array_push($labNumbers, $row["assessment_number"]);
								array_push($labTotals, $row["assessment_total"]);
							}
						}

						// OTHER LEARNING OUTCOMES
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'other learning outcome' GROUP BY assessment_type, assessment_number ORDER BY assessment_number ASC";
						$result = mysqli_query($conn, $sql);
						
						$otherLearningOutcomeColspan = mysqli_num_rows($result) + 2;

						$otherLearningOutcomeNumbers = array();
						$otherLearningOutcomeTotals = array();

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								array_push($otherLearningOutcomeNumbers, $row["assessment_number"]);
								array_push($otherLearningOutcomeTotals, $row["assessment_total"]);
							}
						}

						// EXAMS
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_type, assessment_number ORDER BY assessment_number ASC";
						$result = mysqli_query($conn, $sql);
						
						$examColspan = mysqli_num_rows($result) + 2;

						$examNumbers = array();
						$examTotals = array();

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								array_push($examNumbers, $row["assessment_number"]);
								array_push($examTotals, $row["assessment_total"]);
							}
						}

						echo "<table class='table table-bordered table-border-dark table-sm text-center small w-100 mb-0'>
							<thead class='small'>
								<tr class='bg-green text-white'>
									<th rowspan='3' width='30'>#</th>
									<th rowspan='3' width='60'>STUDENT NUMBER</th>
									<th rowspan='3' width='240'>STUDENT NAME</th>
									<th colspan='" . $classStandingColspan . "'>CLASS STANDING (60%)</th>
									<th colspan='" . $examColspan . "' rowspan='2'>MIDTERM EXAM (40%)</th>
									<th rowspan='3' width='60'>MIDTERM GRADE</th>
									<th rowspan='3' width='60'>PERCENTAGE GRADE</th>
									<th rowspan='3' width='60'>EQUIVALENT</th>
									<th rowspan='3' width='60'>REMARKS</th>
								</tr>
								<tr>
									<th class='bg-secondary text-white' colspan='" . $quizColspan . "'>QUIZZES (15%)</th>
									<th class='bg-secondary text-white' colspan='" . $labColspan . "'>LABORATORY (30%)</th>
									<th class='bg-secondary text-white' colspan='" . $otherLearningOutcomeColspan . "'>OTHER LEARNING OUTCOMES (15%)</th>
									<th class='bg-secondary text-white' rowspan='2'>Total</th>
								</tr>
								<tr>";

									foreach ($quizNumbers as $quizNumber) {
										echo "<th class='bg-secondary text-white'>" . $quizNumber . "</th>";
									}

									echo "<th class='bg-secondary text-white'>T</th>
									<th class='bg-secondary text-white'>15%</th>";
									
									foreach ($labNumbers as $labNumber) {
										echo "<th class='bg-secondary text-white'>" . $labNumber . "</th>";
									}					

									echo "<th class='bg-secondary text-white'>T</th>
									<th class='bg-secondary text-white'>30%</th>";

									foreach ($otherLearningOutcomeNumbers as $otherLearningOutcomeNumber) {
										echo "<th class='bg-secondary text-white'>" . $otherLearningOutcomeNumber . "</th>";
									}
									
									echo "<th class='bg-secondary text-white'>T</th>
									<th class='bg-secondary text-white'>15%</th>";

									foreach ($examNumbers as $examNumber) {
										echo "<th class='bg-secondary text-white'>" . $examNumber . "</th>";
									}

									echo "<th class='bg-secondary text-white'>T</th>
									<th class='bg-secondary text-white'>40%</th>
								</tr>
								<tr>
									<th class='bg-secondary text-white text-end fst-italic' colspan='3'>Total Items</th>";
									
									foreach ($quizTotals as $quizTotal) {
										echo "<th class='bg-secondary text-white'>" . $quizTotal . "</th>";
									}

									echo "<th class='bg-secondary text-white'>" . array_sum($quizTotals) . "</th>
									<th class='bg-secondary text-white'>15.00</th>";

									foreach ($labTotals as $labTotal) {
										echo "<th class='bg-secondary text-white'>" . $labTotal . "</th>";
									}

									echo "<th class='bg-secondary text-white'>" . array_sum($labTotals) . "</th>
									<th class='bg-secondary text-white'>40.00</th>";

									foreach ($otherLearningOutcomeTotals as $otherLearningOutcomeTotal) {
										echo "<th class='bg-secondary text-white'>" . $otherLearningOutcomeTotal . "</th>";
									}

									echo "<th class='bg-secondary text-white'>" . array_sum($otherLearningOutcomeTotals) . "</th>
									<th class='bg-secondary text-white'>15.00</th>
									<th class='bg-secondary text-white'>70.00</th>";

									foreach ($examTotals as $examTotal) {
										echo "<th class='bg-secondary text-white'>" . $examTotal . "</th>";
									}

									echo "<th class='bg-secondary text-white'>" . array_sum($examTotals) . "</th>
									<th class='bg-secondary text-white'>30.00</th>
									<th class='bg-secondary text-white' colspan='100%'></th>
								</tr>
							</thead>

							<tbody>
								<tr class='bg-gray-100'>
									<td class='fw-bold' colspan='3'>MALE</td>
									<td colspan='100%'></td>
								</tr>";

								$sql = "SELECT * FROM student_subjects LEFT JOIN student_courses ON student_subjects.student_number = student_courses.student_number WHERE student_courses.academic_year = '$academicYear' AND student_courses.semester = '$semester' AND student_subjects.class_code = '$classCode' AND student_courses.sex = 'Male' ORDER BY student_courses.lastname ASC, student_courses.firstname ASC, student_courses.middlename ASC";
								$result = mysqli_query($conn, $sql);
								
								$counter = 1;

								if (mysqli_num_rows($result) > 0) {
									while ($row = mysqli_fetch_assoc($result)) {
										$studentNumber = $row["student_number"];
										$studentQuizScoreTotals = array();
										$studentLabScoreTotals = array();
										$studentOtherLearningOutcomeScoreTotals = array();
										$examScoreTotals = array();

										echo "<tr>
											<td class='bg-gray-50'>" . $counter . "</td>
											<td class='bg-gray-50'>" . $row["student_number"] . "</td>
											<td class='bg-gray-50 text-start'>" . $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "</td>";
											
											foreach ($quizNumbers as $quizNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'quiz' AND assessment_number = '$quizNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentQuizScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($quizTotals != null) {
												$quizPercentage = number_format(array_sum($studentQuizScoreTotals) / array_sum($quizTotals) * 15, 2);
											} else {
												$quizPercentage = 0.00;
											}	

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentQuizScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $quizPercentage . "</td>";

											foreach ($labNumbers as $labNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'lab' AND assessment_number = '$labNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentLabScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($labTotals != null) {
												$labPercentage = number_format(array_sum($studentLabScoreTotals) / array_sum($labTotals) * 30, 2);
											} else {
												$labPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentLabScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $labPercentage . "</td>";

											foreach ($otherLearningOutcomeNumbers as $otherLearningOutcomeNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'other learning outcome' AND assessment_number = '$otherLearningOutcomeNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentOtherLearningOutcomeScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($otherLearningOutcomeTotals != null) {
												$otherLearningOutcomePercentage = number_format(array_sum($studentOtherLearningOutcomeScoreTotals) / array_sum($otherLearningOutcomeTotals) * 15, 2);
											} else {
												$otherLearningOutcomePercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentOtherLearningOutcomeScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $otherLearningOutcomePercentage . "</td>";

											$classStandingPercentage = number_format($quizPercentage + $labPercentage + $otherLearningOutcomePercentage, 2);

											echo "<td class='bg-gray-50 fw-bold'>" . $classStandingPercentage . "</td>";

											foreach ($examNumbers as $examNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' AND assessment_number = '$examNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($examScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($examTotals != null) {
												$examPercentage = number_format(array_sum($examScoreTotals) / array_sum($examTotals) * 40, 2);
											} else {
												$examPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($examScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $examPercentage . "</td>";

											$midtermGrade = number_format($classStandingPercentage + $examPercentage, 2);
											$percentageGrade = getPercentageGrade(number_format($midtermGrade, 0));
											$equivalentGrade = getEquivalent(number_format($midtermGrade, 0));
											$remarks = getRemarks(number_format($midtermGrade, 0));

											echo "<td class='bg-gray-50 fw-bold'>" . $midtermGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $percentageGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $equivalentGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $remarks . "</td>
										</tr>";

										$counter++;
									}
								}

								echo "<tr class='bg-gray-100'>
									<td class='fw-bold' colspan='3'>FEMALE</td>
									<td colspan='100%'></td>
								</tr>";

								$sql = "SELECT * FROM student_subjects LEFT JOIN student_courses ON student_subjects.student_number = student_courses.student_number WHERE student_courses.academic_year = '$academicYear' AND student_courses.semester = '$semester' AND student_subjects.class_code = '$classCode' AND student_courses.sex = 'Female' ORDER BY student_courses.lastname ASC, student_courses.firstname ASC, student_courses.middlename ASC";
								$result = mysqli_query($conn, $sql);
								
								$counter = 1;

								if (mysqli_num_rows($result) > 0) {
									while ($row = mysqli_fetch_assoc($result)) {
										$studentNumber = $row["student_number"];
										$studentQuizScoreTotals = array();
										$studentLabScoreTotals = array();
										$studentOtherLearningOutcomeScoreTotals = array();
										$examScoreTotals = array();

										echo "<tr>
											<td class='bg-gray-50'>" . $counter . "</td>
											<td class='bg-gray-50'>" . $row["student_number"] . "</td>
											<td class='bg-gray-50 text-start'>" . $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "</td>";
											
											foreach ($quizNumbers as $quizNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'quiz' AND assessment_number = '$quizNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentQuizScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($quizTotals != null) {
												$quizPercentage = number_format(array_sum($studentQuizScoreTotals) / array_sum($quizTotals) * 15, 2);
											} else {
												$quizPercentage = 0.00;
											}	

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentQuizScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $quizPercentage . "</td>";

											foreach ($labNumbers as $labNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'lab' AND assessment_number = '$labNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentLabScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($labTotals != null) {
												$labPercentage = number_format(array_sum($studentLabScoreTotals) / array_sum($labTotals) * 30, 2);
											} else {
												$labPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentLabScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $labPercentage . "</td>";

											foreach ($otherLearningOutcomeNumbers as $otherLearningOutcomeNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'other learning outcome' AND assessment_number = '$otherLearningOutcomeNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentOtherLearningOutcomeScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($otherLearningOutcomeTotals != null) {
												$otherLearningOutcomePercentage = number_format(array_sum($studentOtherLearningOutcomeScoreTotals) / array_sum($otherLearningOutcomeTotals) * 15, 2);
											} else {
												$otherLearningOutcomePercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentOtherLearningOutcomeScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $otherLearningOutcomePercentage . "</td>";

											$classStandingPercentage = number_format($quizPercentage + $labPercentage + $otherLearningOutcomePercentage, 2);

											echo "<td class='bg-gray-50 fw-bold'>" . $classStandingPercentage . "</td>";

											foreach ($examNumbers as $examNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' AND assessment_number = '$examNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($examScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($examTotals != null) {
												$examPercentage = number_format(array_sum($examScoreTotals) / array_sum($examTotals) * 40, 2);
											} else {
												$examPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($examScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $examPercentage . "</td>";

											$midtermGrade = number_format($classStandingPercentage + $examPercentage, 2);
											$percentageGrade = getPercentageGrade(number_format($midtermGrade, 0));
											$equivalentGrade = getEquivalent(number_format($midtermGrade, 0));
											$remarks = getRemarks(number_format($midtermGrade, 0));

											echo "<td class='bg-gray-50 fw-bold'>" . $midtermGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $percentageGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $equivalentGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $remarks . "</td>
										</tr>";

										$counter++;
									}
								}
							echo "</tbody>
						</table>";
					}

					else if (getClassRecordType($row["subject_code"]) == "ICSLIS Cisco") {
						// CLASS STANDING
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type <> 'exam' GROUP BY assessment_type, assessment_number";
						$result = mysqli_query($conn, $sql);
						
						$classStandingColspan = mysqli_num_rows($result) + 7;

						// QUIZZES
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'quiz' GROUP BY assessment_type, assessment_number ORDER BY assessment_number ASC";
						$result = mysqli_query($conn, $sql);
						
						$quizColspan = mysqli_num_rows($result) + 2;
						
						$quizNumbers = array();
						$quizTotals = array();

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								array_push($quizNumbers, $row["assessment_number"]);
								array_push($quizTotals, $row["assessment_total"]);
							}
						}

						// LABORATORY
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'lab' GROUP BY assessment_type, assessment_number ORDER BY assessment_number ASC";
						$result = mysqli_query($conn, $sql);
						
						$labColspan = mysqli_num_rows($result) + 2;

						$labNumbers = array();
						$labTotals = array();

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								array_push($labNumbers, $row["assessment_number"]);
								array_push($labTotals, $row["assessment_total"]);
							}
						}

						// OTHER LEARNING OUTCOMES
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'other learning outcome' GROUP BY assessment_type, assessment_number ORDER BY assessment_number ASC";
						$result = mysqli_query($conn, $sql);
						
						$otherLearningOutcomeColspan = mysqli_num_rows($result) + 2;

						$otherLearningOutcomeNumbers = array();
						$otherLearningOutcomeTotals = array();

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								array_push($otherLearningOutcomeNumbers, $row["assessment_number"]);
								array_push($otherLearningOutcomeTotals, $row["assessment_total"]);
							}
						}

						// EXAMS
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_type, assessment_number ORDER BY assessment_number ASC";
						$result = mysqli_query($conn, $sql);
						
						$examColspan = mysqli_num_rows($result) + 2;

						$examNumbers = array();
						$examTotals = array();

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								array_push($examNumbers, $row["assessment_number"]);
								array_push($examTotals, $row["assessment_total"]);
							}
						}

						echo "<table class='table table-bordered table-border-dark table-sm text-center small w-100 mb-0'>
							<thead class='small'>
								<tr class='bg-green text-white'>
									<th rowspan='3' width='30'>#</th>
									<th rowspan='3' width='60'>STUDENT NUMBER</th>
									<th rowspan='3' width='240'>STUDENT NAME</th>
									<th colspan='" . $classStandingColspan . "'>CLASS STANDING (70%)</th>
									<th colspan='" . $examColspan . "' rowspan='2'>MIDTERM EXAM (30%)</th>
									<th rowspan='3' width='60'>MIDTERM GRADE</th>
									<th rowspan='3' width='60'>PERCENTAGE GRADE</th>
									<th rowspan='3' width='60'>EQUIVALENT</th>
									<th rowspan='3' width='60'>REMARKS</th>
								</tr>
								<tr>
									<th class='bg-secondary text-white' colspan='" . $quizColspan . "'>QUIZZES (15%)</th>
									<th class='bg-secondary text-white' colspan='" . $labColspan . "'>LABORATORY (40%)</th>
									<th class='bg-secondary text-white' colspan='" . $otherLearningOutcomeColspan . "'>OTHER LEARNING OUTCOMES (15%)</th>
									<th class='bg-secondary text-white' rowspan='2'>Total</th>
								</tr>
								<tr>";

									foreach ($quizNumbers as $quizNumber) {
										echo "<th class='bg-secondary text-white'>" . $quizNumber . "</th>";
									}

									echo "<th class='bg-secondary text-white'>T</th>
									<th class='bg-secondary text-white'>15%</th>";
									
									foreach ($labNumbers as $labNumber) {
										echo "<th class='bg-secondary text-white'>" . $labNumber . "</th>";
									}					

									echo "<th class='bg-secondary text-white'>T</th>
									<th class='bg-secondary text-white'>40%</th>";

									foreach ($otherLearningOutcomeNumbers as $otherLearningOutcomeNumber) {
										echo "<th class='bg-secondary text-white'>" . $otherLearningOutcomeNumber . "</th>";
									}
									
									echo "<th class='bg-secondary text-white'>T</th>
									<th class='bg-secondary text-white'>15%</th>";

									foreach ($examNumbers as $examNumber) {
										echo "<th class='bg-secondary text-white'>" . $examNumber . "</th>";
									}

									echo "<th class='bg-secondary text-white'>T</th>
									<th class='bg-secondary text-white'>30%</th>
								</tr>
								<tr>
									<th class='bg-secondary text-white text-end fst-italic' colspan='3'>Total Items</th>";
									
									foreach ($quizTotals as $quizTotal) {
										echo "<th class='bg-secondary text-white'>" . $quizTotal . "</th>";
									}

									echo "<th class='bg-secondary text-white'>" . array_sum($quizTotals) . "</th>
									<th class='bg-secondary text-white'>15.00</th>";

									foreach ($labTotals as $labTotal) {
										echo "<th class='bg-secondary text-white'>" . $labTotal . "</th>";
									}

									echo "<th class='bg-secondary text-white'>" . array_sum($labTotals) . "</th>
									<th class='bg-secondary text-white'>40.00</th>";

									foreach ($otherLearningOutcomeTotals as $otherLearningOutcomeTotal) {
										echo "<th class='bg-secondary text-white'>" . $otherLearningOutcomeTotal . "</th>";
									}

									echo "<th class='bg-secondary text-white'>" . array_sum($otherLearningOutcomeTotals) . "</th>
									<th class='bg-secondary text-white'>15.00</th>
									<th class='bg-secondary text-white'>70.00</th>";

									foreach ($examTotals as $examTotal) {
										echo "<th class='bg-secondary text-white'>" . $examTotal . "</th>";
									}

									echo "<th class='bg-secondary text-white'>" . array_sum($examTotals) . "</th>
									<th class='bg-secondary text-white'>30.00</th>
									<th class='bg-secondary text-white' colspan='100%'></th>
								</tr>
							</thead>

							<tbody>
								<tr class='bg-gray-100'>
									<td class='fw-bold' colspan='3'>MALE</td>
									<td colspan='100%'></td>
								</tr>";

								$sql = "SELECT * FROM student_subjects LEFT JOIN student_courses ON student_subjects.student_number = student_courses.student_number WHERE student_courses.academic_year = '$academicYear' AND student_courses.semester = '$semester' AND student_subjects.class_code = '$classCode' AND student_courses.sex = 'Male' ORDER BY student_courses.lastname ASC, student_courses.firstname ASC, student_courses.middlename ASC";
								$result = mysqli_query($conn, $sql);
								
								$counter = 1;

								if (mysqli_num_rows($result) > 0) {
									while ($row = mysqli_fetch_assoc($result)) {
										$studentNumber = $row["student_number"];
										$studentQuizScoreTotals = array();
										$studentLabScoreTotals = array();
										$studentOtherLearningOutcomeScoreTotals = array();
										$examScoreTotals = array();

										echo "<tr>
											<td class='bg-gray-50'>" . $counter . "</td>
											<td class='bg-gray-50'>" . $row["student_number"] . "</td>
											<td class='bg-gray-50 text-start'>" . $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "</td>";
											
											foreach ($quizNumbers as $quizNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'quiz' AND assessment_number = '$quizNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentQuizScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($quizTotals != null) {
												$quizPercentage = number_format(array_sum($studentQuizScoreTotals) / array_sum($quizTotals) * 15, 2);
											} else {
												$quizPercentage = 0.00;
											}	

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentQuizScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $quizPercentage . "</td>";

											foreach ($labNumbers as $labNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'lab' AND assessment_number = '$labNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentLabScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($labTotals != null) {
												$labPercentage = number_format(array_sum($studentLabScoreTotals) / array_sum($labTotals) * 40, 2);
											} else {
												$labPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentLabScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $labPercentage . "</td>";

											foreach ($otherLearningOutcomeNumbers as $otherLearningOutcomeNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'other learning outcome' AND assessment_number = '$otherLearningOutcomeNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentOtherLearningOutcomeScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($otherLearningOutcomeTotals != null) {
												$otherLearningOutcomePercentage = number_format(array_sum($studentOtherLearningOutcomeScoreTotals) / array_sum($otherLearningOutcomeTotals) * 15, 2);
											} else {
												$otherLearningOutcomePercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentOtherLearningOutcomeScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $otherLearningOutcomePercentage . "</td>";

											$classStandingPercentage = number_format($quizPercentage + $labPercentage + $otherLearningOutcomePercentage, 2);

											echo "<td class='bg-gray-50 fw-bold'>" . $classStandingPercentage . "</td>";

											foreach ($examNumbers as $examNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' AND assessment_number = '$examNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($examScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($examTotals != null) {
												$examPercentage = number_format(array_sum($examScoreTotals) / array_sum($examTotals) * 30, 2);
											} else {
												$examPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($examScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $examPercentage . "</td>";

											$midtermGrade = number_format($classStandingPercentage + $examPercentage, 2);
											$percentageGrade = getPercentageGrade(number_format($midtermGrade, 0));
											$equivalentGrade = getEquivalent(number_format($midtermGrade, 0));
											$remarks = getRemarks(number_format($midtermGrade, 0));

											echo "<td class='bg-gray-50 fw-bold'>" . $midtermGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $percentageGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $equivalentGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $remarks . "</td>
										</tr>";

										$counter++;
									}
								}

								echo "<tr class='bg-gray-100'>
									<td class='fw-bold' colspan='3'>FEMALE</td>
									<td colspan='100%'></td>
								</tr>";

								$sql = "SELECT * FROM student_subjects LEFT JOIN student_courses ON student_subjects.student_number = student_courses.student_number WHERE student_courses.academic_year = '$academicYear' AND student_courses.semester = '$semester' AND student_subjects.class_code = '$classCode' AND student_courses.sex = 'Female' ORDER BY student_courses.lastname ASC, student_courses.firstname ASC, student_courses.middlename ASC";
								$result = mysqli_query($conn, $sql);
								
								$counter = 1;

								if (mysqli_num_rows($result) > 0) {
									while ($row = mysqli_fetch_assoc($result)) {
										$studentNumber = $row["student_number"];
										$studentQuizScoreTotals = array();
										$studentLabScoreTotals = array();
										$studentOtherLearningOutcomeScoreTotals = array();
										$examScoreTotals = array();

										echo "<tr>
											<td class='bg-gray-50'>" . $counter . "</td>
											<td class='bg-gray-50'>" . $row["student_number"] . "</td>
											<td class='bg-gray-50 text-start'>" . $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "</td>";
											
											foreach ($quizNumbers as $quizNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'quiz' AND assessment_number = '$quizNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentQuizScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($quizTotals != null) {
												$quizPercentage = number_format(array_sum($studentQuizScoreTotals) / array_sum($quizTotals) * 15, 2);
											} else {
												$quizPercentage = 0.00;
											}	

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentQuizScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $quizPercentage . "</td>";

											foreach ($labNumbers as $labNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'lab' AND assessment_number = '$labNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentLabScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($labTotals != null) {
												$labPercentage = number_format(array_sum($studentLabScoreTotals) / array_sum($labTotals) * 40, 2);
											} else {
												$labPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentLabScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $labPercentage . "</td>";

											foreach ($otherLearningOutcomeNumbers as $otherLearningOutcomeNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'other learning outcome' AND assessment_number = '$otherLearningOutcomeNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentOtherLearningOutcomeScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($otherLearningOutcomeTotals != null) {
												$otherLearningOutcomePercentage = number_format(array_sum($studentOtherLearningOutcomeScoreTotals) / array_sum($otherLearningOutcomeTotals) * 15, 2);
											} else {
												$otherLearningOutcomePercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentOtherLearningOutcomeScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $otherLearningOutcomePercentage . "</td>";

											$classStandingPercentage = number_format($quizPercentage + $labPercentage + $otherLearningOutcomePercentage, 2);

											echo "<td class='bg-gray-50 fw-bold'>" . $classStandingPercentage . "</td>";

											foreach ($examNumbers as $examNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' AND assessment_number = '$examNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($examScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($examTotals != null) {
												$examPercentage = number_format(array_sum($examScoreTotals) / array_sum($examTotals) * 30, 2);
											} else {
												$examPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($examScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $examPercentage . "</td>";

											$midtermGrade = number_format($classStandingPercentage + $examPercentage, 2);
											$percentageGrade = getPercentageGrade(number_format($midtermGrade, 0));
											$equivalentGrade = getEquivalent(number_format($midtermGrade, 0));
											$remarks = getRemarks(number_format($midtermGrade, 0));

											echo "<td class='bg-gray-50 fw-bold'>" . $midtermGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $percentageGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $equivalentGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $remarks . "</td>
										</tr>";

										$counter++;
									}
								}
							echo "</tbody>
						</table>";
					}

					if (getClassRecordType($row["subject_code"]) == "IBM") {						
						$classStandingColspan = mysqli_num_rows($result) + 7;

						// CLASS STANDINGS
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'class standing' GROUP BY assessment_type, assessment_number ORDER BY assessment_number ASC";
						$result = mysqli_query($conn, $sql);

						$classStandingColspan = mysqli_num_rows($result) + 2;
						
						$quizColspan = mysqli_num_rows($result) + 2;
						
						$classStandingNumbers = array();
						$classStandingTotals = array();

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								array_push($classStandingNumbers, $row["assessment_number"]);
								array_push($classStandingTotals, $row["assessment_total"]);
							}
						}

						// EXAMS
						$sql = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_type, assessment_number ORDER BY assessment_number ASC";
						$result = mysqli_query($conn, $sql);
						
						$examColspan = mysqli_num_rows($result) + 2;

						$examNumbers = array();
						$examTotals = array();

						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								array_push($examNumbers, $row["assessment_number"]);
								array_push($examTotals, $row["assessment_total"]);
							}
						}

						echo "<table class='table table-bordered table-border-dark table-sm text-center small w-100 mb-0'>
							<thead class='small'>
								<tr class='bg-green text-white'>
									<th rowspan='2' width='30'>#</th>
									<th rowspan='2' width='60'>STUDENT NUMBER</th>
									<th rowspan='2' width='240'>STUDENT NAME</th>
									<th colspan='" . $classStandingColspan . "'>CLASS STANDING (70%)</th>
									<th colspan='" . $examColspan . "'>MIDTERM EXAM (30%)</th>
									<th rowspan='2' width='60'>MIDTERM GRADE</th>
									<th rowspan='2' width='60'>PERCENTAGE GRADE</th>
									<th rowspan='2' width='60'>EQUIVALENT</th>
									<th rowspan='2' width='60'>REMARKS</th>
								</tr>
								<tr>";
									foreach ($classStandingNumbers as $classStandingNumber) {
										echo "<th class='bg-secondary text-white'>" . $classStandingNumber . "</th>";
									}

									echo "<th class='bg-secondary text-white'>T</th>
									<th class='bg-secondary text-white'>70%</th>";

									foreach ($examNumbers as $examNumber) {
										echo "<th class='bg-secondary text-white'>" . $examNumber . "</th>";
									}

									echo "<th class='bg-secondary text-white'>T</th>
									<th class='bg-secondary text-white'>30%</th>
								</tr>
								<tr>
									<th class='bg-secondary text-white text-end fst-italic' colspan='3'>Total Items</th>";

									foreach ($classStandingTotals as $classStandingTotal) {
										echo "<th class='bg-secondary text-white'>" . $classStandingTotal . "</th>";
									}

									echo "<th class='bg-secondary text-white'>" . array_sum($classStandingTotals) . "</th>
									<th class='bg-secondary text-white'>60.00</th>";

									foreach ($examTotals as $examTotal) {
										echo "<th class='bg-secondary text-white'>" . $examTotal . "</th>";
									}

									echo "<th class='bg-secondary text-white'>" . array_sum($examTotals) . "</th>
									<th class='bg-secondary text-white'>40.00</th>
									<th class='bg-secondary text-white' colspan='100%'></th>
								</tr>
							</thead>

							<tbody>
								<tr class='bg-gray-100'>
									<td class='fw-bold' colspan='3'>MALE</td>
									<td colspan='100%'></td>
								</tr>";

								$sql = "SELECT * FROM student_subjects LEFT JOIN student_courses ON student_subjects.student_number = student_courses.student_number WHERE student_courses.academic_year = '$academicYear' AND student_courses.semester = '$semester' AND student_subjects.class_code = '$classCode' AND student_courses.sex = 'Male' ORDER BY student_courses.lastname ASC, student_courses.firstname ASC, student_courses.middlename ASC";
								$result = mysqli_query($conn, $sql);
								
								$counter = 1;

								if (mysqli_num_rows($result) > 0) {
									while ($row = mysqli_fetch_assoc($result)) {
										$studentNumber = $row["student_number"];
										$studentClassStandingScoreTotals = array();
										$examScoreTotals = array();
										echo "<tr>
											<td class='bg-gray-50'>" . $counter . "</td>
											<td class='bg-gray-50'>" . $row["student_number"] . "</td>
											<td class='bg-gray-50 text-start'>" . $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "</td>";
											
											foreach ($classStandingNumbers as $classStandingNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'class standing' AND assessment_number = '$classStandingNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentClassStandingScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($classStandingTotals != null) {
												$classStandingPercentage = number_format(array_sum($studentClassStandingScoreTotals) / array_sum($classStandingTotals) * 70, 2);
											} else {
												$classStandingPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentClassStandingScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $classStandingPercentage . "</td>";

											foreach ($examNumbers as $examNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' AND assessment_number = '$examNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($examScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($examTotals != null) {
												$examPercentage = number_format(array_sum($examScoreTotals) / array_sum($examTotals) * 30, 2);
											} else {
												$examPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($examScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $examPercentage . "</td>";

											$midtermGrade = number_format($classStandingPercentage + $examPercentage, 2);
											$percentageGrade = getPercentageGrade(number_format($midtermGrade, 0));
											$equivalentGrade = getEquivalent(number_format($midtermGrade, 0));
											$remarks = getRemarks(number_format($midtermGrade, 0));

											echo "<td class='bg-gray-50 fw-bold'>" . $midtermGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $percentageGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $equivalentGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $remarks . "</td>
										</tr>";

										$counter++;
									}
								}

								echo "<tr class='bg-gray-100'>
									<td class='fw-bold' colspan='3'>FEMALE</td>
									<td colspan='100%'></td>
								</tr>";

								$sql = "SELECT * FROM student_subjects LEFT JOIN student_courses ON student_subjects.student_number = student_courses.student_number WHERE student_courses.academic_year = '$academicYear' AND student_courses.semester = '$semester' AND student_subjects.class_code = '$classCode' AND student_courses.sex = 'Female' ORDER BY student_courses.lastname ASC, student_courses.firstname ASC, student_courses.middlename ASC";
								$result = mysqli_query($conn, $sql);
								
								$counter = 1;

								if (mysqli_num_rows($result) > 0) {
									while ($row = mysqli_fetch_assoc($result)) {
										$studentNumber = $row["student_number"];
										$studentClassStandingScoreTotals = array();
										$examScoreTotals = array();

										echo "<tr>
											<td class='bg-gray-50'>" . $counter . "</td>
											<td class='bg-gray-50'>" . $row["student_number"] . "</td>
											<td class='bg-gray-50 text-start'>" . $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "</td>";
											
											foreach ($classStandingNumbers as $classStandingNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'class standing' AND assessment_number = '$classStandingNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($studentClassStandingScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($classStandingTotals != null) {
												$classStandingPercentage = number_format(array_sum($studentClassStandingScoreTotals) / array_sum($classStandingTotals) * 70, 2);
											} else {
												$classStandingPercentage = 0.00;
											}	

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($studentClassStandingScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $classStandingPercentage . "</td>";

											foreach ($examNumbers as $examNumber) {
												$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' AND assessment_number = '$examNumber' AND student_number = '$studentNumber'";
												$result2 = mysqli_query($conn, $sql2);
												
												if (mysqli_num_rows($result2) > 0) {
													while ($row2 = mysqli_fetch_assoc($result2)) {
														array_push($examScoreTotals, $row2["assessment_score"]);

														echo "<td>" . $row2["assessment_score"] . "</td>";
													}
												} else {
													echo "<td></td>";
												}
											}

											if ($examTotals != null) {
												$examPercentage = number_format(array_sum($examScoreTotals) / array_sum($examTotals) * 30, 2);
											} else {
												$examPercentage = 0.00;
											}

											echo "<td class='bg-gray-50 fw-bold'>" . array_sum($examScoreTotals) . "</td>
											<td class='bg-gray-50 fw-bold'>" . $examPercentage . "</td>";

											$midtermGrade = number_format($classStandingPercentage + $examPercentage, 2);
											$percentageGrade = getPercentageGrade(number_format($midtermGrade, 0));
											$equivalentGrade = getEquivalent(number_format($midtermGrade, 0));
											$remarks = getRemarks(number_format($midtermGrade, 0));

											echo "<td class='bg-gray-50 fw-bold'>" . $midtermGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $percentageGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $equivalentGrade . "</td>
											<td class='bg-gray-50 fw-bold'>" . $remarks . "</td>
										</tr>";

										$counter++;
									}
								}
							echo "</tbody>
						</table>";
					}
				}
			}

			?>
			
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/faculty/footer.inc.php";

?>