<?php

$baseUrl = "../../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluations_report";

include $baseUrl . "assets/templates/hr/header.inc.php";
if (isset($_GET['view'])) {
	$faculty_id = $_GET['fid'];
	$eval_set = $_GET['eval_set'];
	$role =  $_GET['role'];
}
if (isset($_GET['stud_view'])) {
	$faculty_id = $_GET['fid'];
	$eval_set = $_GET['eval_set'];
	$role =  $_GET['role'];
}
if (isset($_GET['peer'])) {
	$faculty_id = $_GET['fid'];
	$eval_set = $_GET['eval_set'];
	$role =  $_GET['role'];

}
if (isset($_GET['self'])) {
	$faculty_id = $_GET['fid'];
	$eval_set = $_GET['eval_set'];
	$role =  $_GET['role'];
}
$title_info = $conn->query("SELECT * FROM evaluation_set WHERE id = '$eval_set'")->fetch_assoc();
$title = $title_info['title'];
$eval_type = $title_info['eval_type'];
?>
<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0"><?php echo$title." - <b>".$eval_type."</b>" ?></h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" onclick="history.back()">
			Back
	</a>
</div>

	
	<div id="view-results"></div>


<?php

include $baseUrl . "assets/templates/hr/footer.inc.php";

?>
<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
			url:"api/faculty-fetch-record.php?eval_set=<?php echo$eval_set ?>&faculty=<?php echo$faculty_id ?>&role=<?php echo$role ?>",
			type:"GET",
			dataType:"html",
			beforeSend: function () {
			$('#view-results').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
			},
			success: function(data){
				$("#view-results").html(data);
			}

		});
	});
</script>