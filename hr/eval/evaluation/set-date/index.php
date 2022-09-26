<?php

$baseUrl = "../../../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluations_report";
if (isset($_GET['set-date'])) {
	$title = $_GET['set-date'];
}
include $baseUrl . "assets/templates/hr/header.inc.php";
?>
<div class="d-flex justify-content-between align-items-center d-print-none mb-5">
	<h1 class="h3 mb-0"><?php echo$title." - "."<b>Set Date</b>" ?></h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" onclick="history.back()">
		Back
	</a>
</div>
<div class="row">
	<div class="col-md-6 offset-md-3">
		<form id="form_date" class="card">
			<div class="card-body">
				<div class="mb-3">
					<label class="form-label fw-bold">Start on: </label>
					<div class="input-group">
						<input class="form-control form-control-sm" autocomplete="off" type="text"  id="start_date" name="start_date" placeholder="yyyy/mm/dd" required>
					</div>
				</div>
				<!-- <div class="mb-3">
					<label class="form-label">End: </label>
					<input class="form-control form-control-sm" autocomplete="off" type="text" id="end_date" name="end_date" placeholder="yyyy/mm/dd" required>
				</div> -->
				<div class="text-center">
					<input type="hidden" name="action" id="action" value="insert_share_date" />
					<input type="hidden" name="eval_title" value="<?php echo$title ?>">
					<input name="form-action" id="form_action" type="submit" class="btn btn-success" value="Set">
				</div>
			</div>
		</form>	
	</div>
</div>



<?php

include $baseUrl . "assets/templates/hr/footer.inc.php";

?>
<!-- Date picker  -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<script type="text/javascript">

	//date pick
	$(document).ready(function(){
		var minDate = new Date();
			$("#start_date").datepicker({
				showAnim: 'drop',
				numberOfMonth: 1,
				minDate: minDate,
				maxDate: "1m",
				dateFormat:'yy-m-d ',
					onClose: function(selectedDate){
						$('#end_date').datepicker("option","minDate",selectedDate);
				}
			});

		

			$("#end_date").datepicker({
				showAnim: 'drop',
				numberOfMonth: 1,
				minDate: minDate,
				maxDate: "1m" ,
				dateFormat:'yy-m-d',
				onClose: function(selectedDate){
			//			$('#Start').datepicker("option","minDate",selectedDate);
				}
			});
	});

	$(document).ready(function(){
		$('#form_date').on('submit', function(event){
			event.preventDefault();
			$('#form_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"../../api/evaluation.inc",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					 Swal.fire({
						  position: 'center',
						  icon: 'success',
						  title: 'Success!',
						  text:'Date Set Successfully',
						  showConfirmButton: false,
						  timer: 1500
						}).then(function() {
						     window.location.href='../../evaluation/';
						});

				}
			});
		});
	});
</script>