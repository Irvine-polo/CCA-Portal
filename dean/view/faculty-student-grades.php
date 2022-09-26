<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "facultyStudentGrades";

include $baseUrl . "assets/templates/dean/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">View Student Grades</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" href="../faculty-student-grades">
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
						<th>Section</th>
						<th>Class Code</th>
						<th>Course Code</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/dean/footer.inc.php";

?>

<!-- FINALIZE MODAL -->
<div class="modal fade" id="finalizeModal" tabindex="-1" aria-labelledby="finalizeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="finalizeModalLabel">Finalize Grades</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to finalize Class Code <strong class="name"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-main href">Confirm</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	let finalizeModal = document.getElementById("finalizeModal");

	finalizeModal.addEventListener("show.bs.modal", function (event) {
		let button = event.relatedTarget;

		let name = button.getAttribute("data-bs-name");
		let modalBodyName = finalizeModal.querySelector(".modal-body .name");
		modalBodyName.innerHTML = name;

		let href = button.getAttribute("data-bs-href");
		let modalFooterHref = finalizeModal.querySelector(".modal-footer .href");
		modalFooterHref.href = href;
	});
</script>

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
					url: `../../assets/api/dean/faculty-student-grade.inc.php?getClassRecords&academicYear=${academicYear}&semester=${semester}`,
					type: "POST"
				}
			});
		}
	);
</script>