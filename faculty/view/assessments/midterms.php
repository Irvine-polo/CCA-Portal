<?php

$baseUrl = "../../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "classSchedules";

include $baseUrl . "assets/templates/faculty/header.inc.php";

?>

<?php

$classCode = sanitize($_GET["classCode"]);

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">View Assessments</h1>

	<a class="btn btn-primary" onclick="history.back()">Back</a>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="list-group">
					<a class="list-group-item list-group-item-action active" href="./midterms?classCode=<?= $classCode; ?>">Midterms</a>
					<a class="list-group-item list-group-item-action" href="./finals?classCode=<?= $classCode; ?>">Finals</a>
				</div>	
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
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
						echo "<div class='d-flex justify-content-between align-items-center mb-3'>
							<h5 class='card-title mb-0'>" . $row["section"] . " • " . $row["subject_code"] . "</h5>

							<a class='btn btn-success btn-sm' href='../../import/assessment?classCode=" . $classCode . "'>Import / Reimport Assessment</a>
						</div>";

						if (getClassRecordType($row["subject_code"]) == "ICSLIS Lec") {
							echo "<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Class Standing (60%)
											</th>
										</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'class standing' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'class standing' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Class Standing #" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

									echo "</thead>
								</table>
							</div>

							<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100 mb-0'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Exam (40%)
											</th>
										</tr>";
										
										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}
										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>
														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Exam #" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}
										echo "</tr>";

									echo "</thead>
								</table>
							</div>";
						}

						if (getClassRecordType($row["subject_code"]) == "ICSLIS Lec Lab") {
							echo "<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Quiz (15%)
											</th>
										</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'quiz' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'quiz' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>
														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Quiz #" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

									echo "</thead>
								</table>
							</div>

							<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Laboratory (30%)
											</th>
										</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'lab' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'lab' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>
														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Laboratory #" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

									echo "</thead>
								</table>
							</div>

							<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Other Learning Outcome (15%)
											</th>
										</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'other learning outcome' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'other learning outcome' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>
														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Other Learning Outcome #" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

									echo "</thead>
								</table>
							</div>

							<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100 mb-0'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Exam (40%)
											</th>
										</tr>";
										
										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}
										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>
														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Exam #" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}
										echo "</tr>";

									echo "</thead>
								</table>
							</div>";
						}

						if (getClassRecordType($row["subject_code"]) == "ICSLIS Cisco") {
							echo "<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Quiz (15%)
											</th>
										</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'quiz' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'quiz' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>
														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Quiz #" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

									echo "</thead>
								</table>
							</div>

							<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Laboratory (40%)
											</th>
										</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'lab' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'lab' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>
														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Laboratory #" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

									echo "</thead>
								</table>
							</div>

							<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Other Learning Outcome (15%)
											</th>
										</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'other learning outcome' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'other learning outcome' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>
														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Other Learning Outcome #" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

									echo "</thead>
								</table>
							</div>

							<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100 mb-0'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Exam (30%)
											</th>
										</tr>";
										
										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}
										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>
														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Exam #" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}
										echo "</tr>";

									echo "</thead>
								</table>
							</div>";
						}

						if (getClassRecordType($row["subject_code"]) == "IEAS") {
							echo "<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Class Standing (60%)
											</th>
										</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'class standing' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'class standing' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>
														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Class Standing" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

									echo "</thead>
								</table>
							</div>

							<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100 mb-0'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Exam (40%)
											</th>
										</tr>";
										
										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}
										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>
														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Exam #" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}
										echo "</tr>";

									echo "</thead>
								</table>
							</div>";
						}

						if (getClassRecordType($row["subject_code"]) == "IBM") {
							echo "<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Class Standing (70%)
											</th>
										</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'class standing' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'class standing' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>
														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Class Standing #" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}

										echo "</tr>";

									echo "</thead>
								</table>
							</div>

							<div class='table-responsive'>
								<table class='table table-bordered table-border-dark table-striped table-sm text-center w-100 mb-0'>
									<thead>
										<tr>
											<th class='bg-secondary text-white' colspan='100%'>
												Exam (30%)
											</th>
										</tr>";
										
										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>#</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>" . $row2["assessment_number"] . "</th>";
												}
											} else {
												echo "<th>-</th>";
											}
										echo "</tr>";

										$sql2 = "SELECT * FROM assessments WHERE academic_year = '$academicYear' AND semester = '$semester' AND grading_period = 'midterms' AND class_code = '$classCode' AND assessment_type = 'exam' GROUP BY assessment_number ORDER BY assessment_number ASC";
										$result2 = mysqli_query($conn, $sql2);
										
										echo "<tr>
											<th width='10%'>Total</th>";

											if (mysqli_num_rows($result2) > 0) {
												while ($row2 = mysqli_fetch_assoc($result2)) {
													echo "<th>
														<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-bs-name='Exam #" . $row2["assessment_number"] . "' data-bs-href='../../../assets/includes/faculty/assessment.inc.php?deleteAssessment&classCode=" . $classCode . "&gradingPeriod=midterms&assessmentType=" . $row2["assessment_type"] . "&assessmentNumber=" . $row2["assessment_number"] . "'>
															" . $row2["assessment_total"] . "
														</button>
													</th>";
												}
											} else {
												echo "<th>-</th>";
											}
										echo "</tr>";

									echo "</thead>
								</table>
							</div>";
						}
					}
				}

				?>
			</div>
		</div>
	</div>
</div>


<?php

include $baseUrl . "assets/templates/faculty/footer.inc.php";

?>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteModalLabel">Delete Assessment</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete <strong class="name"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-danger href">Confirm</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	let deleteModal = document.getElementById("deleteModal");

	deleteModal.addEventListener("show.bs.modal", function (event) {
		let button = event.relatedTarget;

		let name = button.getAttribute("data-bs-name");
		let modalBodyName = deleteModal.querySelector(".modal-body .name");
		modalBodyName.innerHTML = name;

		let href = button.getAttribute("data-bs-href");
		let modalFooterHref = deleteModal.querySelector(".modal-footer .href");
		modalFooterHref.href = href;
	});
</script>