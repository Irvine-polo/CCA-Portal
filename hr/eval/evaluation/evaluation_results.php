<?php

$baseUrl = "../../../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluations_report";
include $baseUrl . "assets/templates/hr/header.inc.php";

if (isset($_GET['eval_set'])) {
	$eval_set = $_GET['eval_set'];
	$_SESSION['eval'] = $_GET['eval_set'];
}
$institute = $_SESSION['institute'];
/*
$sql = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set'");
while ($row = $sql->fetch_assoc()) {
	$evaluator = $row['username'];
	$evaluating = $row['faculty_id'];

}
*/

$info = $conn->query("SELECT * FROM evaluation_set WHERE id = '$eval_set'")->fetch_assoc();
?>
<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0"><?php echo$info['title']." - <b>".$info['eval_type']."</b>" ?></h1>

	<div class="d-flex align-items-center">
		
		<select class="form-select me-2" id="faculty">
			<?php 

				$sql_option = $conn->query("SELECT DISTINCT faculty_id,eval_set FROM response_completed LEFT JOIN users ON response_completed.faculty_id = users.username WHERE eval_set = '$eval_set' ");
				
				while($row_option = $sql_option->fetch_assoc()){
					
					$username = $row_option['faculty_id'];
					$faculty_name = $conn->query("SELECT * FROM users WHERE username = '$username'")->fetch_assoc();
					//echo"<option selected='selected'hidden value='".$row_option['faculty_id']."'>".$row_option['faculty_id']."</option>";
					echo"<option selected='selected' value='".$row_option['faculty_id']."'>".$row_option['faculty_id']." - ".$faculty_name['lastname'].", ".$faculty_name['firstname']."</option>";
				}

			 ?>
		</select>
		
		<a class="btn btn-primary" href="./evaluations?eval_set=<?php echo$info['title'] ?>">Back</a>

	</div>

</div>

<div id="eval-results"></div>

<?php

include $baseUrl . "assets/templates/hr/footer.inc.php";


?>
<script type="text/javascript">
	$(document).ready(function(){


		$.ajax({
			url:"api/faculty-fetch-record.php?faculty="+$("#faculty").val(),
			type:"GET",
			dataType:"html",
			success: function(data){
				$("#eval-results").html(data);
			}

		});


		$(document).on("change", "#faculty", function(){
			$.ajax({
					url:"api/faculty-fetch-record.php?faculty="+$("#faculty").val(),
					type:"GET",
					dataType:"html",
					success: function(data){
						$("#eval-results").html(data);
					}

				});
		});


	});
</script>