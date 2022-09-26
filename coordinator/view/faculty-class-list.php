<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "facultyClassSchedules";

include $baseUrl . "assets/templates/coordinator/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">View Class List</h1>

	<div class="d-flex justify-content-between align-items-center">
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

		$referenceNumber = $_SESSION["username"];

		$facultyClasses = array();

		$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND (reference_number = '$referenceNumber' OR substitute_reference_number = '$referenceNumber')";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($facultyClasses, $row["class_code"]);
			}
		}

		if (in_array($classCode, $facultyClasses)) {
			$classList = "";
		
			$sql = "SELECT * FROM student_subjects LEFT JOIN student_courses ON student_subjects.student_number = student_courses.student_number WHERE student_courses.academic_year = '$academicYear' AND student_courses.semester = '$semester' AND student_subjects.class_code = '$classCode' ORDER BY student_courses.lastname ASC, student_courses.firstname ASC, student_courses.middlename ASC";
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$classList .= $row["student_number"] . "\t" . $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "\r\n";
				}
			}

			echo "<textarea class='d-none' id='classList'>" . strtoupper($classList) . "</textarea>";
			echo "<button class='btn btn-success me-2' onclick='copyClassList()'>Copy Class List</button>";
		}

		?>

		<a class="btn btn-primary d-flex justify-content-between align-items-center" onclick="history.back()">
			<i class="fa-solid fa-chevron-left me-2"></i>
			Back
		</a>
	</div>
</div>

<div class="card">
	<div class="card-body">

		<?php

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

			echo "<textarea class='d-none' id='classDetails'>" . $classDetails . "</textarea>";
			echo "<button class='btn btn-success btn-sm mb-3' onclick='copyClassDetails()'>Copy Class Details</button>

			<div class='d-flex justify-content-between align-items-end'>
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
		<div class="table-responsive">
			<table class="table table-bordered table-border-dark table-striped-light table-sm small w-100 mb-0">
				<thead>
					<tr class="bg-secondary text-white text-center">
						<th>#</th>
						<th>Student Number</th>
						<th>Student Name</th>
						<th>Email Address</th>
						<th>Sex</th>
						<th>Course</th>
						<th>Year Level</th>
						<th>Status</th>
					</tr>
				</thead>

				<tbody>

					<?php

					if (in_array($classCode, $facultyClasses)) {
					
						$sql = "SELECT * FROM student_subjects LEFT JOIN student_courses ON student_subjects.student_number = student_courses.student_number WHERE student_courses.academic_year = '$academicYear' AND student_courses.semester = '$semester' AND student_subjects.class_code = '$classCode' ORDER BY student_courses.lastname ASC, student_courses.firstname ASC, student_courses.middlename ASC";
						$result = mysqli_query($conn, $sql);

						$counter = 1;
						
						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								echo "<tr class='text-center'>
									<td>" . $counter . "</td>
									<td>" . $row["student_number"] . "</td>
									<td class='text-start text-uppercase'>" . $row["lastname"] . ", " . $row["firstname"] . " " . $row["middlename"] . "</td>
									<td class='text-start'>" . $row["email_address"] . "</td>
									<td>" . $row["sex"] . "</td>
									<td class='text-start'>" . properCaseCourse($row["course"]) . "</td>
									<td>" . $row["year_level"] . "</td>
									<td>" . $row["status"] . "</td>
								</tr>";

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

include $baseUrl . "assets/templates/coordinator/footer.inc.php";

?>

<script type="text/javascript">
	function copyClassList() {
		$('#alertWrapper').html(``);

		/* Get the text field */
		var copyText = document.getElementById("classList");

		/* Select the text field */
		copyText.select();
		copyText.setSelectionRange(0, 99999); /* For mobile devices */

		/* Copy the text inside the text field */
		navigator.clipboard.writeText(copyText.value);

		/* Alert the copied text */
		Swal.fire(
			'Success!',
			'Class List Copied.',
			'success'
		)
	}

	function copyClassDetails() {
		$('#alertWrapper').html(``);

		/* Get the text field */
		var copyText = document.getElementById("classDetails");

		/* Select the text field */
		copyText.select();
		copyText.setSelectionRange(0, 99999); /* For mobile devices */

		/* Copy the text inside the text field */
		navigator.clipboard.writeText(copyText.value);

		/* Alert the copied text */
		$('#alertWrapper').html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Success!</strong> Class Details Copied.
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>`);
		Swal.fire(
			'Success!',
			'Class Details Copied.',
			'success'
		)
	}
</script>