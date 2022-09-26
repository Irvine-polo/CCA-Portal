<?php 
$baseUrl = "../../../../";
include $baseUrl . "assets/includes/dbh.inc.php";
$output = "";
?>
<?php

if (isset($_GET['faculty'])) {
	$faculty = $_GET['faculty'];
	$eval_set = $_GET['eval_set'];
	$role = $_GET['role'];
	
}



$output .="
<div class='card cca-card'> ";
	$faculty_name = $conn->query("SELECT * FROM users WHERE username = '$faculty'")->fetch_assoc();
	$evaluation_info =$conn->query("SELECT * FROM evaluation_set WHERE id = '$eval_set'")->fetch_assoc();
	$filename = $faculty_name['lastname']." ".$faculty_name['firstname']." ".$evaluation_info['title']." (".$evaluation_info['eval_type'].")";
?>
<div class="text-end mb-3">
	<button  onClick='document.title = "<?php echo$filename?>";window.print()' class='btn btn-success d-print-none'><i class='fa fa-print'></i> Print</button>
</div>

<?php
	
$output.="
	<div class='card-body'>
		
	<div class='text-center'>
				<img class='w-90px' src='../../../assets/images/photos/cca-logo.png'>

				<h4 class='fw-bold mb-1'>CITY COLLEGE OF ANGELES</h4>
				<h5 class='text-uppercase fw-bold mb-3'>HUMAN RESOURCES MANAGEMENT OFFICE</h5>
";
	if ($evaluation_info['eval_type'] == "Peer_Evaluation") {
		$output .= "<h5 class='fw-bold small mb-1'>PEER EVALUATION</h5>";
	}
	if ($evaluation_info['eval_type'] == "Faculty_Performance") {
		$output .= "<h5 class='fw-bold small mb-1'>FACULTY PERFOMANCE EVALUATION</h5>";
		$output .= "<h6 class='small mb-1'>(By Student)</h6>";
	}
	if ($evaluation_info['eval_type'] == "Self_Evaluation") {

		$output .= "<h5 class='fw-bold small mb-1'>SELF-EVALUATION</h5>";
	}
	if ($evaluation_info['eval_type'] == "Faculty_Performance_Head") {
		$output .= "<h5 class='fw-bold small mb-1'>FACULTY PERFOMANCE EVALUATION</h5>";
		$output .= "<h6 class='small mb-1'>(By VPAA, Dean, Program Coordinator)</h6>";
	}

$output.="	
				<h6 class='fw-bold small mb-3'>" . $evaluation_info['semester']." Semester, Academic Year " . $evaluation_info['academicyear_start'] . "-".$evaluation_info['academicyear_end']."</h6>
			</div>

		<div style='padding-bottom:10px;' class='d-flex justify-content-between align-items-center'>
			<p ><b>Faculty name: </b>".$faculty_name['institute']." - ".$faculty_name['lastname'].", ".$faculty_name['firstname']."</p>
				
		</div>
		<div class='table-responsive'>
";




$sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set' AND percentage <> 0 order by order_by ASC");
$num = 1;
$final_average = [];

$sql_ave2 = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set' AND faculty_id = '$faculty' AND role = '$role'")->fetch_assoc();


if ($role == 'self') {
	$sql_ave2 = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set' AND faculty_id = '$faculty'")->fetch_assoc();
}

