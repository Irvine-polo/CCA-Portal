<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "deanUsers";

include $baseUrl . "assets/templates/dean/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Users</h1>

	<div class="d-flex justify-content-between align-items-center">
		<a class="btn btn-primary d-flex justify-content-between align-items-center me-2" href="./add/dean-user">
			<i class="fa-solid fa-plus me-2"></i>
			Add
		</a>

		<a class="btn btn-success d-flex justify-content-between align-items-center" href="./import/dean-users">
			<i class="fa-solid fa-upload me-2"></i>
			Import
		</a>
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped table-sm w-100" id="datatable">
				<thead>
					<tr>
						<th>Avatar</th>
						<th>Institute</th>
						<th>Reference Number</th>
						<th>Faculty Name</th>
						<th>Role</th>
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

<!-- RECOVER MODAL -->
<div class="modal fade" id="recoverModal" tabindex="-1" aria-labelledby="recoverModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="recoverModalLabel">Recover User</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to recover user <strong class="name"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-warning href">Confirm</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	let recoverModal = document.getElementById("recoverModal");

	recoverModal.addEventListener("show.bs.modal", function (event) {
		let button = event.relatedTarget;

		let name = button.getAttribute("data-bs-name");
		let modalBodyName = recoverModal.querySelector(".modal-body .name");
		modalBodyName.innerHTML = name;

		let href = button.getAttribute("data-bs-href");
		let modalFooterHref = recoverModal.querySelector(".modal-footer .href");
		modalFooterHref.href = href;
	});
</script>

<!-- DISABLE MODAL -->
<div class="modal fade" id="disableModal" tabindex="-1" aria-labelledby="disableModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="disableModalLabel">Disable User</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to disable user <strong class="name"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-danger href">Confirm</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	let disableModal = document.getElementById("disableModal");

	disableModal.addEventListener("show.bs.modal", function (event) {
		let button = event.relatedTarget;

		let name = button.getAttribute("data-bs-name");
		let modalBodyName = disableModal.querySelector(".modal-body .name");
		modalBodyName.innerHTML = name;

		let href = button.getAttribute("data-bs-href");
		let modalFooterHref = disableModal.querySelector(".modal-footer .href");
		modalFooterHref.href = href;
	});
</script>

<!-- ENABLE MODAL -->
<div class="modal fade" id="enableModal" tabindex="-1" aria-labelledby="enableModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="enableModalLabel">Enable User</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to enable user <strong class="name"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-success href">Confirm</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	let enableModal = document.getElementById("enableModal");

	enableModal.addEventListener("show.bs.modal", function (event) {
		let button = event.relatedTarget;

		let name = button.getAttribute("data-bs-name");
		let modalBodyName = enableModal.querySelector(".modal-body .name");
		modalBodyName.innerHTML = name;

		let href = button.getAttribute("data-bs-href");
		let modalFooterHref = enableModal.querySelector(".modal-footer .href");
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
					url: "../assets/api/dean/dean-user.inc.php?selectUsers",
					type: "POST"
				}
			});
		}
	);

	Fancybox.bind('[data-fancybox]', {
		Thumbs: {
			autoStart: false,
		},

		Toolbar: {
			display: [
				{ id: "counter", position: "center" },
				{ id: "close", position: "right" },
			],
		},
	});
</script>