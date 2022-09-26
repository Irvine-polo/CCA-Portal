<?php

$baseUrl = "../../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluations_report";
if (isset($_GET['set-date'])) {
	$title = $_GET['set-date'];
	header("Location:set-date/?set-date=".$title);
}
if (isset($_GET['remove-date'])) {
	$title = $_GET['remove-date'];
	header("Location:../api/evaluation.inc.php?remove-date=".$title);
}

include $baseUrl . "assets/templates/hr/header.inc.php";

//update result
$current_date2 = date('Y-m-d');
	$sql2 = $conn->query("SELECT * FROM evaluation_set WHERE status = 'completed' AND start_share <> '0000-00-00'  order by date_created DESC");
	while ($data2 = $sql2->fetch_assoc()) {
		if ($current_date2 >= $data2['start_share'] ) {
			$title = $data2['title'];
			$visible = 1;
			$update = $conn->query("UPDATE evaluation_set SET visible = '$visible' WHERE title = '$title'");
		}
	}

$sql = $conn->query("SELECT DISTINCT title FROM evaluation_set WHERE status = 'completed' ORDER BY date_created DESC");
$sql2 = $conn->query("SELECT DISTINCT title FROM evaluation_set WHERE status = 'completed'")->num_rows;
?>
<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-3">Evaluation Results</h1>	
</div>
<div class="row">
	<?php
		while ($row = $sql->fetch_assoc()) {
			$title = $row['title'];
			$completed = $conn ->query("SELECT * FROM evaluation_set WHERE title = '$title' AND status = 'completed'")->num_rows;
			$total_table = $conn ->query("SELECT * FROM evaluation_set WHERE title = '$title' ")->num_rows;
			$info = $conn ->query("SELECT * FROM evaluation_set WHERE title = '$title'")->fetch_assoc();
			$id = $info['id'];
			$res_num = $conn ->query("SELECT * FROM evaluation_set WHERE title = '$title' AND status = 'completed'");
			$responses = [];
			while($eval_sets = $res_num->fetch_assoc()){
				$id = $eval_sets['id'];
				$res = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$id'");
				$count = 0;
				while($row = $res->fetch_assoc()){
					$count++;
				}
				
				array_push($responses,$count);
			}
			$response = array_sum($responses);
			echo "
	<div class='col-md-6 col-xxl-4'>
			<div class='card'>
				<div class='card-body'>
				<div class='d-flex justify-content-between align-items-center d-print-none mb-3'>
						";
						if ($info['visible'] == 0) {
							echo "<span class='badge bg-secondary'>invisible</span>";
						}
						if ($info['visible'] == 1) {
							echo "<span class='badge bg-success'>visible</span>";
						}
	                    echo"<button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteResult' data-bs-name='".$info['title']."' data-bs-href='../../eval/api/evaluation.inc.php?deleteResult&id=".$info['title']."'><i class='fa fa-trash' aria-hidden='true'></i></button>
					</div> ";

				if ($completed == $total_table) {
					echo"
					<div>
						<p class='text-success'><i class='fa-solid fa-circle-check'></i> Completed</p>
					</div>";
				}
				else{
					echo"
						<div class='mb-3'>
							<div style='height:15px; width:15px;' class='spinner-grow text-warning' role='status'>
							</div><span class='text-warning mb-2'> Ongoing...</span>
						</div>
					";
				}
				
					
				echo"
					<h3 class='text-center mb-0'>".$info['title']."</h3>
					

					<hr>
					<div class='row text-center mb-2'>
							<div class='col-6 fw-bold'>
								Responses
							</div>

							<div class='col-6 fw-bold'>
								Evaluation Tables
								 
							</div>
							<div class='col-6 '>
								".$response."
							</div>

							<div class='col-6'>
								 ".$completed." / ".$total_table."
							</div>
							

					</div>	<hr>
				<div class='row text-center mb-2'>"; 

			if ($completed == $total_table) { 	
				echo"<p class='text-center mb-2'>Share To: <b>Faculty</b></p>";		
					

						if ($info['start_share'] != "0000-00-00") {
							$start = date("M d", strtotime($info['start_share']));
							echo "
							<div class='col-6 fw-bold'>
								<p class='text-center mb-0'>Start Share on:</p>
							</div>

							

							<div class='col-6 '>
								<p class='text-center mb-2'>".$start."</p>
							</div>

							
								";

							echo"
								<p class='text-center mb-0'><a class='text-center mb-0' href='index?remove-date=".$info['title']."'>Remove Set Date</a></p>
							
							";
							}
							else{
								echo"
									<p class='text-center mb-0'><a class='text-center mb-0' href='index?set-date=".$info['title']."'>Set date to share</a></p>
								
								";
							}


							

					}
		
	echo"	</div>


					<div class='col-12'>
						<div class='d-grid'> ";
						
						if ($completed == $total_table) {
							echo "<a class='btn btn-primary btn-sm' href='evaluations?eval_set=".$info['title']."'>
									View Results
								</a>";
						}	
						else{
							echo"<button disabled class='btn btn-primary btn-sm'>View Results</button>";
						}
							
							
echo"						
				</div>
					</div>

				</div>

			</div>
		</div>
		";
			
		}
		if($sql2 == 0){
			echo"
			<div class='col-12'>
				<div class='card'>
					<div class='card-body text-center'>
						There are no Evaluation Completed yet
					
					</div>
				</div>	
			</div>
			";
		}


		?>
</div>

<?php

include $baseUrl . "assets/templates/hr/footer.inc.php";


?>
<!--  Delete MODAL  -->
<div class="modal fade" id="deleteResult" tabindex="-1" aria-labelledby="deleteResult" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteResult">Delete Evaluation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to Delete Evaluation. <strong class="name"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-danger href">Delete </a>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	let deleteResult = document.getElementById("deleteResult");

	deleteResult.addEventListener("show.bs.modal", function (event) {
		let button = event.relatedTarget;

		let name = button.getAttribute("data-bs-name");
		let modalBodyName = deleteResult.querySelector(".modal-body .name");
		modalBodyName.innerHTML = name;

		let href = button.getAttribute("data-bs-href");
		let modalFooterHref = deleteResult.querySelector(".modal-footer .href");
		modalFooterHref.href = href;
	});
</script>

<!--  Activate MODAL  -->
<div class="modal fade" id="activateModal" tabindex="-1" aria-labelledby="activateModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="activateModal">Share Evaluation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to share results with the Faculty. <strong class="name"></strong>?</p>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-success href">Share It</a>
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

<!--  disableshareit MODAL  -->
<div class="modal fade" id="disableShareit" tabindex="-1" aria-labelledby="disableShareit" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="disableShareit">Disable Share Evaluation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to share results with the Faculty. <strong class="name"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-warning href">Disable</a>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	let disableShareit = document.getElementById("disableShareit");

	disableShareit.addEventListener("show.bs.modal", function (event) {
		let button = event.relatedTarget;

		let name = button.getAttribute("data-bs-name");
		let modalBodyName = disableShareit.querySelector(".modal-body .name");
		modalBodyName.innerHTML = name;

		let href = button.getAttribute("data-bs-href");
		let modalFooterHref = disableShareit.querySelector(".modal-footer .href");
		modalFooterHref.href = href;
	});
</script>