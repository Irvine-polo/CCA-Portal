<?php 
$baseUrl = "../../../";
   



include $baseUrl . "assets/includes/dbh.inc.php";

?><script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script><?php
if (isset($_POST['action'])) {
	if ($_POST['action'] == "insert") {
	
		$academicYearStart = $_POST['academicYearStart'];
		$academicYearEnd =$_POST['academicYearStart']+1;
		$semester =$_POST['semester'];
		$title = "Academic Year ".$academicYearStart."-".$academicYearEnd." ".$semester." Semester";
		$start = $_POST['start_date'];
		$end = $_POST['end_date'];
		$status = 'pending';
		// $eval_type = $_POST['eval_type'];

		
		
		
		// $desc = $_POST['description'];
		// $description = filter_var($desc,FILTER_SANITIZE_STRING);
		

		$check = $conn->query("SELECT * FROM evaluation_set WHERE title = '$title'");

		if ($check->num_rows == 0) {
			$eval_type = "Faculty_Performance_Head";
			$order_by = 1;

			$sql = $conn->query("INSERT INTO evaluation_set (academicyear_start,academicyear_end,semester,title,eval_type,start_date,end_date,order_by,status)VALUES('$academicYearStart','$academicYearEnd','$semester','$title','$eval_type','$start','$end','$order_by','$status')");

				if ($sql) {
					$newID_eval = $conn->query("SELECT * FROM evaluation_set WHERE title = '$title' AND eval_type = '$eval_type'")->fetch_assoc();
					$id = $newID_eval['id'];
					$q_title = "Faculty Name";
					$percent = 0;
					$insert_title = $conn->query("INSERT INTO title_question (title,percentage,order_by,evaluation_table)VALUES('$q_title','$percent','1','$id')");
					$newID_title = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$id' AND title = '$q_title'")->fetch_assoc();
					$t_id = $newID_title['id'];

					$q = "Name of Faculty Evaluated";
					$insert_q = $conn->query("INSERT INTO questions (question,q_type,q_order_by,survey_id,header_id)VALUES('$q','drop_down','1','$id','$t_id')");
				

					if ($insert_q) {
						$eval_type = "Faculty_Performance";
						$order_by = 2;
						$sql2 = $conn->query("INSERT INTO evaluation_set (academicyear_start,academicyear_end,semester,title,eval_type,start_date,end_date,order_by,status)VALUES('$academicYearStart','$academicYearEnd','$semester','$title','$eval_type','$start','$end','$order_by','$status')");

						if ($sql2) {
							$eval_type = "Peer_Evaluation";
							$order_by = 3;
							$sql3 = $conn->query("INSERT INTO evaluation_set (academicyear_start,academicyear_end,semester,title,eval_type,start_date,end_date,order_by,status)VALUES('$academicYearStart','$academicYearEnd','$semester','$title','$eval_type','$start','$end','$order_by','$status')");

							if ($sql3) {
								$newID_eval = $conn->query("SELECT * FROM evaluation_set WHERE title = '$title' AND eval_type = '$eval_type'")->fetch_assoc();
								$id = $newID_eval['id'];
								$q_title = "Faculty Name";
								$percent = 0;
								$insert_title = $conn->query("INSERT INTO title_question (title,percentage,order_by,evaluation_table)VALUES('$q_title','$percent','1','$id')");
								$newID_title = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$id' AND title = '$q_title'")->fetch_assoc();
								$t_id = $newID_title['id'];

								$q = "Name of Faculty Evaluated";
								$insert_q2 = $conn->query("INSERT INTO questions (question,q_type,q_order_by,survey_id,header_id)VALUES('$q','drop_down','1','$id','$t_id')");
								
							

							if ($insert_q2) {
								$eval_type = "Self_Evaluation";
								$order_by = 4;

								$sql4 = $conn->query("INSERT INTO evaluation_set (academicyear_start,academicyear_end,semester,title,eval_type,start_date,end_date,order_by,status)VALUES('$academicYearStart','$academicYearEnd','$semester','$title','$eval_type','$start','$end','$order_by','$status')");

								if ($sql4) {
									echo"<div class='alert alert-success d-flex align-items-center' role='alert'>
										  <div>
										  		<i class='fa-solid fa-circle-check'></i> <b>Success!</b> Create Evaluation Successfully.
										  </div>
									</div>";
								}
							}
						}
					}
				}
			}
			
			
			
			
			
			

			
		}
		else{
			echo"<div class='alert alert-warning d-flex align-items-center' role='alert'>
					  <div>
					  		<i class='fa-solid fa-triangle-exclamation'></i> <b>Invalid!</b> You Already Created This Table.
					  </div>
				</div>";

		
		}
	}
	if ($_POST['action'] == "upload_existing_question") {
		$selected_eval = $_POST['select_eval'];
		$eval_id = $_POST['eval_id'];
		$sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$selected_eval' AND percentage <> 0");
		$header_rows = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$selected_eval'")->num_rows;
		$count = 1;
		$counter = 1;
		while($row = $sql->fetch_assoc()){
			$q_head = $row['id']; //171
			$title = $row['title'];
			$percentage = $row['percentage'];
			$description = $row['description'];
			$order_by = $row['order_by'];
			$evaluation_table = $eval_id;
			$insert = $conn->query("INSERT INTO title_question (title,percentage,description,order_by,evaluation_table)VALUES('$title','$percentage','$description','$order_by','$evaluation_table')"); //insert 171
				$sql_header = $conn->query("SELECT max(id) as newID FROM title_question WHERE evaluation_table = '$eval_id' LIMIT 1"); //call 171
				while ($head = $sql_header->fetch_assoc()) {
					$head_id = $head['newID']; // eto 171
					$sql2 = $conn->query("SELECT * FROM questions where survey_id = '$selected_eval' AND header_id = '$q_head'");
					$questions_rows = $conn->query("SELECT * FROM questions where survey_id = '$selected_eval'")->num_rows;
						while($row2 = $sql2->fetch_assoc()){
							$question = $row2['question'];
							$q_type = $row2['q_type'];
							$q_order_by = $row2['q_order_by'];
							$survey_id = $eval_id;
							$header_id = $head_id;
							$insert_q = $conn->query("INSERT INTO questions (question,q_type,q_order_by,survey_id,header_id)VALUES('$question','$q_type','$q_order_by','$survey_id','$header_id')");
						// 171 with question
						}

					// if ($counter >= $header_rows) {
					// 		echo '<div class="alert alert-success alert-dismissible">
		  	// 			<label><strong>Success!. </strong>Uploading questions successfully</label>	
					// 	</div>';
					// }
					// $counter++;

				}
			
			// $count++;
		}
		
	}

	
	
	if ($_POST['action'] == "edit") {
		$id = $_POST['hidden_id'];
		// $academicYearStart = $_POST['academicYearStart'];
		// $academicYearEnd =$_POST['academicYearStart']+1;
		// $semester =$_POST['semester'];
		// $title = "Academic Year ".$academicYearStart."-".$academicYearEnd." ".$semester." Semester";
		// $eval_type = $_POST['eval_type'];
		$start = $_POST['start_date'];
		$end = $_POST['end_date'];
		$desc = $_POST['description'];
		$description = filter_var($desc,FILTER_SANITIZE_STRING);

		//$check = $conn->query("SELECT * FROM evaluation_set WHERE title = '$title' AND eval_type = '$eval_type'")->num_rows;
	
			$update = $conn->query("UPDATE evaluation_set SET start_date = '$start' , end_date = '$end' , description = '$description' WHERE id = '$id'");

			if ($update) {
					echo"<div class='alert alert-success d-flex align-items-center' role='alert'>
						  <div>
						  		<i class='fa-solid fa-circle-check'></i> <b>Success!</b> Update Evaluation Successfully.
						  </div>
					</div>";
			}	
	}

	if ($_POST['action'] == "edit_date_evaluation") {
		$title = $_POST['hidden_id'];
		$start = $_POST['start_date'];
		$end = $_POST['end_date'];

		$update = $conn->query("UPDATE evaluation_set SET start_date = '$start', end_date = '$end' WHERE title = '$title'");

		if ($update) {
			echo"<div class='alert alert-success d-flex align-items-center' role='alert'>
						  <div>
						  		<i class='fa-solid fa-circle-check'></i> <b>Success!</b> Update Evaluation Successfully.
						  </div>
					</div>";
		}
	}




	//inserting evaluation question
	if ($_POST['action'] == "insert_question") {
		$survey_id = $_POST['eval-table_id'];
		$header = $_POST['header'];
		$percentage = $_POST['percentage'];
		$description = $_POST['description'];
		$questions = $_POST['mytext'];
		$q_type = $_POST['q_type'];


		$x = 1;
		$y = 10;

		$check = $conn->query("SELECT MAX(order_by) as largeOrder FROM title_question WHERE evaluation_table = '$survey_id'");
		$row = $check->fetch_assoc();
		

		if (!empty($row['largeOrder'])) {

			$num = $row['largeOrder'];
			$num+=1;
			$insert = $conn->query("INSERT INTO title_question (title,percentage,description,order_by,evaluation_table)VALUES('$header','$percentage','$description','$num','$survey_id')");

			if ($insert) {
				echo '<div class="alert alert-success alert-dismissible">
		  				<label><strong>Success!. </strong>Create question successfully</label>	
						</div>';


				$question_order = 1;
				$index = 0;
				$title_id = $conn->query("SELECT MAX(id) as newID FROM title_question ")->fetch_assoc();
				$newID = $title_id['newID'];
				$data = [];
				foreach ($questions as $key => $value) {
					
					array_push($data,$value);
					//$sql_insert_question = $conn->query("INSERT INTO questions (question,q_order_by,survey_id,header_id)VALUES('$value','$question_order','$survey_id','$newID')");

					//$question_order++;
				}
				foreach ($q_type as $key => $question_type) {
					$questions = $data[$index];
					$sql_insert_question = $conn->query("INSERT INTO questions (question,q_type,q_order_by,survey_id,header_id)VALUES('$questions','$question_type','$question_order','$survey_id','$newID')");
					$question_order++;
					$index++;
				}



			}
		}else{
			$insert = $conn->query("INSERT INTO title_question (title,percentage,description,order_by,evaluation_table)VALUES('$header','$percentage','$description','$x','$survey_id')");
			if ($insert) {
				echo '<div class="alert alert-success alert-dismissible">
		  				<label><strong>Success!. </strong>Create question successfully</label>	
						</div>';



				$question_order = 1;
				$title_id = $conn->query("SELECT MAX(id) as newID FROM title_question ")->fetch_assoc();
				$newID = $title_id['newID'];
				$data = [];
				$index = 0;
				foreach ($questions as $key => $value) {
					array_push($data,$value);
					//$sql_insert_question = $conn->query("INSERT INTO questions (question,q_order_by,survey_id,header_id)VALUES('$value','$question_order','$survey_id','$newID')");

					//$question_order++;
				}
				foreach ($q_type as $key => $question_type) {
					$questions = $data[$index];
					$sql_insert_question = $conn->query("INSERT INTO questions (question,q_type,q_order_by,survey_id,header_id)VALUES('$questions','$question_type','$question_order','$survey_id','$newID')");
					$question_order++;
					$index++;
				}


			}
		}
		
		



	}

	//edit questions
	if ($_POST['action'] == 'update_question') {
		$head_id = $_POST['header_id'];
		$evaluation_id = $_POST['eval_set'];
		$header = $_POST['header'];
		$percentage = $_POST['percentage'];
		$description = $_POST['description'];
		$question = $_POST['question'];
		$qid = $_POST['qid'];
		$newFields = $_POST['newField'];
		$q_type = $_POST['q_type'];
		array_shift($newFields);
		//print_r($newFields);

		$update_title = $conn->query("UPDATE title_question set title = '$header' , percentage = '$percentage', description = '$description' WHERE id = '$head_id'");
		if ($update_title) {

			//q_type
			$q_type_array = [];
			//print_r($q_type);
			foreach ($q_type as $key => $v) {
				array_push($q_type_array,$v);

			}


			//--
		
			$data = [];
			foreach ($question as $key => $value) {
				array_push($data, $value);	
			}
			

			if (!empty($newFields)) {
				//echo$q_type;
				$total_field = count($newFields);
				$index = 0;
				$sql = $conn->query("SELECT max(q_order_by) as newId FROM questions WHERE header_id = '$head_id'")->fetch_assoc();
				$newId = $sql['newId'];
				foreach ($newFields as $key => $value) {
					$q_type2 = $q_type_array[$index];
					print_r($q_type_array);
					$insert = $conn->query("INSERT INTO questions (question,q_type,q_order_by,survey_id,header_id)VALUES('$value','$q_type2','$newId','$evaluation_id','$head_id')");
					$index++;
					if ($index == $total_field) {
						
						?>
							<script type="text/javascript">
							  window.location.href='../eval/view-eval?eval=view_evaluation&id=<?php echo$evaluation_id ?>&success=Update questions successfully';
							</script>
						<?php
					}
				}
			}
			else{
				$total = count($data);
				$index = 0;
				foreach ($qid as $key => $id) {
					$question = $data[$index];
					$q_type = $q_type_array[$index];
					$update_questions = $conn->query("UPDATE questions set question = '$question' , q_type = '$q_type' WHERE id_question = '$id'");
					$index++;
					if ($index == $total) {
						
						?>
							<script type="text/javascript">
							  window.location.href='../eval/view-eval?eval=view_evaluation&id=<?php echo$evaluation_id ?>&success=Update questions successfully';
							</script>
						<?php
					}
			}

			}
			
		}
		
	}

	//insert date_share result
	if ($_POST['action'] == 'insert_share_date') {
		$title = $_POST['eval_title'];
		$start = $_POST['start_date'];
		// $end = $_POST['end_date'];
		$update = $conn->query("UPDATE evaluation_set SET start_share = '$start' WHERE title = '$title'");
		
	}

}
//delete set date
if (isset($_GET['remove-date'])) {
	$title = $_GET['remove-date'];
	$new = "0000-00-00";
	$update = $conn->query("UPDATE evaluation_set SET start_share = '$new' ,visible = 0 WHERE title = '$title'");
	if ($update) {
		header("Location: ../evaluation/?success=Setted Date Deleted");
	}
}



