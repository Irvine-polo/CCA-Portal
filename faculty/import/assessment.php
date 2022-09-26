<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "classSchedules";

include $baseUrl . "assets/templates/faculty/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Import Student Grades</h1>

	<a class="btn btn-primary" onclick="history.back()">Back</a>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Field Names</h5>

				<ul class="mb-0">
					<li>Student Number</li>
					<li>Student Name</li>
					<li>Assessment Number</li>
					<li>Assessment Total</li>
					<li>Assessment Score</li>
				</ul>
			</div>
		</div>	
	</div>

	<div class="col-md-8">
		<form class="card" id="form" action="../../assets/includes/faculty/assessment.inc.php" method="POST" enctype="multipart/form-data">
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

				$classCode = sanitize($_GET["classCode"]);

				$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode'";
				$result = mysqli_query($conn, $sql);
				
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<input type='hidden' name='submitImportAssessments'>

						<div class='row'>
							<div class='col-6'>
								<div class='mb-3'>
									<label>Academic Year</label>
									<input class='form-control form-control-lg' type='text' name='academicYear' value='" . $academicYear . "' readonly>
								</div>
							</div>

							<div class='col-6'>
								<div class='mb-3'>
									<label>Semester</label>
									<input class='form-control form-control-lg' type='text' name='semester' value='" . $semester . "' readonly>
								</div>
							</div>
						</div>

						<div class='row'>
							<div class='col-3'>
								<div class='mb-3'>
									<label>Section</label>
									<input class='form-control form-control-lg' type='text' name='section' value='" . $row["section"] . "' readonly>
								</div>
							</div>

							<div class='col-3'>
								<div class='mb-3'>
									<label>Class Code</label>
									<input class='form-control form-control-lg' type='text' name='classCode' value='" . $row["class_code"] . "' readonly>
								</div>
							</div>

							<div class='col-6'>
								<div class='mb-3'>
									<label>Course Code</label>
									<input class='form-control form-control-lg' type='text' name='subjectCode' value='" . $row["subject_code"] . "' readonly>
								</div>
							</div>
						</div>

						<div class='mb-3'>
							<label>Course Title</label>
							<input class='form-control form-control-lg' type='text' name='subjectTitle' value='" . $row["subject_title"] . "' readonly>
						</div>

						<div class='row'>
							<div class='col-6'>
								<div class='mb-3'>
									<label>Grading Period</label>
									<select class='form-select form-select-lg' name='gradingPeriod' required>
										<option value='' selected disabled>--Select Grading Period--</option>
										<option value='midterms'>Midterms</option>
										<option value='finals'>Finals</option>
									</select>
								</div>
							</div>

							<div class='col-6'>
								<div class='mb-3'>
									<label>Assessment Type</label>
									<select class='form-select form-select-lg' name='assessmentType' required>
										<option value='' selected disabled>--Select Assessment Type--</option>";
										
										if (getClassRecordType($row["subject_code"]) == "ICSLIS Cisco" || getClassRecordType($row["subject_code"]) == "ICSLIS Lec Lab") {
											echo "<option value='quiz'>Quiz</option>
											<option value='lab'>Laboratory</option>
											<option value='other learning outcome'>Other Learning Outcome</option>
											<option value='exam'>Exam</option>";
										}

										if (getClassRecordType($row["subject_code"]) == "IBM" || getClassRecordType($row["subject_code"]) == "IEAS" || getClassRecordType($row["subject_code"]) == "ICSLIS Lec") {
											echo "<option value='class standing'>Class Standing</option>
											<option value='exam'>Exam</option>";
										}

									echo "</select>
								</div>
							</div>
						</div>

						<div class='mb-3'>
							<label>Student Grades CSV</label>
							<input class='form-control form-control-lg' type='file' accept='.csv' name='csv'>
						</div>

						<div class='mb-3'>
							<label class='form-check user-select-none'>
								<input class='form-check-input' type='checkbox' required>
								<span class='form-check-label'>Verify</span>
							</label>
						</div>

						<div class='text-center'>
							<button class='btn btn-success btn-lg' id='submitButton' type='submit'>
								Submit
							</button>
						</div>";
					}
				}

				?>

			</div>
		</form>	
	</div>
</div>

<?php

include $baseUrl . "assets/templates/faculty/footer.inc.php";

?>

<script type="text/javascript">
	$(document).ready(function() { 
		$("#form").submit(function(e) {	
			e.preventDefault();
			
			$(this).ajaxSubmit({
				target: "#alertWrapper", 
				beforeSubmit: function() {
					$('#alertWrapper').html(``);
					$("#submitButton").prop("disabled", true);
					$("#submitButton").html(`<span class="spinner-grow spinner-grow-sm"></span> Loading..`);
				},
				success: function() {
					$("#submitButton").prop("disabled", false);
					$("#submitButton").html(`Submit`);
				},

				resetForm: true 
			}); 

			return false;
		});
	});
</script>