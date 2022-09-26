<?php
$baseUrl = "../../";
$title = "City College of Angeles - Totalis Humanae";
$page = "classSchedules";

include $baseUrl . "assets/templates/student/header.inc.php";




$_SESSION['eval_set'] = $_GET['e'];
$_SESSION['prof'] = $_GET['p'];
$_SESSION['subject_code'] = $_GET['s'];

$set = $_SESSION['eval_set'];
$stud =  $_SESSION['username'];
$sql = $conn->query("SELECT * FROM response_completed WHERE username = '$stud' AND eval_set = '$set'" );




$info = $conn->query("SELECT * FROM evaluation_set WHERE id = '$set'")->fetch_assoc();
$end = $info['end_date'];
$newDate = date("M d", strtotime($end));


?>

	<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
		<h1 class="h3 mb-3"><?php echo $info['title']; ?></h1>
		<a class="btn btn-primary" href="../">Back</a>
	</div>

<div class="row">
	
	<div class="col-md-8 offset-md-2">
		<div class="card">
			<div class="card-body">
				<h3><b>Description:</b></h3>
				<div style="background: whitesmoke; padding: 30px; ">
					<pre style='margin-bottom: 50px;width: 100%; overflow:hidden; white-space: pre-line; font-family:sans-serif; font-size:16px;'><?php echo $info['description']; ?></pre>
				</div>
					<hr style="margin-top:30px;">
					<div style="float: right;"><h5>This evaluation survey ends on  <b><?php echo $newDate;?></b></h5></div>
					<br>
				<div style="margin-top: 20px;" class="text-center">	
					<a href="evaluate/evaluate-faculty.php?eval=<?php echo $_SESSION['eval_set'] ?>" class="btn btn-success href">Start evaluation</a>
					<!--<button type="button" class="btn btn-success btn-flat start_survey" data-bs-toggle='modal' data-bs-target='#startevaluate' data-bs-name='" <?php //echo$info["title"] ?> "' data-bs-href='evaluate/evaluate-faculty.php?eval=start'>Start evaluation</button>-->
				</div>
			</div>
		</div>

	</div>

</div>

<?php

include $baseUrl . "assets/templates/student/footer.inc.php";

?>

<!--  StartEvaluation MODAL  -->
<!--<div class="modal fade" id="startevaluate" tabindex="-1" aria-labelledby="startevaluate" aria-hidden="true">-->
<!--	<div class="modal-dialog">-->
<!--		<div class="modal-content">-->
<!--			<div class="modal-header">-->
<!--				<h5 class="modal-title" id="startevaluate">Start Evaluation</h5>-->
<!--				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--			</div>-->
<!--			<div class="modal-body">-->
<!--				<p>Are you sure you want to start Evaluation? <b>You are not able to leave the page during evaluating</b></p>-->
<!--			</div>-->
<!--			<div class="modal-footer">-->
<!--				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
<!--				<a href="evaluate/evaluate-faculty.php?eval=<?php echo $_SESSION['eval_set'] ?>" class="btn btn-success href">Start</a>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->


<script type="text/javascript">
	let startevaluate = document.getElementById("startevaluate");

	startevaluate.addEventListener("show.bs.modal", function (event) {
		let button = event.relatedTarget;

		let name = button.getAttribute("data-bs-name");
		let modalBodyName = startevaluate.querySelector(".modal-body .name");
		modalBodyName.innerHTML = name;

		let href = button.getAttribute("data-bs-href");
		let modalFooterHref = startevaluate.querySelector(".modal-footer .href");
		modalFooterHref.href = href;
	});

	history.forward();
</script>