<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluation-tab";

include $baseUrl . "assets/templates/coordinator/header.inc.php";
//update evaluations
$sql = $conn->query("SELECT * FROM evaluation_set WHERE status <>'completed' order by date_created ASC");
$current_date = date('Y-m-d');
while ($data = $sql->fetch_assoc()) {
	if ($current_date < $data['start_date']) {
		$id = $data['id'];
		$status = 'pending';
		$update = $conn->query("UPDATE evaluation_set SET status = '$status' WHERE id = '$id'");
	}
	elseif ($data['start_date'] <= $current_date && $data['status'] == 'pending' ) {
		$id = $data['id'];
		$status = 'active';
		$update = $conn->query("UPDATE evaluation_set SET status = '$status' WHERE id = '$id' AND status = 'pending' ");
		//echo $status;
	}
	elseif ($current_date >= $data['end_date'] && $data['status'] == 'active') {
		$id = $data['id'];

		$status = 'completed';
		$update = $conn->query("UPDATE evaluation_set SET date_completed = '$current_date', status = '$status' WHERE id = '$id' AND status = 'active'");
	}
	
}
?>


<div class="row">	
<?php 

if (isset($_GET['eval_peer']) == 'true') {
	$_SESSION['eval_set'] = $_GET['eval'];

	?>
	<script type="text/javascript">
		 window.location.href='evaluation/';
	</script>
<?php	
}
if (isset($_GET['eval_self']) == 'true') {
	$_SESSION['eval_set'] = $_GET['eval'];
	
	?>
	<script type="text/javascript">
		 window.location.href='evaluation/';
	</script>
<?php	
}


$referenceNumber = $_SESSION["username"];
$user_info = $conn->query("SELECT * FROM users WHERE username = '$referenceNumber'")->fetch_assoc();
$institute = $user_info['institute'];
$exist = $conn->query("SELECT * FROM evaluation_set WHERE status = 'active' AND eval_type = 'Peer_Evaluation' OR eval_type = 'Self_Evaluation'")->num_rows;

if ($exist != 0) {
	$info = $conn->query("SELECT * FROM evaluation_set WHERE status = 'active' AND eval_type = 'Peer_Evaluation' OR eval_type = 'Self_Evaluation'");
	echo "<h1 id='evaluation' style='display:none;' class='h3 mb-3'>Faculty Evaluation</h1>";
	echo"
		<div class='col-12' id='message'>
			<div class='card'>
				<div class='card-body text-center'>
					There are no Evaluation available
				</div>
			</div>
		</div>
	";
	while($row_info = $info->fetch_assoc()){
		$eval_type = $row_info['eval_type'];

		if ($eval_type == "Peer_Evaluation") {
			if ($row_info['status'] == "active") {
				
			$evaluation_id = $row_info['id'];
			
			$end = $row_info['end_date'];
			$newDate = date("M d", strtotime($end));
			$exists = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$evaluation_id' AND username = '$referenceNumber'")->num_rows;

			if ($exists < 2) {
				?>
					<div class='col-md-6 col-xxl-4'>
						<div class='card'>
							<div class='card-body'>
								<h3 class='text-center mb-0'><?php echo$row_info['title'] ?></h3>
								<p class='text-center mb-0'><?php echo$row_info['eval_type']; ?></p>
								<hr>
								<div class='row text-center mb-2'>
									
										<div class='col-6 fw-bold'>
											Evaluated
										</div>
										<div class='col-6 fw-bold'>
											Due
										</div>
										
										<div class='col-6'>
										<?php 
										
										echo $exists . " / 2";

										
										 ?>
										
										</div>
										<div class='col-6'>
											<?php echo $newDate;?>
										</div>
									</div>

								<div class="text-center">
									<div class='col-12'>
										<div class='d-grid'>
										<?php 	
											if ($exists < 2) {
												$_SESSION['key'] = $_SESSION["username"];
												
												echo '<a href="evaluation/eval?eval_peer='.$evaluation_id.'" class="btn btn-info btn-sm">Evaluate Faculty</a>';
												}
										 ?>	
												
										</div>
									</div>
								</div>
							</div>
						
					</div>




				</div>


				<script type="text/javascript">
					document.getElementById("evaluation").style.display = "block";
					document.getElementById("message").style.display = "none";
					
				</script>
<?php   		}
			}
		}
		elseif ($eval_type == "Self_Evaluation") {
			if ($row_info['status'] == "active") {
				
			
			$evaluation_id = $row_info['id'];
			
			$end = $row_info['end_date'];
			$newDate = date("M d", strtotime($end));
			$exists = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$evaluation_id' AND username = '$referenceNumber'")->num_rows;

			if ($exists < 1) {
				?>
					<div class='col-md-6 col-xxl-4'>
						<div class='card'>
							<div class='card-body'>
								<h3 class='text-center mb-0'><?php echo$row_info['title'] ?></h3>
								<p class='text-center mb-0'><?php echo$row_info['eval_type']; ?></p>
								<hr>
								<div class='row text-center mb-2'>
									
										<div class='col-6 fw-bold'>
											Evaluated
										</div>
										<div class='col-6 fw-bold'>
											Due
										</div>
										
										<div class='col-6'>
										<?php 
										
										echo $exists . " / 1";

										
										 ?>
										
										</div>
										<div class='col-6'>
											<?php echo $newDate;?>
										</div>
									</div>

								<div class="text-center">
									<div class='col-12'>
										<div class='d-grid'>
										<?php 	
											if ($exists < 1) {
												echo '<a href="evaluation/eval?eval_self='.$evaluation_id.'" class="btn btn-info btn-sm">Evaluate Faculty</a>';
												}
										 ?>	
												
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
				<script type="text/javascript">
					document.getElementById("evaluation").style.display = "block";
					document.getElementById("message").style.display = "none";
				</script>
<?php
				}
			}
		}
	}
}

