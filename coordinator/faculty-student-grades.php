<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "facultyStudentGrades";

include $baseUrl . "assets/templates/coordinator/header.inc.php";

?>

<h1 class="h3 mb-3">Student Grades</h1>

<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped table-sm w-100" id="datatable">
				<thead>
					<tr>
						<th>Academic Year</th>
						<th>Semester</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/coordinator/footer.inc.php";

?>

<script type="text/javascript">
	$(document).ready( 
		function() {
			$('#datatable').DataTable({
				"ordering": false,
				"processing": true,
				"serverSide": true,
				"ajax":{
					url: "../assets/api/coordinator/faculty-student-grade.inc.php?getAcademicYears",
					type: "POST"
				}
			});
		}
	);
</script>