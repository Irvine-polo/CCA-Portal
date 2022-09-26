<?php

$baseUrl = "../../";
$title = "City College of Angeles - Totalis Humanae";
$page = "evaluation-tab";


include $baseUrl . "assets/templates/vpaa/header.inc.php";


if (isset($_GET['eval_peer'])) {
	$eval_id = $_GET['eval_peer'];
	$_SESSION['eval_set'] = $eval_id;
	$info = $conn->query("SELECT * FROM evaluation_set WHERE id = '$eval_id' AND eval_type = 'Peer_Evaluation' AND status = 'active'")->fetch_assoc();
}

elseif (isset($_GET['eval_self'])) {
	$eval_id2 = $_GET['eval_self'];
	$_SESSION['eval_set'] = $eval_id2;
	$info = $conn->query("SELECT * FROM evaluation_set WHERE id = '$eval_id2' AND eval_type = 'Self_Evaluation' AND status = 'active'")->fetch_assoc();
}
elseif (isset($_GET['eval_head'])) {
	$eval_id3 = $_GET['eval_head'];
	$_SESSION['eval_set'] = $eval_id3;
	$info = $conn->query("SELECT * FROM evaluation_set WHERE id = '$eval_id3' AND eval_type = 'Faculty_Performance_Head' AND status = 'active'")->fetch_assoc();
}

elseif (isset($_GET['start-evaluation']) == 'true') {
	$_SESSION['attempt'] = $_SESSION['username'];
	$_SESSION['eval_set'] = $_SESSION['eval_set'];
	?>
	<script type="text/javascript">
		 window.location.href='evaluate/faculty-form';
	</script>
	<?php
}


$end = $info['end_date'];
$newDate = date("M d", strtotime($end));
?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
		<h1 class="h3 mb-3"><?php echo $info['title']; ?></h1>
		<a class="btn btn-primary" href="../evaluation-tab">Back</a>
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
				    <a href="eval.php?start-evaluation=true" class="btn btn-success">Start evaluation</a>
					
				</div>
			</div>
		</div>

	</div>

</div>
<?php

include $baseUrl . "assets/templates/vpaa/footer.inc.php";

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
<!--				<a href="eval.php?start-evaluation=true" class="btn btn-success href">Start</a>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
<script type="text/javascript">
	history.forward();
</script>