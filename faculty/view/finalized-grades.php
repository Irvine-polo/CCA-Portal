<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "studentGrades";

include $baseUrl . "assets/templates/faculty/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">View Finalized Grades</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" href="./student-grades?academicYear=<?= sanitize($_GET["academicYear"]); ?>&semester=<?= sanitize($_GET["semester"]); ?>">
		<i class="fa-solid fa-chevron-left me-2"></i>
		Back
	</a>
</div>

<div class="card">
	<div class="card-body">

		<?php

		$referenceNumber = $_SESSION["username"];
		$academicYear = sanitize($_GET["academicYear"]);
		$semester = sanitize($_GET["semester"]);
		$classCode = sanitize($_GET["classCode"]);

		$facultyClasses = array();

		$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND reference_number = '$referenceNumber'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($facultyClasses, $row["class_code"]);
			}
		}

		if (in_array($classCode, $facultyClasses)) {
			$classDetails = "";
		
			$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode'";
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$classDetails .= $row["class_code"] . "\t" . $row["section"] . "\t" . $row["subject_code"] . "\t" . $row["units"] . "\t" . $row["faculty_name"];

					$section = $row["section"];
					$subjectCode = $row["subject_code"];
					$subjectTitle = $row["subject_title"];
					$units = $row["units"];
				}
			}

			echo "<div class='d-flex justify-content-between align-items-end'>
				<div>
					<h4>" . $section . "</h4>
					<h2 class='mb-0'>" . $subjectCode . "</h2>
				</div>

				<div>
					<h4 class='text-end'>" . $units . " Units</h4>
					<h2 class='mb-0'>" . $subjectTitle . "</h2>
				</div>
			</div>";
		} else {
			echo "<div class='text-center'>Class not found.</div>";
		}

		?>

	</div>
</div>

<div class="card">
	<div class="card-body">
		<h5 class="card-title">Grade Legend</h5>

		<table class="table-bordered text-center w-100 mb-0" style="table-layout: fixed;">
			<tr>
				<th>6.00</th>
				<th>7.00</th>
				<th>8.00</th>
				<th>9.00</th>
				<th>LOA</th>
				<th>CRD</th>
			</tr>
			<tr>
				<td>FA</td>
				<td>NFE</td>
				<td>UW</td>
				<td>DRP</td>
				<td>LOA</td>
				<td>CREDITED</td>
			</tr>
		</table>
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-border-dark table-striped-light table-sm w-100 mb-0">
				<thead>
					<tr class="bg-secondary text-white text-center">
						<th width="5%">#</th>
						<th width="10%">Student Number</th>
						<th width="45%">Full Name</th>
						<th width="10%">Class Code</th>
						<th width="10%">Equivalent</th>
						<th width="10%">Units</th>
						<th width="10%">Remarks</th>
					</tr>
				</thead>

				<tbody>
					
					<?php

					$facultyClasses = array();

					$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND reference_number = '$referenceNumber'";
					$result = mysqli_query($conn, $sql);
					
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							array_push($facultyClasses, $row["class_code"]);
						}
					}

					if (in_array($classCode, $facultyClasses)) {
						$sql = "SELECT * FROM student_subjects LEFT JOIN student_courses ON student_subjects.student_number = student_courses.student_number WHERE student_courses.academic_year = '$academicYear' AND student_courses.semester = '$semester' AND student_subjects.class_code = '$classCode' ORDER BY student_courses.lastname ASC, student_courses.firstname ASC, student_courses.middlename ASC";
						$result = mysqli_query($conn, $sql);

						$counter = 1;
						
						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								$studentNumber = $row["student_number"];

								echo "<tr class='text-center'>
									<td>" . $counter . "</td>
									<td>" . $row["student_number"] . "</td>
									<td class='text-start text-uppercase student-name'>" . $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "</td>
									<td class='class-code'>" . $classCode . "</td>";

									$sql2 = "SELECT * FROM student_grades WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode' AND student_number = '$studentNumber'";
									$result2 = mysqli_query($conn, $sql2);
									
									if (mysqli_num_rows($result2) > 0) {
										while ($row2 = mysqli_fetch_assoc($result2)) {
											echo "<td class='equivalent'>
												" . $row2["final_grade"] . "
											</td>
											<td class='units'>" . $row2["units"] . "</td>
											<td class='remarks'>" . $row2["remarks"] . "</td>";
										}
									} else {
										echo "<td class='equivalent'>
											<input class='w-100 text-center form-control' value=''>
										</td>
										<td class='units'></td>
										<td class='remarks'></td>";
									}

								echo "</tr>";

								$counter++;
							}
						} else {
							echo "<tr class='text-center'>
								<td colspan='100%'>No students to show.</td>
							</tr>";
						}
					} else {
						echo "<tr class='text-center'>
							<td colspan='100%'>Class not found.</td>
						</tr>";
					}

					?>

				</tbody>
			</table>
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/faculty/footer.inc.php";

?>