//for vpaa dean coor 
$exits_validation = $conn->query("SELECT * FROM users WHERE username = '$referenceNumber' AND (role = 'vpaa' OR role = 'dean' OR role = 'coordinator')")->num_rows;
$desig_title = $conn->query("SELECT * FROM users WHERE username = '$referenceNumber'")->fetch_assoc();
if ($exits_validation > 0) {
	$sql_eval = $conn->query("SELECT * FROM evaluation_set WHERE status = 'active' AND eval_type = 'Faculty_Performance_Head' order by date_created ASC");
	while ($row_eval = $sql_eval->fetch_assoc()) {
		$evaluation_id = $row_eval['id'];

		$newDate = date("M d", strtotime($row_eval['end_date']));
		$sql_response_complete = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$evaluation_id' AND username = '$referenceNumber'")->num_rows;
		
		if ($desig_title['role'] == 'VPAA') {
			$_SESSION['vpaa'] = $desig_title['role'];
			$facul_num = $conn->query("SELECT * FROM users WHERE role = 'faculty' AND username <> '$referenceNumber'")->num_rows;
		}else{
			$facul_num = $conn->query("SELECT * FROM users WHERE institute = '$institute' AND username <> '$referenceNumber'")->num_rows;
		}
		if ($sql_response_complete < $facul_num) {
			?>
			<div class='col-md-6 col-xxl-4'>
								<div class='card'>
									<div class='card-body'>
										<h3 class='text-center mb-0'><?php echo$row_eval['title'] ?></h3>
										<p class='text-center mb-0'><?php echo$row_eval['eval_type']; ?></p>
										<hr>
										<div class='row text-center mb-2'>											
												<div class='col-6 fw-bold'>
													Evaluated
												</div>
												<div class='col-6 fw-bold'>
													Due
												</div>											
												<div class='col-6'>
												<?php echo $sql_response_complete . " / ".$facul_num; ?>
												</div>
												<div class='col-6'>
													<?php echo $newDate;?>
												</div>
											</div>
										<div class="text-center">
											<div class='col-12'>
												<div class='d-grid'>
												<?php 	

													if ($sql_response_complete < $facul_num) {
														echo '<a id="evaluation"href="evaluation/eval?eval_head='.$evaluation_id.'" class="btn btn-info btn-sm">Evaluate Faculty</a>';
														}
												 ?>		
												 
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>	
						<script type="text/javascript">

							document.getElementById("evaluation").style.display = "block";
							document.getElementById("message").style.display = "none";
						</script>
			<?php
		}
	}
}



 ?>
</div>




<?php

include $baseUrl . "assets/templates/coordinator/footer.inc.php";

?>