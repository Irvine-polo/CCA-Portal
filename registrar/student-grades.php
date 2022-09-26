<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "studentGrades";

include $baseUrl . "assets/templates/registrar/header.inc.php";

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

				<tbody>
					<tr>
						<td>2021-2022</td>
						<td>1st</td>
						<td>
							<span class="badge bg-secondary">pending</span>
						</td>
						<td>
							<a class="btn btn-success btn-sm" href="./import/student-grades">Import</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/registrar/footer.inc.php";

?>

<script type="text/javascript">
	$(document).ready( 
		function() {
			$('#datatable').DataTable({
				"ordering": false,
				"processing": true,
				"serverSide": true,
				"ajax":{
					url: "../assets/api/registrar/student-grade.inc.php?getAcademicYears",
					type: "POST"
				}
			});
		}
	);
</script>