<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluations";

include $baseUrl . "assets/templates/vpaa/header.inc.php";

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
				<div class='card-body'> ";
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
							

					</div>	
				<div class='row text-center mb-2'>"; 

			// code...
		
	echo"	</div>


					<div class='col-12'>
						<div class='d-grid'>
						
							
							<a class='btn btn-primary btn-sm' href='evaluations?eval_set=".$info['title']."'>
								View Results
							</a>
							
						
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

include $baseUrl . "assets/templates/vpaa/footer.inc.php";


?>