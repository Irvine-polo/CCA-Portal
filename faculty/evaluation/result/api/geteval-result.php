<?php 
$baseUrl = "../../../../";
include $baseUrl . "assets/includes/dbh.inc.php";
$output = "";
?>
<?php 
//error_reporting(E_ERROR | E_PARSE);
$institute = strtoupper($_SESSION['institute']);
if (isset($_GET['eval_type'])) {
	$title = $_GET['eval_type'];
	$faculty = $_GET['faculty'];
	$sql = $conn->query("SELECT * FROM evaluation_set WHERE title = '$title'");
	while ($row = $sql->fetch_assoc()) {
		$id_e = $row['id'];
		$res_comp = $conn->query("SELECT DISTINCT faculty_id,eval_set FROM response_completed LEFT JOIN users ON response_completed.faculty_id = users.username WHERE eval_set = '$id_e' AND faculty_id = '$faculty'  order by faculty_id ASC");
		
	}
	
}


$output .= "<div class='card cca-card'> ";
$output.="<div class='card-body'>";
$output .= "<div class='text-center'>
				<img class='w-90px' src='../../../assets/images/photos/cca-logo.png'>

				<h4 class='fw-bold mb-1'>CITY COLLEGE OF ANGELES</h4>
				<h5 class='text-uppercase fw-bold mb-3'>HUMAN RESOURCES MANAGEMENT OFFICE</h5>
				<h5 class='fw-bold small mb-1'>FACULTY PERFORMANCE EVALUATION</h5>
			
";
$output.="	
				<h6 class='fw-bold small mb-3'>" .$title."</h6>
			</div>";

	$output .= "<div class='table-responsive'>
					<table class='table table-bordered table-sm w-100 text-center' id='datatable'>
							<thead style='background:#F3F3F3;'>
								<tr>
									<th rowspan='2' width='15%'>Name</th>
									<th width='15%' colspan='3'>CLASSROOM OBSERVATIONS (40%)</th>
									<th width='15%' rowspan='2'>STUDENT EVALUATION (40%)</th>
									<th rowspan='2'>PEER EVALUATION (15%)</th>
									<th rowspan='2'>SELF-EVALUATION (5%)</th>
									<th rowspan='2'>OVERALL RATING</th>
									<th rowspan='2'>REMARKS</th>
									
								</tr>

								<tr>
									
									<th width='8%'>VPAA</th>
									<th width='8%'>DEAN</th>
									<th width='8%'>COORDINATOR</th>
									
								</tr>
							</thead>
							<tbody>
								";


