<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluation";

include $baseUrl . "assets/templates/hr/header.inc.php";
if (isset($_GET['eval'])) {
	$title = $_GET['eval'];
}


?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-3">Evaluation Table - <b><?php echo$title ?></b></h1>
	<a class="btn btn-primary" href="../">Back</a>
</div>

<div class="card">
	<div class="card-body">
		<div class="card-tools">
				
			</div>
			<br>
		<div class="table-responsive">
			
			<table class="table table-striped table-sm w-100" id="list">
				<colgroup>
					<col width="3%">
					<col width="28%">
					<col width="20%">
					<col width="12%">
					<col width="12%">
					<col width="8%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Title Evaluation</th>
						<th>Type</th>
						<th>Start</th>
						<th>End</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM evaluation_set WHERE title = '$title' AND status <> 'completed' order by date(start_date) asc,date(end_date) asc ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td><?php echo$i++; ?></td>
						<td><b><?php $title = $row['title']; echo substr($title,0,100);?></b></td>	
						<td><b><?php echo $row['eval_type']; ?></b></td>
						<td><b><?php echo date("M d, Y",strtotime($row['start_date'])) ?></b></td>
						<td><b><?php echo date("M d, Y",strtotime($row['end_date'])) ?></b></td>
						<td><?php 
						if ($row['status'] == "pending") {
							echo "<span class='badge bg-secondary'>".$row['status']."</span>";
						}
						if ($row['status'] == "active") {
							echo "<span class='badge bg-primary'>".$row['status']."</span>";
						}
						if ($row['status'] == "disable") {
							echo "<span class='badge bg-danger'>".$row['status']."</span>";
						}
						if ($row['status'] == "completed") {
							echo "<span class='badge bg-success'>".$row['status']."</span>";
						}

						 ?></td>
						<td class="text-center">
							<!-- <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item" href="./index.php?page=edit_survey&id=<?php echo $row['id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_survey" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
		                    </div> -->

		                    <div class="btn-group">
		                    <?php if ($row['status'] == "disable"): ?>
		                    	<button type="button" class="btn btn-secondary btn-flat activate_survey" data-bs-toggle='modal' data-bs-target='#activateModal' data-bs-name='" <?php echo$row["title"] ?> "' data-bs-href='api/evaluation.inc.php?activate&id=<?php echo$row["id"] ?>&title=<?php echo$row['title'] ?>'><i class="fa-solid fa-toggle-off"></i></button>
		                    <?php endif ?>
		                    <?php if ($row['status'] == "active"): ?>
		                    	<button type="button" class="btn btn-success btn-flat activate_survey" data-bs-toggle='modal' data-bs-target='#disableModal' data-bs-name='" <?php echo$row["title"] ?> "' data-bs-href='api/evaluation.inc.php?disable&id=<?php echo$row["id"] ?>&title=<?php echo$row['title'] ?>'><i class="fa-solid fa-toggle-on"></i></button>
		                    <?php endif ?>
		                    	

		                        <a href="edit-eval?edit=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <a  href="view-eval?eval=view_evaluation&id=<?php echo $row['id'] ?>" class="btn btn-info btn-flat">
		                          <i class="fas fa-eye"></i>
		                        </a>

		                      
		                     
							
	                      </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>	
		</div>
	</div>

</div>



<?php

include $baseUrl . "assets/templates/hr/footer.inc.php";
?>

<!--  Disable MODAL  -->
<div class="modal fade" id="disableModal" tabindex="-1" aria-labelledby="disableModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="disableModal">Activate Evaluation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to Disable evaluation survey. <strong class="name"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-warning href">Disable</a>
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


<!--  Activate MODAL  -->
<div class="modal fade" id="activateModal" tabindex="-1" aria-labelledby="activateModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="activateModal">Activate Evaluation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to Activate evaluation survey. <strong class="name"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-success href">Activate</a>
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



<!--  DELETE MODAL  -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteModalLabel">Delete Evaluation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to Delete evaluation survey. <strong class="name"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-danger href">Delete</a>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	let deleteModal = document.getElementById("deleteModal");

	deleteModal.addEventListener("show.bs.modal", function (event) {
		let button = event.relatedTarget;

		let name = button.getAttribute("data-bs-name");
		let modalBodyName = deleteModal.querySelector(".modal-body .name");
		modalBodyName.innerHTML = name;

		let href = button.getAttribute("data-bs-href");
		let modalFooterHref = deleteModal.querySelector(".modal-footer .href");
		modalFooterHref.href = href;
	});
</script>



	

<script type="text/javascript">
	$(document).ready(function(){




		$("#list").DataTable({
			"ordering":false,
			"lengthChange": false,
			
		});

	});
</script>

