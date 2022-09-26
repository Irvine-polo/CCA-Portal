<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "enrolledStudents";

include $baseUrl . "assets/templates/admin/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Import Enrolled Students</h1>

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

				<ul class="mb-0">
					<li>Student Number</li>
					<li>Last Name</li>
					<li>First Name</li>
					<li>Middle Name</li>
					<li>Email Address</li>
					<li>Sex</li>
					<li>Course</li>
					<li>Yeal Level</li>
					<li>Section</li>
					<li>Status</li>
					<li>Is PWD?</li>
					<li>Subject 1</li>
					<li>Subject 2</li>
					<li>Subject 3</li>
					<li>Subject 4</li>
					<li>Subject 5</li>
					<li>Subject 6</li>
					<li>Subject 7</li>
					<li>Subject 8</li>
					<li>Subject 9</li>
					<li>Subject 10</li>
					<li>Subject 11</li>
					<li>Subject 12</li>
				</ul>
			</div>
		</div>	
	</div>

	<div class="col-md-8">
		<form class="card" id="form" enctype="multipart/form-data">
			<div class="card-body">
				<div class="row">
					<div class="col-6">
						<div class="mb-3">
							<label>Academic Year</label>
							<input class="form-control form-control-lg" type="text" name="academicYear" value="<?= value("academicYear"); ?>" readonly>
						</div>
					</div>

					<div class="col-6">
						<div class="mb-3">
							<label>Semester</label>
							<input class="form-control form-control-lg" type="text" name="semester" value="<?= value("semester"); ?>" readonly>
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label>Class Schedules CSV</label>
					<input class="form-control form-control-lg" type="file" accept=".csv" name="csv" required>
				</div>

				<div class="mb-3">
					<label class="form-check user-select-none">
						<input class="form-check-input" type="checkbox" required>
						<span class="form-check-label">Verify</span>
					</label>
				</div>

				<div class="text-center">
					<button class="btn btn-success btn-lg" id="submitButton" type="submit">
						Submit
					</button>
				</div>
			</div>
		</form>	
	</div>
</div>

<?php

include $baseUrl . "assets/templates/admin/footer.inc.php";

?>

<script type="text/javascript">
	$(document).ready(function() { 
		$('#form').submit(function(e) {	
			e.preventDefault();

			let formData = new FormData(this);
			formData.append("csv", $("input[type=file]")[0].files[0]);
			formData.append("submitImportEnrolledStudents", "");

			$.ajax({
				url: "../../assets/includes/admin/enrolled-student.inc.php",
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