<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "deanClassSchedules";

include $baseUrl . "assets/templates/dean/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Edit Class Schedule</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" href="../view/dean-class-schedules?academicYear=<?= $_GET["academicYear"]; ?>&semester=<?= $_GET["semester"]; ?>">
		<i class="fa-solid fa-chevron-left me-2"></i>
		Back
	</a>
</div>

<div class="card">
	<form class="card-body" action="../../assets/includes/dean/dean-class-schedule.inc.php" method="POST">

		<?php

		$academicYear = sanitize($_GET["academicYear"]);
		$semester = sanitize($_GET["semester"]);
		$institute = $_SESSION["institute"];
		$classScheduleId = sanitize($_GET["id"]);

		$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND institute = '$institute' AND id = '$classScheduleId'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				echo "
				<input type='hidden' name='classScheduleId' value='" . $classScheduleId . "'>
				<div class='row'>
					<div class='col-md-6'>
						<div class='row'>
							<div class='col-md-5'>
								<div class='mb-3'>
									<label>Academic Year</label>
									<input class='form-control form-control-lg' type='text' name='academicYear' value='" . $row["academic_year"] . "' required readonly>
								</div>
							</div>

							<div class='col-md-3'>
								<div class='mb-3'>
									<label>Semester</label>
									<input class='form-control form-control-lg' type='text' name='semester' value='" . $row["semester"] . "' required readonly>
								</div>
							</div>
							
							<div class='col-md-4'>
								<div class='mb-3'>
        							<label>Institute</label>
        							<input class='form-control form-control-lg' type='text' name='institute' value='" . strtoupper($row["institute"]) . "' required readonly>
        						</div>
							</div>
						</div>

						<div class='row'>
							<div class='col-md-4'>
								<div class='mb-3'>
									<label>Reference Number</label>
									<input class='form-control form-control-lg' type='text' name='referenceNumber' value='" . $row["reference_number"] . "' required>
								</div>
							</div>

							<div class='col-md-8'>
								<div class='mb-3'>
									<label>Faculty Name</label>
									<input class='form-control form-control-lg' type='text' name='facultyName' value='" . $row["faculty_name"] . "' required>
								</div>
							</div>
						</div>
						
						<div class='row'>
							<div class='col-md-4'>
								<div class='mb-3'>
									<label>Substitute Ref Num</label>
									<input class='form-control form-control-lg' type='text' name='substituteReferenceNumber' value='" . $row["substitute_reference_number"] . "'>
								</div>
							</div>

							<div class='col-md-8'>
								<div class='mb-3'>
									<label>Substitute Faculty Name</label>
									<input class='form-control form-control-lg' type='text' name='substituteFacultyName' value='" . $row["substitute_faculty_name"] . "'>
								</div>
							</div>
						</div>

						<div class='row'>
							<div class='col-md-4'>
								<div class='mb-3'>
									<label>Section</label>
									<input class='form-control form-control-lg' type='text' name='section' value='" . $row["section"] . "' required>
								</div>
							</div>

							<div class='col-md-4'>
								<div class='mb-3'>
									<label>Class Code</label>
									<input class='form-control form-control-lg' type='text' name='classCode' value='" . $row["class_code"] . "' required>
								</div>
							</div>

							<div class='col-md-4'>
								<div class='mb-3'>
									<label>Course Code</label>
									<input class='form-control form-control-lg' type='text' name='subjectCode' value='" . $row["subject_code"] . "' required>
								</div>
							</div>
						</div>
					</div>

					<div class='col-md-6'>
						<div class='mb-3'>
							<label>Course Title</label>
							<input class='form-control form-control-lg' type='text' name='subjectTitle' value='" . $row["subject_title"] . "' required>
						</div>

						<div class='row'>
							<div class='col-md-4'>
								<div class='mb-3'>
									<label>Lecture Hours</label>
									<input class='form-control form-control-lg' type='text' name='lecHours' value='" . $row["lec_hours"] . "' required>
								</div>
							</div>

							<div class='col-md-4'>
								<div class='mb-3'>
									<label>Laboratory Hours</label>
									<input class='form-control form-control-lg' type='text' name='labHours' value='" . $row["lab_hours"] . "' required>
								</div>
							</div>

							<div class='col-md-4'>
								<div class='mb-3'>
									<label>Units</label>
									<input class='form-control form-control-lg' type='text' name='units' value='" . $row["units"] . "' required>
								</div>
							</div>
						</div>

						<div class='row'>
							<div class='col-md-5'>
								<div class='mb-3'>
									<label>Synchronous Day</label>
									<input class='form-control form-control-lg' type='text' name='syncDay' value='" . $row["sync_day"] . "' required>
								</div>
							</div>

							<div class='col-md-7'>
								<div class='mb-3'>
									<label>Synchronous Time</label>
									<input class='form-control form-control-lg' type='text' name='syncTime' value='" . $row["sync_time"] . "' required>
								</div>
							</div>
						</div>

						<div class='row'>
							<div class='col-md-5'>
								<div class='mb-3'>
									<label>Asynchronous Day</label>
									<input class='form-control form-control-lg' type='text' name='asyncDay' value='" . $row["async_day"] . "' required>
								</div>
							</div>

							<div class='col-md-7'>
								<div class='mb-3'>
									<label>Asynchronous Time</label>
									<input class='form-control form-control-lg' type='text' name='asyncTime' value='" . $row["async_time"] . "' required>
								</div>
							</div>
						</div>
					</div>

					<div class='mb-3'>
						<label class='form-check user-select-none'>
							<input class='form-check-input' type='checkbox' required>
							<span class='form-check-label'>Verify</span>
						</label>
					</div>

					<div class='text-center'>
						<button class='btn btn-main btn-lg' name='submitEditClassSchedule' type='submit'>Submit</button>
					</div>
				</div>";
			}
		} else {
			echo "<p class='text-center mb-0'><b>CLASS SCHEDULE</b> not found</p>";
		}

		?>

			
	</form>
</div>

<?php

include $baseUrl . "assets/templates/dean/footer.inc.php";

?>