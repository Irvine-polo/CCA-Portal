<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "facultyStudentGrades";

include $baseUrl . "assets/templates/coordinator/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Import Finalized Grades</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" onclick="history.back()">
		<i class="fa-solid fa-chevron-left me-2"></i>
		Back
	</a>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Field Names</h5>

				<!-- <ul class="mb-0">
					<li>Student Number</li>
					<li>Student Name</li>
					<li>Midterm Grade</li>
					<li>Final Grade</li>
				</ul> -->

				<ul class="mb-0">
					<li>Student Number</li>
					<li>Student Name</li>
					<li>Equivalent</li>
					<li>Units</li>
					<li>Remarks</li>
					<li>Class Code</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<form class="card" id="form">
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

				$referenceNumber = $_SESSION["username"];
				$classCode = sanitize($_GET["classCode"]);

				$facultyClasses = array();

				$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND (reference_number = '$referenceNumber' OR substitute_reference_number = '$referenceNumber')";
				$result = mysqli_query($conn, $sql);
				
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						array_push($facultyClasses, $row["class_code"]);
					}
				}

				if (in_array($classCode, $facultyClasses)) {
					$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode'";
					$result = mysqli_query($conn, $sql);
					
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<div class='row'>
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
								<div class='col-2'>
									<div class='mb-3'>
										<label>Section</label>
										<input class='form-control form-control-lg' type='text' name='section' value='" . $row["section"] . "' readonly>
									</div>
								</div>

								<div class='col-2'>
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

								<div class='col-2'>
									<div class='mb-3'>
										<label>Units</label>
										<input class='form-control form-control-lg' type='text' name='units' value='" . $row["units"] . "' readonly>
									</div>
								</div>
							</div>

							<div class='mb-3'>
								<label>Course Title</label>
								<input class='form-control form-control-lg' type='text' name='subjectTitle' value='" . $row["subject_title"] . "' readonly>
							</div>

							<div class='mb-3'>
								<label>Student Grades CSV</label>
								<input class='form-control form-control-lg' type='file' accept='.csv' name='csv' required>
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
				} else {
					echo "<div class='text-center'>
						Class not found.
					</div>";
				}

				?>
				
			</div>
		</form>	
	</div>
</div>

<?php

include $baseUrl . "assets/templates/coordinator/footer.inc.php";

?>

<script type="text/javascript">
	$(document).ready(function() { 
		$('#form').submit(function(e) {	
			e.preventDefault();

			let formData = new FormData(this);
			formData.append("csv", $("input[type=file]")[0].files[0]);
			formData.append("submitImportFinalizedGrades", "");

			$.ajax({
				url: "../../assets/includes/coordinator/faculty-finalized-grade.inc.php",
				type: "POST",
				data: formData,
				dataType: "json",
				contentType: false,
				processData: false,
				beforeSend: function() {
					$("#submitButton").prop("disabled", true);
					$("#submitButton").html(`<span class="spinner-grow spinner-grow-sm"></span> Loading..`);

					window.onbeforeunload = function() {
						return "Are you sure you want to leave this page?";
					};

					isImporting = true;
				},
				success: function(data) {
					$("#submitButton").prop("disabled", false);
					$("#submitButton").html(`Submit`);

					window.onbeforeunload = null;

					if (data.type == "error") {
						Swal.fire(
							'Error!',
							data.value + '.',
							'error'
						)
					}

					if (data.type == "success") {
						Swal.fire(
							'Success!',
							data.value + '.',
							'success'
						)
					}

					isImporting = false;

					$('#form').trigger("reset");
				}
			});

			return false;
		});
	});
</script>