while ($faculname = $res_comp->fetch_assoc()) {
	$faculty_id = $faculname['faculty_id'];

	$call_name = $conn->query("SELECT * FROM users WHERE username = '$faculty_id'")->fetch_assoc();
	$output .=" <tr>
					<td><strong>".$call_name['lastname'].", ".$call_name['firstname']."</strong></td>";

	$a_vpaa = [];
	$a_dean = [];
	$a_coor = [];
	$evaluatin_sql =$conn->query("SELECT * FROM evaluation_set WHERE title = '$title' order by order_by ASC");
	while($evaluation_row = $evaluatin_sql->fetch_assoc()){
			
		if ($evaluation_row['eval_type'] == "Faculty_Performance_Head") {
			
			$eval_set = $evaluation_row['id'];
			$check = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set'")->num_rows;
			$role = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set'")->fetch_assoc();

//>>>>>>>>>>VPAA<<<<<<<<
			if ($check > 0) {
				$sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set'  order by order_by ASC");
				$num = 1;
				$final_average = [];
				$ave2 = [];
				while ($row = $sql->fetch_assoc()) {
						$header =  $row['id'];
						$percentage = $row['percentage'];
						$percentage = $percentage/100;
						$sql_ave = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");
						$array_record2 = [];
						while ($row_ave = $sql_ave->fetch_assoc()) {
									$id_q = $row_ave['id_question'];
									$role = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set' AND role ='vpaa' AND faculty_id = '$faculty_id'")->fetch_assoc();
									$header_c = $role['id'];
									$sql_ave2 = $conn->query("SELECT * FROM responses  WHERE completed_id = '$header_c' AND qid = '$id_q' AND eval_set = '$eval_set' AND faculty_id = '$faculty_id'");
									$array_record = [];
									while ($row_ave2 = $sql_ave2->fetch_assoc()) {
										 array_push($array_record,$row_ave2['answer']);
									}
							$total = array_sum($array_record);
							$total_num = count($array_record);
							if ($total == 0 && $total_num == 0) {
								$total = 1;
								$total_num = 1;
							}
							$ave = $total/$total_num;
							array_push($array_record2,$ave);
						}
					$ave_percentage = $row['percentage']/100;
					$total2 = array_sum($array_record2);
					$total_num2 = count($array_record2);
					if ($total2 == 0 && $total_num2 == 0) {
						$total2 = 1;
						$total_num2 = 1;
					}
					$average = $total2/$total_num2;
					$Compt_ave = $average*$percentage;
					
					if (!is_nan($Compt_ave)) {
						array_push($final_average,$Compt_ave);
					}
					
					// $output .="	<th id='average' class='text-center'>".number_format((float)$Compt_ave, 2, '.', '')."</th>";
				}
			}
			//array_shift($final_average);

			$final_ave = array_sum($final_average);

			$perform_eval_head = number_format((float)$final_ave, 2, '.', '');

			



//>>>>>>>>>>DEAN<<<<<<<<
			if ($check > 0) {
				$sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set'  order by order_by ASC");
				$num = 1;
				$final_average_dean = [];
				$ave2 = [];
				while ($row = $sql->fetch_assoc()) {
						$header =  $row['id'];
						$percentage = $row['percentage'];
						$percentage = $percentage/100;
						$sql_ave = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");
						$array_record2 = [];
						while ($row_ave = $sql_ave->fetch_assoc()) {
									$id_q = $row_ave['id_question'];
									$role_dean = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set' AND role ='dean' AND faculty_id = '$faculty_id'")->fetch_assoc();
									$header_c = $role_dean['id'];
									$sql_ave2 = $conn->query("SELECT * FROM responses WHERE completed_id = '$header_c' AND qid = '$id_q' AND eval_set = '$eval_set' AND faculty_id = '$faculty_id'");
									$array_record = [];
									while ($row_ave2 = $sql_ave2->fetch_assoc()) {
										 array_push($array_record,$row_ave2['answer']);
									}
							$total = array_sum($array_record);
							$total_num = count($array_record);
							if ($total == 0 && $total_num == 0) {
								$total = 1;
								$total_num = 1;
							}
							$ave = $total/$total_num;
							array_push($array_record2,$ave);
						}
					$ave_percentage = $row['percentage']/100;
					$total2 = array_sum($array_record2);
					$total_num2 = count($array_record2);
					if ($total2 == 0 && $total_num2 == 0) {
						$total2 = 1;
						$total_num2 = 1;
					}
					$average = $total2/$total_num2;
					$Compt_ave = $average*$percentage;
					
					if (!is_nan($Compt_ave)) {
						array_push($final_average_dean,$Compt_ave);
					}
					
					// $output .="	<th id='average' class='text-center'>".number_format((float)$Compt_ave, 2, '.', '')."</th>";
				}
			}
			//array_shift($final_average_dean);
			$final_ave2 = array_sum($final_average_dean);
			$perform_eval_head_dean = number_format((float)$final_ave2, 2, '.', '');


//>>>>>>>>>>COORDINATOR<<<<<<<<
			if ($check > 0) {
				$sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set'  order by order_by ASC");
				$role_coor = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set' AND role ='coordinator' AND faculty_id = '$faculty_id'")->fetch_assoc();
				$num = 1;
				$final_average_coor = [];
				$ave2 = [];
				while ($row = $sql->fetch_assoc()) {
						$header =  $row['id'];
						$percentage = $row['percentage'];
						$percentage = $percentage/100;
						$sql_ave = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");
						$array_record2 = [];
						while ($row_ave = $sql_ave->fetch_assoc()) {
								$id_q = $row_ave['id_question'];
								$role_sql = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set' AND role ='coordinator' AND faculty_id = '$faculty_id'");
								while($role_coor2 = $role_sql->fetch_assoc()){
									$header_c = $role_coor2['id'];
									$sql_ave2 = $conn->query("SELECT * FROM responses WHERE completed_id = '$header_c' AND qid = '$id_q'");
									$array_record = [];
										while ($row_ave2 = $sql_ave2->fetch_assoc()) {
											 array_push($array_record,$row_ave2['answer']);
										}
								
									$total = array_sum($array_record);
									$total_num = count($array_record);
									if ($total == 0 && $total_num == 0) {
										$total = 1;
										$total_num = 1;
									}
									$ave = $total/$total_num;
									array_push($array_record2,$ave);
								}
						}
					$ave_percentage = $row['percentage']/100;
					$total2 = array_sum($array_record2);
					$total_num2 = count($array_record2);
					if ($total2 == 0 && $total_num2 == 0) {
						$total2 = 1;
						$total_num2 = 1;
					}
					$average = $total2/$total_num2;
					$Compt_ave = $average*$percentage;
					if (!is_nan($Compt_ave)) {
						array_push($final_average_coor,$Compt_ave);
					}
					
					
					// $output .="	<th id='average' class='text-center'>".number_format((float)$Compt_ave, 2, '.', '')."</th>";
				}

			}
			//array_shift($final_average_coor);
			$final_ave3 = array_sum($final_average_coor);
			$perform_eval_head_coor = number_format((float)$final_ave3, 2, '.', '');






			
			
			if ($role['role'] == "vpaa") {
				$role = $role['role'];
				$output .="<td colspan=''><a  href='view?view&fid=".$faculty_id."&eval_set=".$eval_set."&role=".$role."'>".$perform_eval_head."</a></td>";
				array_push($a_vpaa,$final_ave);
				
			}else{
				$output .="<td colspan=''></td>";
			}

			if ($role_dean['role'] == "dean") {
				$role = $role_dean['role'];
				$output .="<td colspan=''><a href='view?view&fid=".$faculty_id."&eval_set=".$eval_set."&role=".$role."'>".$perform_eval_head_dean."</a></td>";
				array_push($a_dean,$final_ave2);
				
			}else{
				$output .="<td colspan=''></td>";
			}

			if ($role_coor['role'] == "coordinator") {
				$role = $role_coor['role'];
				$output .="<td colspan=''><a href='view?view&fid=".$faculty_id."&eval_set=".$eval_set."&role=".$role."'>".$perform_eval_head_coor."</a></td>";
				array_push($a_coor,$final_ave3);
				
			}else{
				$output .="<td colspan=''></td>";
			}
			
			


		}


		
	


		if ($evaluation_row['eval_type'] == "Faculty_Performance") {
			$eval_set = $evaluation_row['id'];
			$check = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set'")->num_rows;
			if ($check > 0) {
				$sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set'  order by order_by ASC");
				$num = 1;
				$final_average = [];
				$ave2 = [];
				while ($row = $sql->fetch_assoc()) {
						$header =  $row['id'];
						$percentage = $row['percentage'];
						$percentage = $percentage/100;
						$sql_ave = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");
						$array_record2 = [];
						while ($row_ave = $sql_ave->fetch_assoc()) {
									$id_q = $row_ave['id_question'];
									$sql_ave2 = $conn->query("SELECT * FROM responses WHERE header_id = '$header' AND qid = '$id_q' AND eval_set = '$eval_set' AND faculty_id = '$faculty_id'");
									$array_record = [];
									while ($row_ave2 = $sql_ave2->fetch_assoc()) {
										 array_push($array_record,$row_ave2['answer']);
									}
							$total = array_sum($array_record);
							$total_num = count($array_record);
							if ($total == 0 && $total_num == 0) {
								$total = 1;
								$total_num = 1;
							}
							$ave = $total/$total_num;
							array_push($array_record2,$ave);
						}
					$ave_percentage = $row['percentage']/100;
					$total2 = array_sum($array_record2);
					$total_num2 = count($array_record2);
					if ($total2 == 0 && $total_num2 == 0) {
						$total2 = 1;
						$total_num2 = 1;
					}
					$average = $total2/$total_num2;
					$Compt_ave = $average*$percentage;
					
					if (!is_nan($Compt_ave)) {
						array_push($final_average,$Compt_ave);
					}
					// $output .="	<th id='average' class='text-center'>".number_format((float)$Compt_ave, 2, '.', '')."</th>";
					
					$sql2 = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");
					$rating = [];

					while ($row2 = $sql2->fetch_assoc()) {
					//questions
					$id_q = $row2['id_question'];
					
					$x = 1;
					$sqlave = $conn->query("SELECT * FROM responses WHERE header_id = '$header' AND qid = '$id_q' AND eval_set = '$eval_set' AND faculty_id = '$faculty_id'");
					$data = [];
						while ($row_ave = $sqlave->fetch_assoc()) {
							 array_push($data,$row_ave['answer']);
							
						}
						$total = array_sum($data);
						$total_num = count($data);
						$ave = $total/$total_num;
						array_push($rating,$ave);
							
					
					}
				}
			}
			//array_shift($final_average);
			$final_ave = array_sum($final_average);
			$perform_eval_stud = number_format((float)$final_ave, 2, '.', '');
			$role = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set'")->fetch_assoc();
			if ($perform_eval_stud != "nan") {
				$role = $role['role'];
				$output .="<td colspan=''><a href='view?stud_view&fid=".$faculty_id."&eval_set=".$eval_set."&role=".$role."'>".$perform_eval_stud."</a></td>";
			}
			else{
				$output .="<td></td>";
			}
			
			




		}

		if ($evaluation_row['eval_type'] == "Peer_Evaluation") {
			$eval_set = $evaluation_row['id'];
			$check = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set'")->num_rows;
			$role = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set'")->fetch_assoc();
			if ($check > 0) {
				$sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set'  order by order_by ASC");
				$num = 1;
				$final_average = [];
				$ave2 = [];
				while ($row = $sql->fetch_assoc()) {
						$header =  $row['id'];
						$percentage = $row['percentage'];
						$percentage = $percentage/100;
						$sql_ave = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");
						$array_record2 = [];
						while ($row_ave = $sql_ave->fetch_assoc()) {
									$id_q = $row_ave['id_question'];
									$sql_ave2 = $conn->query("SELECT * FROM responses WHERE header_id = '$header' AND qid = '$id_q' AND eval_set = '$eval_set' AND faculty_id = '$faculty_id'");
									$array_record = [];
									while ($row_ave2 = $sql_ave2->fetch_assoc()) {
										 array_push($array_record,$row_ave2['answer']);
									}
							$total = array_sum($array_record);
							$total_num = count($array_record);
							if ($total == 0 && $total_num == 0) {
								$total = 1;
								$total_num = 1;
							}
							$ave = $total/$total_num;
							array_push($array_record2,$ave);
						}
					$ave_percentage = $row['percentage']/100;
					$total2 = array_sum($array_record2);
					$total_num2 = count($array_record2);
					if ($total2 == 0 && $total_num2 == 0) {
						$total2 = 1;
						$total_num2 = 1;
					}
					$average = $total2/$total_num2;
					$Compt_ave = $average*$percentage;
					
					if (!is_nan($Compt_ave)) {
						array_push($final_average,$Compt_ave);
					}
					// $output .="	<th id='average' class='text-center'>".number_format((float)$Compt_ave, 2, '.', '')."</th>";
					
					$sql2 = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");
					$rating = [];

					while ($row2 = $sql2->fetch_assoc()) {
					//questions
					$id_q = $row2['id_question'];
					
					$x = 1;
					$sqlave = $conn->query("SELECT * FROM responses WHERE header_id = '$header' AND qid = '$id_q' AND eval_set = '$eval_set' AND faculty_id = '$faculty_id'");
					$data = [];
						while ($row_ave = $sqlave->fetch_assoc()) {
							 array_push($data,$row_ave['answer']);
							
						}
						$total = array_sum($data);
						$total_num = count($data);
						$ave = $total/$total_num;
						array_push($rating,$ave);
							
					
					}
				}
			}
			//array_shift($final_average);
			$final_ave = array_sum($final_average);
			
			$peer_eval = number_format((float)$final_ave, 2, '.', '');
			
			if ($peer_eval != "nan") {
				$role = 'peer';
				$output .="<td colspan=''><a href='view?peer&fid=".$faculty_id."&eval_set=".$eval_set."&role=".$role."'>".$peer_eval."</a></td>";
			}
			else{
				$output .="<td></td>";
			}

		}



		if ($evaluation_row['eval_type'] == "Self_Evaluation") {
			$eval_set = $evaluation_row['id'];
			$check = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set'")->num_rows;
			$role = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set'")->fetch_assoc();
			if ($check > 0) {
				$sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set'  order by order_by ASC");
				$num = 1;
				$final_average = [];
				$ave2 = [];
				while ($row = $sql->fetch_assoc()) {
						$header =  $row['id'];
						$percentage = $row['percentage'];
						$percentage = $percentage/100;
						$sql_ave = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");
						$array_record2 = [];
						while ($row_ave = $sql_ave->fetch_assoc()) {
									$id_q = $row_ave['id_question'];
									$sql_ave2 = $conn->query("SELECT * FROM responses WHERE header_id = '$header' AND qid = '$id_q' AND eval_set = '$eval_set' AND faculty_id = '$faculty_id'");
									$array_record = [];
									while ($row_ave2 = $sql_ave2->fetch_assoc()) {
										 array_push($array_record,$row_ave2['answer']);
									}
							$total = array_sum($array_record);
							$total_num = count($array_record);
							if ($total == 0 && $total_num == 0) {
								$total = 1;
								$total_num = 1;
							}
							$ave = $total/$total_num;
							array_push($array_record2,$ave);
						}
					$ave_percentage = $row['percentage']/100;
					$total2 = array_sum($array_record2);
					$total_num2 = count($array_record2);
					if ($total2 == 0 && $total_num2 == 0) {
						$total2 = 1;
						$total_num2 = 1;
					}
					$average = $total2/$total_num2;
					$Compt_ave = $average*$percentage;
					
					if (!is_nan($Compt_ave)) {
						array_push($final_average,$Compt_ave);
					}
					// $output .="	<th id='average' class='text-center'>".number_format((float)$Compt_ave, 2, '.', '')."</th>";
					
					$sql2 = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");
					$rating = [];

					while ($row2 = $sql2->fetch_assoc()) {
					//questions
					$id_q = $row2['id_question'];
					
					$x = 1;
					$sqlave = $conn->query("SELECT * FROM responses WHERE header_id = '$header' AND qid = '$id_q' AND eval_set = '$eval_set' AND faculty_id = '$faculty_id'");
					$data = [];
						while ($row_ave = $sqlave->fetch_assoc()) {
							 array_push($data,$row_ave['answer']);
							
						}
						$total = array_sum($data);
						$total_num = count($data);
						$ave = $total/$total_num;
						array_push($rating,$ave);
							
					
					}
				}
			}
			//array_shift($final_average);
			$final_ave = array_sum($final_average);
			$self_eval = number_format((float)$final_ave, 2, '.', '');
			
			if ($self_eval != "nan") {
				$role = 'self';
				$output .="<td colspan=''><a href='view?self&fid=".$faculty_id."&eval_set=".$eval_set."&role=".$role."'>".$self_eval."</a></td>";
			}
			else{
				$output .="<td></td>";
			}
		}

	}
	//percentage
	$p_head = 0.40;
	$p_student = 0.40;
	$peer = 0.15;
	$self = 0.05;
	
	// print_r($a_vpaa);
	// print_r($a_dean);
	// print_r($a_coor);

	foreach ($a_vpaa as $key => $v_vpaa) {
		foreach ($a_dean as $key => $v_dean) {
			foreach ($a_coor as $key => $v_coor) {
				$total = $v_vpaa+$v_dean+$v_coor;

			}
		}
	}
	$head_score = $total/3;

	// $div = 5;
	// $perform_eval_stud = 5;
	// $peer_eval = 5;
	// $self_eval = 5;

	
	$ph = $head_score*$p_head;
	$ps = $perform_eval_stud*$p_student;
	$pp = $peer_eval*$peer;
	$se = $self_eval*$self;
	$total = $ph+$ps+$pp+$se;
	$overall = number_format((float)$total, 2, '.', '');
	
	if ($overall != "nan") {
		$output .="<td><strong>".$overall."</strong></td>";
	}
	else{
		$output .="<td></td>";
	}
	

	if ($total > 4) {
		$output .="<td><strong>Outstanding</strong></td>";
	}
	if ($total > 3 && $total <= 4) {
		$output .="<td><strong>Very Satisfactory</strong></td>";
	}
	if ($total > 2 && $total <= 3) {
		$output .="<td><strong>Satisfactory</strong></td>";
	}
	if ($total > 1 && $total <= 2) {
		$output .="<td><strong>Unsatisfactory</strong></td>";
	}
	if ($total > 0 && $total <= 1) {
		$output .="<td><strong>Poor</strong></td>";
	}
	if($total < 1){
		$output .="<td></td>";	
	}

}


