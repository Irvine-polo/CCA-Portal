<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "academicYears";

include $baseUrl . "assets/templates/registrar/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Add Enrolled Student</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" href="../enrolled-students">
		<i class="fa-solid fa-chevron-left me-2"></i>
		Back
	</a>
</div>

<div class="card">
	<form class="card-body" id="form" method="POST" autocomplete="off">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label>Academic Year</label>
							<input class="form-control form-control-lg" type="text" name="academicYear" value="<?= sanitize($_GET["academicYear"]); ?>" readonly required>
						</div>
					</div>

					<div class="col-md-6">
						<div class="mb-3">
							<label>Semester</label>
							<input class="form-control form-control-lg" type="text" name="semester" value="<?= sanitize($_GET["semester"]); ?>" readonly required>
						</div>
					</div>
				</div>	

				<div class="row">
					<div class="col-md-4">
						<div class="mb-3">
							<label>Student Number</label>
							<input class="form-control form-control-lg" type="text" name="studentNumber" required>
						</div>
					</div>

					<div class="col-md-8">
						<div class="mb-3">
							<label>Email Address</label>
							<input class="form-control form-control-lg" type="email" name="emailAddress" required>
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label>First Name</label>
					<input class="form-control form-control-lg" type="text" name="firstname" required>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label>Middle Name</label>
							<input class="form-control form-control-lg" type="text" name="middlename">
						</div>
					</div>

					<div class="col-md-6">
						<div class="mb-3">
							<label>Last Name</label>
							<input class="form-control form-control-lg" type="text" name="lastname" required>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-8">
						<div class="mb-3">
							<label>Course</label>
							<input class="form-control form-control-lg" type="text" name="course" required>
						</div>
					</div>

					<div class="col-md-4">
						<div class="mb-3">
							<label>Year Level</label>
							<input class="form-control form-control-lg" type="text" name="yearLevel" required>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<div class="mb-3">
							<label>Section</label>
							<input class="form-control form-control-lg" type="text" name="section">
						</div>
					</div>

					<div class="col-md-3">
						<div class="mb-3">
							<label>Sex</label>
							<input class="form-control form-control-lg" type="text" name="sex" required>
						</div>
					</div>

					<div class="col-md-3">
						<div class="mb-3">
							<label>Status</label>
							<input class="form-control form-control-lg" type="text" name="status" required>
						</div>
					</div>

					<div class="col-md-3">
						<div class="mb-3">
							<label>Is PWD?</label>
							<input class="form-control form-control-lg" type="text" name="isPWD" required>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label>Subject 1</label>
							<input class="form-control form-control-lg" type="text" name="subject1">
						</div>
					</div>

					<div class="col-md-6">
						<div class="mb-3">
							<label>Subject 2</label>
							<input class="form-control form-control-lg" type="text" name="subject2">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label>Subject 3</label>
							<input class="form-control form-control-lg" type="text" name="subject3">
						</div>
					</div>

					<div class="col-md-6">
						<div class="mb-3">
							<label>Subject 4</label>
							<input class="form-control form-control-lg" type="text" name="subject4">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label>Subject 5</label>
							<input class="form-control form-control-lg" type="text" name="subject5">
						</div>
					</div>

					<div class="col-md-6">
						<div class="mb-3">
							<label>Subject 6</label>
							<input class="form-control form-control-lg" type="text" name="subject6">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label>Subject 7</label>
							<input class="form-control form-control-lg" type="text" name="subject7">
						</div>
					</div>

					<div class="col-md-6">
						<div class="mb-3">
							<label>Subject 8</label>
							<input class="form-control form-control-lg" type="text" name="subject8">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label>Subject 9</label>
							<input class="form-control form-control-lg" type="text" name="subject9">
						</div>
					</div>

					<div class="col-md-6">
						<div class="mb-3">
							<label>Subject 10</label>
							<input class="form-control form-control-lg" type="text" name="subject10">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label>Subject 11</label>
							<input class="form-control form-control-lg" type="text" name="subject11">
						</div>
					</div>

					<div class="col-md-6">
						<div class="mb-3">
							<label>Subject 12</label>
							<input class="form-control form-control-lg" type="text" name="subject12">
						</div>
					</div>
				</div>
			</div>
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
	</form>
</div>

<?php

include $baseUrl . "assets/templates/registrar/footer.inc.php";

?>

<script type="text/javascript">
	$(document).ready(function() { 
		$('#form').submit(function(e) {	
			e.preventDefault();

			$.ajax({
				url: "../../assets/includes/registrar/enrolled-student.inc.php",
				type: "POST",
				data: $('#form').serialize() + "&submitAddEnrolledStudent",
				dataType: "json",
				beforeSend: function(data) {
					$("#submitButton").prop("disabled", true);
					$("#submitButton").html(`<span class="spinner-grow spinner-grow-sm"></span> Loading..`);
				},
				success: function(data) {
					console.log();
					$("#submitButton").prop("disabled", false);
					$("#submitButton").html(`Submit`);

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

					$('#form').trigger("reset");
				}
			});

			return false;
		});
	});
</script>