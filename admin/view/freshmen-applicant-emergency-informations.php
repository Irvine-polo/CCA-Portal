<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "freshmenApplicants";

include $baseUrl . "assets/templates/admin/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Freshmen Applicant Emergency Informations</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" href="../freshmen-applicants">
		<i class="fa-solid fa-chevron-left me-2"></i>
		Back
	</a>
</div>

<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-4">
				<label>Academic Year</label>
				<select class="form-select form-select-lg" id="academicYear">
					<option value="">--Select--</option>

					<?php

					$sql = "SELECT * FROM applicant_emergency_informations GROUP BY academic_year";
					$result = mysqli_query($conn, $sql);
					
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<option value='" . $row["academic_year"] . "'>" . $row["academic_year"] . "</option>";
						}
					}

					?>

				</select>
			</div>

			<div class="col-md-4">
				<label>Date Start</label>
				<input class="form-control form-control-lg" type="date" id="dateStart">
			</div>

			<div class="col-md-4">
				<label>Date End</label>
				<input class="form-control form-control-lg" type="date" id="dateEnd">
			</div>
		</div>
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped table-sm w-100" id="datatable">
				<thead>
					<tr>
						<th>Academic Year</th>
						<th>Control Number</th>
						<th>Full Name</th>
						<th>Name of Guardian</th>
						<th>Relationship with Guardian</th>
						<th>Address of Guardian</th>
						<th>Email Address of Guardian</th>
						<th>Contact Number of Guardian</th>
						<th>Occupation of Guardian</th>
						<th>Date Applied</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/admin/footer.inc.php";

?>

<script type="text/javascript">
	$(document).ready( 
		function() {
			var academicYear = $("#academicYear").val();
			var dateStart = $("#dateStart").val();
			var dateEnd = $("#dateEnd").val();

			$('#datatable').DataTable({
				dom: 'Bfrtip',
				buttons: [
					'copy', 'csv', 'excel'
				],
				"ordering": false,
				"processing": true,
				"serverSide": true,
				"ajax":{
					url: `../../assets/api/admin/freshmen-applicant.inc.php?freshmenApplicantEmergencyInformations`,
					type: "POST",
					data: {
						academicYear : academicYear,
						dateStart : dateStart,
						dateEnd : dateEnd
					}
				}
			});
		}
	);

	$("#academicYear").change(function() {
		$('#datatable').DataTable().destroy();		

		var academicYear = $("#academicYear").val();
		var dateStart = $("#dateStart").val();
		var dateEnd = $("#dateEnd").val();

		$('#datatable').DataTable({
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel'
			],
			"ordering": false,
			"processing": true,
			"serverSide": true,
			"ajax":{
				url: `../../assets/api/admin/freshmen-applicant.inc.php?freshmenApplicantEmergencyInformations`,
				type: "POST",
				data: {
					academicYear : academicYear,
					dateStart : dateStart,
					dateEnd : dateEnd
				}
			}
		});
	});

	$("#dateStart").change(function() {
		$('#datatable').DataTable().destroy();		

		var academicYear = $("#academicYear").val();
		var dateStart = $("#dateStart").val();
		var dateEnd = $("#dateEnd").val();

		$('#datatable').DataTable({
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel'
			],
			"ordering": false,
			"processing": true,
			"serverSide": true,
			"ajax":{
				url: `../../assets/api/admin/freshmen-applicant.inc.php?freshmenApplicantEmergencyInformations`,
				type: "POST",
				data: {
					academicYear : academicYear,
					dateStart : dateStart,
					dateEnd : dateEnd
				}
			}
		});
	});

	$("#dateEnd").change(function() {
		$('#datatable').DataTable().destroy();		

		var academicYear = $("#academicYear").val();
		var dateStart = $("#dateStart").val();
		var dateEnd = $("#dateEnd").val();

		$('#datatable').DataTable({
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel'
			],
			"ordering": false,
			"processing": true,
			"serverSide": true,
			"ajax":{
				url: `../../assets/api/admin/freshmen-applicant.inc.php?freshmenApplicantEmergencyInformations`,
				type: "POST",
				data: {
					academicYear : academicYear,
					dateStart : dateStart,
					dateEnd : dateEnd
				}
			}
		});
	});
</script>