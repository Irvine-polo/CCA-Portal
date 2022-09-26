<?php 

$baseUrl = "../../../../";
$title = "City College of Angeles - Totalis Humanae";
$page = "classSchedules";
include $baseUrl . "assets/templates/student/header.inc.php";

if (isset($_POST['action'])) {
	if ($_POST['action'] == 'insert_answer') {
		$eval_set = $_POST['eval_set'];
		$prof_id = $_POST['prof_id'];
		$student_id =$_POST['student_id'];
		$role =$_POST['role'];
		$subject_code = $_POST['subject_code'];

		//array
		$header_id =$_POST['header'];
		$answers = $_POST['answers'];
		$qid = $_POST['qid'];
		$total_row = count($qid);
		$repetition = 1;

		
		

		$sql_insert = $conn->query("INSERT INTO response_completed(eval_set,faculty_id,subject_code,username,role)VALUES('$eval_set','$prof_id','$subject_code','$student_id','$role')");

		if ($sql_insert) {
			$try = $conn->query("SELECT username,eval_set,max(id) as newId FROM response_completed WHERE eval_set = '$eval_set' AND username = '$student_id'")->fetch_assoc();
			$newID = $try['newId'];
			foreach ($qid as $key => $qid) {
				$head_id = $header_id[$qid];
				$ans = $answers[$qid];

				$sql = $conn->query("INSERT INTO responses(eval_set,header_id,qid,answer,username,faculty_id,completed_id)VALUES('$eval_set','$head_id','$qid','$ans','$student_id','$prof_id','$newID')");
				$repetition++;
				if ($repetition >= $total_row) {
					unset($_SESSION['attempt']);
					unset($_SESSION['eval_set']);

					//header("Location:".$_SESSION['student_sub']."");
					?>	
					

					<?php
					
				}
				
			}
		}
		

	}
}


 ?>
 <!-- ADMIN KIT JS -->
<script src="<?= $baseUrl; ?>assets/js/app.js"></script>
<!-- JQUERY JS -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- MAIN JS -->
<script src="<?= $baseUrl; ?>assets/js/main.js"></script>