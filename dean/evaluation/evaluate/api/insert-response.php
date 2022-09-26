<?php
$baseUrl = "../../../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "classSchedules";

include $baseUrl . "assets/templates/dean/header.inc.php";

if (isset($_POST['action'])) {
	if ($_POST['action'] == 'insert_answer') {
		$eval_set = $_POST['eval_set'];
		$prof_id = $_POST['prof_id'];
		$faculty_evaluator =$_POST['faculty_evaluator'];
		$role =$_POST['role'];

		//array
		$header_id =$_POST['header'];
		$answers = $_POST['answers'];
		$qid = $_POST['qid'];
		$total_row = count($qid);
		$repetition = 1;

		if (empty($prof_id)) {
			$prof_id = $faculty_evaluator;
		}
		

		$sql_insert = $conn->query("INSERT INTO response_completed(eval_set,faculty_id,username,role)VALUES('$eval_set','$prof_id','$faculty_evaluator','$role')");

		if ($sql_insert) {
			$try = $conn->query("SELECT username,eval_set,max(id) as newId FROM response_completed WHERE eval_set = '$eval_set' AND username = '$faculty_evaluator'")->fetch_assoc();
			$newID = $try['newId'];
			foreach ($qid as $key => $qid) {
				$head_id = $header_id[$qid];
				$ans = $answers[$qid];

				$sql = $conn->query("INSERT INTO responses(eval_set,header_id,qid,answer,username,faculty_id,completed_id)VALUES('$eval_set','$head_id','$qid','$ans','$faculty_evaluator','$prof_id','$newID')");
				$repetition++;
				if ($sql) {
					unset($_SESSION['attempt']);
					unset($_SESSION['eval_set']);
					unset($_SESSION['key']);
					//header("Location:".$_SESSION['student_sub']."");
					?>	
					

					<?php
					
				}
				
			}
		}





	}
}	