$output .= "
				</tbody>
			</tr>

					</table>
				</div>
				<br>

				
";

				

				if (isset($_GET['faculty'])) {
					$faculty = $_GET['faculty'];
					if ($_GET['faculty'] != 'All') {
					 	$institute = $conn->query("SELECT * FROM users WHERE username = '$faculty'")->fetch_assoc();
						$faculty_name = $conn->query("SELECT * FROM users WHERE username = '$faculty'")->fetch_assoc();
					if ($institute['institute'] == 'ICSLIS') {
						$dean_sql = $conn->query("SELECT * FROM users WHERE role = 'dean' AND institute = 'ICSLIS'")->fetch_assoc();
						$dean = $dean_sql['firstname']." ".$dean_sql['lastname'];

					}
					if ($institute['institute'] == 'IBM') {
						$dean_sql = $conn->query("SELECT * FROM users WHERE role = 'dean' AND institute = 'IBM'")->fetch_assoc();
						$dean = $dean_sql['firstname']." ".$dean_sql['lastname'];
						

					}
					if ($institute['institute'] == 'IEAS') {
						$dean_sql = $conn->query("SELECT * FROM users WHERE role = 'dean' AND institute = 'IEAS'")->fetch_assoc();
						$dean = $dean_sql['firstname']." ".$dean_sql['lastname'];

					}
				
$output .= "				
				<div class='row text-center mb-2'>
							<div class='col-6'>
								<div>
									<p>Discussed by:</p>
									<strong>".$dean."</strong>
									<p>Dean, ".$institute['institute']."</p>
								</div>
							</div>

							<div class='col-6'>
								<div>
									<p>Conforme</p>
									<strong>".$faculty_name['lastname'].", ".$faculty_name['firstname']."</strong>
									<p>Faculty</p>
								</div>
								 
							</div>
				</div>	

";
					}
				}
$output .= "

			</div>

		</div> ";
echo $output;
 ?>