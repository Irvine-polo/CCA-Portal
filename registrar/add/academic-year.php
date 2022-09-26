<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "academicYears";

include $baseUrl . "assets/templates/registrar/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Add Academic Year</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" onclick="history.back()">
		<i class="fa-solid fa-chevron-left me-2"></i>
		Back
	</a>
</div>

<div class="row">
	<div class="col-md-6 offset-md-3">
		<form class="card" id="form" autocomplete="off">
			<div class="card-body">
				<div class="mb-3">
					<label class="form-label">Academic Year</label>
					<div class="input-group">
						<input class="form-control form-control-lg" id="academicYearStart" data-type="number" type="text" pattern="(20[0-5][0-9])" name="academicYearStart" required>
						<span class="input-group-text">-</span>
						<input class="form-control form-control-lg" id="academicYearEnd" disabled>
					</div>
				</div>

				<div class="mb-3">
					<label class="form-label">Semester</label>
					<select class="form-select form-select-lg" name="semester" required>
						<option value="" selected disabled>--Select Semester--</option>
						<option value="1st">1st</option>
						<option value="2nd">2nd</option>
						<option value="Summer">Summer</option>
					</select>
				</div>

				<div class="mb-3">
					<label class="form-check user-select-none">
						<input class="form-check-input" type="checkbox" name="setCurrentAcademicYear" checked>
						<span class="form-check-label">Set as current Academic Year</span>
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

include $baseUrl . "assets/templates/registrar/footer.inc.php";

?>

<script type="text/javascript">
	$(document).ready(function() { 
		$('#form').submit(function(e) {	
			e.preventDefault();

			let formData = new FormData(this);
			formData.append("submitAddAcademicYear", "");

			$.ajax({
				url: "../../assets/includes/registrar/academic-year.inc.php",
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

					$('#form').trigger("reset");
				}
			});

			return false;
		});
	});

	let academicYearStart = document.querySelector("#academicYearStart");
	let academicYearEnd = document.querySelector("#academicYearEnd");

	if (academicYearStart.value != "") {
		academicYearEnd.value = +academicYearStart.value + 1;
	}

	academicYearStart.oninput = () => {
		if (academicYearStart.value == "") {
			academicYearEnd.value = "";
		} else {
			if (academicYearStart.value.length == 4) {
				academicYearEnd.value = +academicYearStart.value + 1;	
			} else {
				academicYearEnd.value = "...";
			}
		}
	};
</script>