if ($role == 'coordinator') {
	
	$coor_sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set' AND percentage <> 0  order by order_by ASC");;
	while ($row = $coor_sql->fetch_assoc()) {
		$header =  $row['id'];
		$final_average = [];
		while ($row = $sql->fetch_assoc()) {
			$header =  $row['id'];
			$percentage = $row['percentage'];
			$percentage = $percentage/100;
			$output .="
			<table class='table table-striped table-sm w-100' id='datatable'>
						<thead style='background:lightgray; height: 30px;'>
							<tr>
								<th colspan='2' >".$row['title']." (".$row['percentage']."%)</th>  ";
								$sql_ave = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");

								$array_record2 = [];	
								while ($row_ave = $sql_ave->fetch_assoc()) {
									$id_q = $row_ave['id_question'];
									$role_sql = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set' AND role ='coordinator' AND faculty_id = '$faculty'");
										while ($role_coor2 = $role_sql->fetch_assoc()) {
											$array_record = [];
											$header_c = $role_coor2['id'];
											$sql_res = $conn->query("SELECT * FROM responses WHERE completed_id = '$header_c' AND qid = '$id_q'");
											//$sql_res = $conn->query("SELECT * FROM responses WHERE header_id = '$header' AND qid = '$id_q' AND eval_set = '$eval_set' AND faculty_id = '$faculty'");
												while ($res = $sql_res->fetch_assoc()) {
													$answers = $res['answer'];
													array_push($array_record,$answers);								
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
								array_push($final_average,$Compt_ave);
		$output .= "				<th id='average' class='text-center'>".number_format((float)$Compt_ave, 2, '.', '')."</th>
								</tr>
						</thead";

		$sql2 = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");
			$rating = [];
			while ($row2 = $sql2->fetch_assoc()) {
				//questions
				$id_q = $row2['id_question'];
				$output .="
						<tr>
							<td class='text-center'><b>".$num."</b></td>
							<td>".$row2['question']."</td>
					"	;	
						$x = 1;
						$sqlave = $conn->query("SELECT  * FROM responses WHERE header_id = '$header' AND faculty_id = '$faculty' AND qid = '$id_q'");
						$data = [];
							while ($row_ave = $sqlave->fetch_assoc()) {
								 array_push($data,$row_ave['answer']);
								$answer = $row_ave['answer'];
							}
							$total = array_sum($data);
							$total_num = count($data);
							if ($total == 0 && $total_num == 0) {
								$total = 1;
								$total_num = 1;
							}
							$ave = $total/$total_num;
							array_push($rating,$ave);
				//reponses
					$output .="	 
						<input type='hidden' id='ave'>
							<td class='text-center' width='25%'><b>".number_format((float)$ave, 2, '.', '')."</b></td>
						</tr>
						";		
					$num++;
			}
			//average
		}
		$final_ave = array_sum($final_average);
			if ($final_ave != 0.00) {
		$output .="
					<td colspan='2' style='text-align: right;'><b>TOTAL RATING</b></td>
					<td class='text-center'><b>".number_format((float)$final_ave, 2, '.', '')."</b></td>
					";
					if ($final_ave >=5) {
						$remark = "Outstanding";
					}
					if ($final_ave >=4 && $final_ave <5) {
						$remark = "Very Satisfactory";
					}
					if ($final_ave >=3 && $final_ave <4) {
						$remark = "Satisfactory";
					}
					if ($final_ave >=2 && $final_ave <3) {
						$remark = "Unsatisfactory";
					}
					if ($final_ave >=1 && $final_ave <2) {
						$remark = "Poor";
					}
		$output .="			
					<tr>
						<td colspan='2'></td>
						<td colspan='2' class='text-center'><strong>".$remark."</strong></td>
					</tr>
					</table>
				</div>
			</div>
		</div> ";

		}
	}

}//end of coor

if ($role == 'peer') {
	$peer_sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set' AND percentage <> 0  order by order_by ASC");;
	while ($row = $peer_sql->fetch_assoc()) {
		$header =  $row['id'];
		$final_average = [];
		while ($row = $sql->fetch_assoc()) {
			$header =  $row['id'];
			$percentage = $row['percentage'];
			$percentage = $percentage/100;
			$output .="
			<table class='table table-striped table-sm w-100' id='datatable'>
						<thead style='background:lightgray; height: 30px;'>
							<tr>
								<th colspan='2' >".$row['title']." (".$row['percentage']."%)</th>  ";
								$sql_ave = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");

								$array_record2 = [];	
								while ($row_ave = $sql_ave->fetch_assoc()) {
									$id_q = $row_ave['id_question'];
									$array_record = [];
									$sql_res = $conn->query("SELECT * FROM responses WHERE header_id = '$header' AND qid = '$id_q' AND eval_set = '$eval_set' AND faculty_id = '$faculty'");
									while ($res = $sql_res->fetch_assoc()) {
										$answers = $res['answer'];
										array_push($array_record,$answers);								
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
								array_push($final_average,$Compt_ave);


		$output .= "				<th id='average' class='text-center'>".number_format((float)$Compt_ave, 2, '.', '')."</th>
								</tr>
						</thead";

		$sql2 = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");
			$rating = [];
			while ($row2 = $sql2->fetch_assoc()) {
				//questions
				$id_q = $row2['id_question'];
				$output .="
						<tr>
							<td class='text-center'><b>".$num."</b></td>
							<td>".$row2['question']."</td>
					"	;	
						$x = 1;
						$sqlave = $conn->query("SELECT  * FROM responses WHERE header_id = '$header' AND faculty_id = '$faculty' AND qid = '$id_q'");
						$data = [];
							while ($row_ave = $sqlave->fetch_assoc()) {
								 array_push($data,$row_ave['answer']);
								$answer = $row_ave['answer'];
							}
							$total = array_sum($data);
							$total_num = count($data);
							if ($total == 0 && $total_num == 0) {
								$total = 1;
								$total_num = 1;
							}
							$ave = $total/$total_num;
							array_push($rating,$ave);
				//reponses
					$output .="	 
						<input type='hidden' id='ave'>
							<td class='text-center' width='25%'><b>".number_format((float)$ave, 2, '.', '')."</b></td>
						</tr>
						";		
					$num++;
			}
			//average
		}
		$final_ave = array_sum($final_average);
		$output .="
					<td colspan='2' style='text-align: right;'><b>TOTAL RATING</b></td>
					<td class='text-center'><b>".number_format((float)$final_ave, 2, '.', '')."</b></td>
					";
					if ($final_ave >=5) {
						$remark = "Outstanding";
					}
					if ($final_ave >=4 && $final_ave <5) {
						$remark = "Very Satisfactory";
					}
					if ($final_ave >=3 && $final_ave <4) {
						$remark = "Satisfactory";
					}
					if ($final_ave >=2 && $final_ave <3) {
						$remark = "Unsatisfactory";
					}
					if ($final_ave >=1 && $final_ave <2) {
						$remark = "Poor";
					}
		$output .="			
					<tr>
						<td colspan='2'></td>
						<td colspan='2' class='text-center'><strong>".$remark."</strong></td>
					</tr>
					</table>
				</div>
			</div>
		</div> ";
	}
}//end of peer
//student eval
if ($role == 'student') {
	$peer_sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set' AND percentage <> 0  order by order_by ASC");;
	while ($row = $peer_sql->fetch_assoc()) {
		$header =  $row['id'];
		$final_average = [];
		while ($row = $sql->fetch_assoc()) {
			$header =  $row['id'];
			$percentage = $row['percentage'];
			$percentage = $percentage/100;
			$output .="
			<table class='table table-striped table-sm w-100' id='datatable'>
						<thead style='background:lightgray; height: 30px;'>
							<tr>
								<th colspan='2' >".$row['title']." (".$row['percentage']."%)</th>  ";
								$sql_ave = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");

								$array_record2 = [];	
								while ($row_ave = $sql_ave->fetch_assoc()) {
									$id_q = $row_ave['id_question'];
									$array_record = [];
									$sql_res = $conn->query("SELECT * FROM responses WHERE header_id = '$header' AND qid = '$id_q' AND eval_set = '$eval_set' AND faculty_id = '$faculty'");
									while ($res = $sql_res->fetch_assoc()) {
										$answers = $res['answer'];
										array_push($array_record,$answers);								
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
								array_push($final_average,$Compt_ave);


		$output .= "				<th id='average' class='text-center'>".number_format((float)$Compt_ave, 2, '.', '')."</th>
								</tr>
						</thead";

		$sql2 = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");
			$rating = [];
			while ($row2 = $sql2->fetch_assoc()) {
				//questions
				$id_q = $row2['id_question'];
				$output .="
						<tr>
							<td class='text-center'><b>".$num."</b></td>
							<td>".$row2['question']."</td>
					"	;	
						$x = 1;
						$sqlave = $conn->query("SELECT  * FROM responses WHERE header_id = '$header' AND faculty_id = '$faculty' AND qid = '$id_q'");
						$data = [];
							while ($row_ave = $sqlave->fetch_assoc()) {
								 array_push($data,$row_ave['answer']);
								$answer = $row_ave['answer'];
							}
							$total = array_sum($data);
							$total_num = count($data);
							if ($total == 0 && $total_num == 0) {
								$total = 1;
								$total_num = 1;
							}
							$ave = $total/$total_num;
							array_push($rating,$ave);
				//reponses
					$output .="	 
						<input type='hidden' id='ave'>
							<td class='text-center' width='25%'><b>".number_format((float)$ave, 2, '.', '')."</b></td>
						</tr>
						";		
					$num++;
			}
			//average
		}
		$final_ave = array_sum($final_average);
		if ($final_ave != 0) {

		$output .="
					<td colspan='2' style='text-align: right;'><b>TOTAL RATING</b></td>
					<td class='text-center'><b>".number_format((float)$final_ave, 2, '.', '')."</b></td>
					";
					if ($final_ave >=5) {
						$remark = "Outstanding";
					}
					if ($final_ave >=4 && $final_ave <5) {
						$remark = "Very Satisfactory";
					}
					if ($final_ave >=3 && $final_ave <4) {
						$remark = "Satisfactory";
					}
					if ($final_ave >=2 && $final_ave <3) {
						$remark = "Unsatisfactory";
					}
					if ($final_ave >=1 && $final_ave <2) {
						$remark = "Poor";
					}
		$output .="			
					<tr>
						<td colspan='2'></td>
						<td colspan='2' class='text-center'><strong>".$remark."</strong></td>
					</tr>
					</table>
				</div>
			</div>
		</div> ";
		}
	}
}
//end of student eval







$completed_id = $sql_ave2['id'];
$final_average = [];
while ($row = $sql->fetch_assoc()) {
	$header =  $row['id'];
	$percentage = $row['percentage'];
	$percentage = $percentage/100;
	$output .="
	<table class='table table-striped table-sm w-100' id='datatable'>
				<thead style='background:lightgray; height: 30px;'>
					<tr>
						<th colspan='2' >".$row['title']." (".$row['percentage']."%)</th>  ";
						$sql_ave = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");

						$array_record2 = [];	
						while ($row_ave = $sql_ave->fetch_assoc()) {
							$id_q = $row_ave['id_question'];
							$array_record = [];
							$sql_res = $conn->query("SELECT  * FROM responses WHERE completed_id = '$completed_id' AND faculty_id = '$faculty' AND qid = '$id_q'");
							while ($res = $sql_res->fetch_assoc()) {
								$answers = $res['answer'];
								array_push($array_record,$answers);								
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
						array_push($final_average,$Compt_ave);
$output .= "				<th id='average' class='text-center'>".number_format((float)$Compt_ave, 2, '.', '')."</th>
						</tr>
				</thead";

$sql2 = $conn->query("SELECT * FROM questions WHERE header_id = '$header' AND q_type ='radio' order by(q_order_by)ASC");
	$rating = [];
	while ($row2 = $sql2->fetch_assoc()) {
		//questions
		$id_q = $row2['id_question'];
		$output .="
				<tr>
					<td class='text-center'><b>".$num."</b></td>
					<td>".$row2['question']."</td>
			"	;	
				$x = 1;
				$sqlave = $conn->query("SELECT  * FROM responses WHERE completed_id = '$completed_id' AND faculty_id = '$faculty' AND qid = '$id_q'");
				$data = [];
					while ($row_ave = $sqlave->fetch_assoc()) {
						 array_push($data,$row_ave['answer']);
						$answer = $row_ave['answer'];
					}
		//reponses
			$output .="	 
				<input type='hidden' id='ave'>
					<td class='text-center' width='25%'><b>".number_format((float)$answer, 2, '.', '')."</b></td>
				</tr>
				";		
			$num++;
	}
	//average
}
$final_ave = array_sum($final_average);



if ($role != 'peer' && $role != 'coordinator') {
$output .="
			<td colspan='2' style='text-align: right;'><b>TOTAL RATING</b></td>
			<td class='text-center'><b>".number_format((float)$final_ave, 2, '.', '')."</b></td>
			";
			if ($final_ave >=5) {
				$remark = "Outstanding";
			}
			if ($final_ave >=4 && $final_ave <5) {
				$remark = "Very Satisfactory";
			}
			if ($final_ave >=3 && $final_ave <4) {
				$remark = "Satisfactory";
			}
			if ($final_ave >=2 && $final_ave <3) {
				$remark = "Unsatisfactory";
			}
			if ($final_ave >=1 && $final_ave <2) {
				$remark = "Poor";
			}
$output .="			
			<tr>
				<td colspan='2'></td>
				<td colspan='2' class='text-center'><strong>".$remark."</strong></td>
			</tr>
			</table>
		</div>
	</div>
</div> ";
}














$output .="
<div class='card'>
	<div class='card-body'>
		<div class='table-responsive'>
			<table class='table table-bordered table-border-grey table-striped table-sm w-100 mb-0' id='datatable'>
				<thead style='height: 30px;'> 
			<tr style='background:lightgray;'> 
				<th ></th>
				 ";
				 if ($evaluation_info['eval_type'] == "Faculty_Performance_Head") {
				 	$sql_qset = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set' AND percentage <> 0 order by order_by ASC");
				 }else{
				 	$sql_qset = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set' AND percentage <> 0 order by order_by ASC");
				 }
				
				while ($row_qset = $sql_qset->fetch_assoc()) {
					$colspan = 1;
					$header_id = $row_qset['id'];
					$sql_qset2 = $conn->query("SELECT * FROM questions WHERE header_id = '$header_id' AND q_type ='radio' order by(q_order_by)ASC");
					while ($row_qset2 = $sql_qset2->fetch_assoc()) {
						$colspan++;
					}
					$colspan-=1;
					$header_title = $row_qset['title'];
$output .="			<th style='width: 16rem;' class='text-center' colspan='".$colspan."'>".$header_title."</th>";
				}
$output .="		
				
				<th colspan=3></th>
				";	

$output .="	</tr> ";		

$output .="			<th class='text-center' style='background:lightgray;'>Date Evaluated</th>";
					$counter = 1;
					$total_rows = $num-=1;
					while ($counter<=$total_rows) {
						$output .= "<th class='text-center'>".$counter."</th>";
						$counter++;
					}
$output .="			<th class='text-center' style=' background:lightgray;'>Comments</th>";

					if ($role != 'peer' && $role != 'self') {
						$output .="<th id='eval_head' class='text-center' style=' background:lightgray; '>Evaluated by</th>";
					}
					
					

					if ($evaluation_info['eval_type'] == 'Faculty_Performance_Head') {
						$output .="<th class='text-center' style=' background:lightgray;'>Designation</th>";
						}
				
				
					
						
$output .= "</thead>";	
				if ($role == 'peer' || $role == 'self') {
					
					$sql3 = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set' AND faculty_id = '$faculty' AND role <> 'student'");
				}
				
				else{
					$sql3 = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set' AND faculty_id = '$faculty' AND role = '$role'");

				}			
				
				while ($row3 = $sql3->fetch_assoc()) {
					$completed_id = $row3['id'];
					$username = $row3['username'];
					$sql4 = $conn->query("SELECT * FROM responses WHERE completed_id = '$completed_id' AND answer REGEXP '[0-5]'");
					$num = 1;
$output .="			<tr>";
					$newDate = date("M d Y", strtotime($row3['date_complete']));
$output .="			<td class='text-center'>".$newDate."</td>";
					while ($row4 = $sql4->fetch_assoc()) {
						$res_count = strlen($row4['answer']);
						
$output .=" 			<td class='text-center'>".$row4['answer']."</td>";

						$num++;
					}
					
						$sql_comment = $conn->query("SELECT * FROM responses WHERE completed_id = '$completed_id' AND answer NOT LIKE '1%' AND answer NOT LIKE '2%' AND answer NOT LIKE '3%' AND answer NOT LIKE '4%' AND answer NOT LIKE '5%' ")->fetch_assoc();
						if (!empty($sql_comment)) {
							$output .= "<td class='w-25' ><small style='width: 2rem;'>".$sql_comment['answer']."</small></td>";
						}else{
							$output .= "<td></td>";
						}
					

					if ($role != "peer" && $evaluation_info['eval_type'] != "Faculty_Performance_Head" && $evaluation_info['eval_type'] != "Self_Evaluation") {
						$output .= "<td style='width: 2rem;' class='text-center'><b>".$row3['role']."</b></td>";
					}
					if($evaluation_info['eval_type'] == "Faculty_Performance_Head"){
						$info_evaluator = $conn->query("SELECT * FROM users WHERE username = '$username'")->fetch_assoc();
						$output .= "<td style='width: 2rem;' class='text-center'><b>".$info_evaluator['lastname'].", ".$info_evaluator['firstname']."</b></td>";
						$output .="<td style='width: 2rem;' class='text-center'><b>".$info_evaluator['role']."<b></td>";		
					}
					$output .= "</tr>";
				}

				
				 	
$output .=	"				

			</table>
		</div>
	</div>
</div>

";

echo $output;