//delete header_questions
if (isset($_GET['qDelete'])) {
	$head_id = $_GET['id'];
	$evaluation_id = $_GET['eval'];
	$delete_title = $conn->query("DELETE FROM title_question WHERE id = '$head_id'");
	if ($delete_title) {
		$delete_question = $conn->query("DELETE FROM questions WHERE header_id = '$head_id'");
		if ($delete_question) {
			header("Location: ../view-eval?eval=view_validation&id=".$evaluation_id."&success=header questions deleted");
		}
	}
	
	
	
}

//delete single question
if (isset($_GET['deleteItem'])) {
	$qid = $_GET['deleteItem'];
	$head_id = $_GET['head_id'];
	$eval_set = $_GET['eval'];
	$delete_q = $conn->query("DELETE FROM questions WHERE id_question = '$qid'");
	if ($delete_q) {
		header("Location: ../edit-questions.php?qid=".$head_id."&eval=".$eval_set."&success=header questions deleted");
	}
}





//active eval
if (isset($_GET["activate"])) {
	$id =$_GET["id"];
	$title = $_GET['title'];
	$status = 'active';
	$update = $conn->query("UPDATE evaluation_set SET status = '$status' WHERE id = '$id'");
	if ($update) {
		header("Location: " . $baseUrl . "hr/eval/evaluation_sets?eval=".$title."&success=Activate Table successfully");
	}

}

