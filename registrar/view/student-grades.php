<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "studentGrades";

include $baseUrl . "assets/templates/registrar/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">View Student Grades</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" onclick="history.back()">
		<i class="fa-solid fa-chevron-left me-2"></i>
		Back
	</a>
</div>

<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped table-sm w-100" id="datatable">
				<thead>
					<tr>
						<th>Academic Year</th>
						<th>Semester</th>
						<th>Faculty Name</th>
						<th>Class Code</th>
						<th>Course Title</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/registrar/footer.inc.php";

?>

<script type="text/javascript">
	var url = new URL(window.location.href);
	var academicYear = url.searchParams.get("academicYear");
	var semester = url.searchParams.get("semester");

	$(document).ready( 
		function() {
			$('#datatable').DataTable({
				"ordering": false,
				"processing": true,
				"serverSide": true,
				"ajax":{
					url: `../../assets/api/registrar/student-grade.inc.php?getClassRecords&academicYear=${academicYear}&semester=${semester}`,
					type: "POST"
				}
			});
		}
	);
</script>