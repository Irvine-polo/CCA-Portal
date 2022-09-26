<?php

$baseUrl = "../../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluation_result";

include $baseUrl . "assets/templates/faculty/header.inc.php";
$institute = $_SESSION['institute'];
$faculty = $_SESSION['username'];
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
		
		<a class="btn btn-primary" href="./">Back</a>
		
	</div>	
	
</div>
<div class="text-end mb-3">
		<button  onClick='print()' class='btn btn-success d-print-none'><i class='fa fa-print'></i> Print</button>
</div>

	<div id="eval-results"></div>
<?php

include $baseUrl . "assets/templates/faculty/footer.inc.php";

?>
<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
			url:"api/geteval-result.php?eval_type=<?php echo$eval_set ?>&faculty=<?php echo$faculty ?>&type=all",
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
</script>