if (isset($_GET["disable"])) {
	$id =$_GET["id"];
	$title = $_GET['title'];
	$status = 'disable';
	$update = $conn->query("UPDATE evaluation_set SET status = '$status' WHERE id = '$id'");
	if ($update) {
		header("Location: " . $baseUrl . "hr/eval/evaluation_sets?eval=".$title."&success=Disable Table successfully");
	}

}




//delete survey table
if (isset($_GET["delete"])) {
	$title = $_GET["title"];
	$sql = $conn->query("SELECT * FROM evaluation_set WHERE title = '$title'");
	$prog = 0;
	while ($row = $sql->fetch_assoc()) {
		$id = $row['id'];
		$delete = $conn->query("DELETE FROM evaluation_set WHERE id = '$id'");

		if ($delete) {
			$delete_title = $conn->query("DELETE FROM title_question WHERE evaluation_table = '$id'");
			if ($delete_title) {
				$delete_question = $conn->query("DELETE FROM questions WHERE survey_id = '$id'");
				if ($delete_question) {
					$prog ++;
				}
			}
			
		}

		else{
			echo"error";
		}
	}
	if ($prog == 4) {
		header("Location: " . $baseUrl . "hr/?success=Delete Evaluation successfully");
	}
}






if (isset($_GET["shareit"])) {
	$title =$_GET["id"];
	$sql = $conn->query("SELECT * FROM evaluation_set WHERE title = '$title'");
	while($row = $sql->fetch_assoc()){
		$id = $row['id'];
		$update = $conn->query("UPDATE evaluation_set SET visible = 1 WHERE id = '$id'");
	}
	
	if ($update) {
		header("Location: " . $baseUrl . "hr/eval/evaluation?success=Share Result successfully");
	}

}
if (isset($_GET["disableShareit"])) {
	$title =$_GET["id"];
	$sql = $conn->query("SELECT * FROM evaluation_set WHERE title = '$title'");
	while($row = $sql->fetch_assoc()){
		$id = $row['id'];
		$update = $conn->query("UPDATE evaluation_set SET visible = 0 WHERE id = '$id'");
	}
	
	if ($update) {
		header("Location: " . $baseUrl . "hr/eval/evaluation?success=Share Disable successfully");
	}

}


if (isset($_GET["deleteResult"])) {
	$title =$_GET["id"];
	$sql = $conn->query("SELECT * FROM evaluation_set WHERE title = '$title'");
	while($row = $sql->fetch_assoc()){
		$id = $row['id'];
		$delete = $conn->query("DELETE FROM evaluation_set WHERE id = '$id'");
		$delete2 = $conn->query("DELETE FROM title_question WHERE evaluation_table = '$id'");
		$delete3 = $conn->query("DELETE FROM questions WHERE survey_id = '$id'");
		$delete4 = $conn->query("DELETE FROM response_completed WHERE eval_set = '$id'");
		$delete5 = $conn->query("DELETE FROM responses WHERE eval_set = '$id'");
	}
	

		header("Location: " . $baseUrl . "hr/eval/evaluation?success=Delete table successfully");
	

}

 ?>