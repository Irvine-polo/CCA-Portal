<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluations";

include $baseUrl . "assets/templates/admin/header.inc.php";
if (isset($_GET['eval_set'])) {
	$eval_set = $_GET['eval_set'];
	$sql = $conn->query("SELECT DISTINCT title FROM evaluation_set WHERE status = 'completed' AND title = '$eval_set'");
	$completed = $conn ->query("SELECT * FROM evaluation_set WHERE title = '$eval_set' AND status = 'completed'")->num_rows;
	$total_table = $conn ->query("SELECT * FROM evaluation_set WHERE title = '$eval_set' ")->num_rows;
}
if ($completed == $total_table) {
	echo"
	<div>
		<p ><strong>Status: </strong><i class='fa-solid fa-circle-check text-success'></i><span class='text-success'> Completed</span></p>
	</div>";
}
else{
	echo"
		<div class='mb-3'>
		<strong>Status: </strong>
		<div style='height:15px; width:15px;' class='spinner-grow text-warning' role='status'>
			</div><span class='text-warning mb-2'> Ongoing...</span>
		</div>
	";
}
?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-3"><?php echo$eval_set ?></h1>
	<div class="d-flex align-items-center">
		<select class="form-select me-2" id="faculty">
			<option selected='selected' value='All'>All</option>
			<?php 
				$sql = $conn->query("SELECT * FROM evaluation_set WHERE title = '$eval_set'");
				while ($row = $sql->fetch_assoc()) {
					$id_e = $row['id'];
					$res_comp = $conn->query("SELECT DISTINCT faculty_id,eval_set,lastname,firstname FROM response_completed LEFT JOIN users ON response_completed.faculty_id = users.username WHERE eval_set = '$id_e'  order by faculty_id ASC");
				}

				while($row2 = $res_comp ->fetch_assoc()) {
					$username = $row2['faculty_id'];
					$sql_facul = $conn->query("SELECT * FROM users WHERE username = '$username'")->fetch_assoc();
					
					echo"<option  value='".$username."'>".$row2['lastname'].", ".$row2['firstname']."</option>";
				}
			
			 ?>
		</select>
		<a class="btn btn-primary" href="./">Back</a>
		
	</div>	
	
</div>
<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<div class="d-flex align-items-center">
		<select class="form-select me-2" id="filter_institute">
			<option  selected value="" hidden>All Institutes</option>
			<option  value="All">All Institutes</option>
			<option  value="ICSLIS">ICSLIS - Institute of Computing Studies and Library Information Science</option>
			<option  value="IBM">IBM - Institute of Business and Management</option>
			<option  value="IEAS">IEAS - Institute of Education Arts and Sciences</option>
		</select>
		
	</div>
		<button  onClick='print()' class='btn btn-success d-print-none'><i class='fa fa-print'></i> Print</button>
</div>

	<div id="eval-results"></div>
<?php

include $baseUrl . "assets/templates/admin/footer.inc.php";

?>
<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
			url:"api/geteval-result.php?eval_type=<?php echo$eval_set ?>&type=all",
			type:"GET",
			dataType:"html",
			beforeSend: function () {
			$('#eval-results').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
			},
			success: function(data){
				$("#eval-results").html(data);
			}

		});
		$(document).on("change", "#faculty", function(){
			$.ajax({
					url:"api/geteval-result.php?title=<?php echo$eval_set ?>&faculty="+$("#faculty").val(),
					type:"GET",
					dataType:"html",
					beforeSend: function () {
					$('#eval-results').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
					},
					success: function(data){
						$("#eval-results").html(data);
					}
					

				});
		});

		$(document).on("change", "#filter_institute", function(){
			$.ajax({
					url:"api/geteval-result.php?title=<?php echo$eval_set ?>&filter_institute="+$("#filter_institute").val(),
					type:"GET",
					dataType:"html",
					beforeSend: function () {
					$('#eval-results').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
					},
					success: function(data){
						$("#eval-results").html(data);
					}
					

				});
		});



	});
</script>
