<?php

$baseUrl = "../../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluation_result";

include $baseUrl . "assets/templates/faculty/header.inc.php";


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




$sql = $conn->query("SELECT DISTINCT title FROM evaluation_set WHERE status = 'completed' AND visible = '1' ORDER BY date_created DESC");
$sql2 = $conn->query("SELECT DISTINCT title FROM evaluation_set WHERE status = 'completed' AND visible = '1'")->num_rows;
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
			// $res_num = $conn ->query("SELECT * FROM evaluation_set WHERE title = '$title' AND status = 'completed'");
			// $responses = [];
			// while($eval_sets = $res_num->fetch_assoc()){
			// 	$id = $eval_sets['id'];
			// 	$res = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$id'");
			// 	$count = 0;
			// 	while($row = $res->fetch_assoc()){
			// 		$count++;
			// 	}
				
			// 	array_push($responses,$count);
			// }
			// $response = array_sum($responses);
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
								Date Completed
							</div>

							<div class='col-6 '>
								".date("M d, Y",strtotime($info['date_completed']))."
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

include $baseUrl . "assets/templates/faculty/footer.inc.php";


?>