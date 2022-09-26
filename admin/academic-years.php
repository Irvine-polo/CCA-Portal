<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "academicYears";

include $baseUrl . "assets/templates/admin/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Academic Years</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" href="./add/academic-year">
		<i class="fa-solid fa-plus me-2"></i>
		Add
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
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/admin/footer.inc.php";

?>

<!-- ENABLE MODAL -->
<div class="modal fade" id="activateModal" tabindex="-1" aria-labelledby="activateModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="activateModalLabel">Activate Academic Year</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to activete <strong class="name"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-success href">Confirm</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	let activateModal = document.getElementById("activateModal");

	activateModal.addEventListener("show.bs.modal", function (event) {
		let button = event.relatedTarget;

		let name = button.getAttribute("data-bs-name");
		let modalBodyName = activateModal.querySelector(".modal-body .name");
		modalBodyName.innerHTML = name;

		let href = button.getAttribute("data-bs-href");
		let modalFooterHref = activateModal.querySelector(".modal-footer .href");
		modalFooterHref.href = href;
	});
</script>

<script type="text/javascript">
	$(document).ready( 
		function() {
			$('#datatable').DataTable({
				"ordering": false,
				"processing": true,
				"serverSide": true,
				"ajax":{
					url: "../assets/api/admin/academic-year.inc.php?getAcademicYears",
					type: "POST"
				}
			});
		}
	);

	var url = new URL(window.location.href);
	var error = url.searchParams.get("error");
	var success = url.searchParams.get("success");

	if (error != null) {
		Swal.fire(
			'Error!',
			error + '.',
			'error'
		)
	}

	if (success != null) {
		Swal.fire(
			'Success!',
			success + '.',
			'success'
		)
	}
</script>