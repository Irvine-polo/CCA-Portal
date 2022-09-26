<?php 
$baseUrl = "../../../";
include $baseUrl . "assets/includes/dbh.inc.php";
$id = $_GET['id'];
$output = "";
$sql = $conn->query("SELECT * FROM title_question where evaluation_table = '$id' order by order_by ASC");

while ($info = $sql->fetch_assoc()) {
	$head_id = $info['id'];

	$output .="
	<div style='margin-top:70px;'>
		<div class='card'>
				
				<div class='card-body'>        
					 <div style='float:right;'>
					 ";
					 $res_ex = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$id'")->num_rows;
					if ($res_ex == 0 && $info['percentage'] != 0) {
							 $check = $conn->query("SELECT * FROM evaluation_set WHERE id ='$id'")->fetch_assoc();
							
							 if ($check['status'] != "active") {
							 	$output.="<a class='btn btn-dark' href='edit-questions.php?qid=".$info['id']."&eval=$id'>Edit</a>

							 	<a class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#questionDelete' data-bs-title='".$info['title']."'data-bs-href='api/evaluation.inc.php?qDelete&id=".$info['id']."&eval=$id'><div id=opt>Delete</div></a>
							 	";

							 }
						}
	$output .="	 
						
					</div>		
				<div >";
				if ($info['percentage'] == 0) {
	$output .="		<div>	
						<div><h3 style=' font-size:33px;'>".$info['title']."</h3>
					</div>";

				}
				else{
	$output .="		<div>	
						<div><h3 style=' font-size:33px;'>".$info['title']." (".$info['percentage']."%)</h3>
					</div>";
				}

	$output .="</div>
			
				<hr>
					
				</div>
				<pre style='overflow:hidden; white-space: pre-line; font-family:sans-serif; font-size:14px;'>".$info['description']."</pre>
		</div>
	</div>

";

	$fetch_question = $conn->query("SELECT * FROM questions where header_id = '$head_id' order by q_order_by");
	$low = 'Poor';
	$high = 'Outstanding';
	$num = 1;
	while ($questions = $fetch_question->fetch_assoc()) {
		//$output .=$questions['survey_id'];

		if ($questions['q_type'] == 'radio') {
			$output .= "
		<div class='card card-outline card-success' style='margin-top:-17px;'>
			
			<div class='card-body' >
					<div class='row' >

									<h5><strong> ".$num.".  ".$questions['question']."</strong></h5>

										<div class='col-md-12' >
											<input type='hidden'  name='qid[]'' value=".$questions['id_question'].">	
											<br>
											<div class='d-flex justify-content-between align-items-center d-print-none mb-3'>
												
											
												<label style='visibility: hidden;'><b>".$low."</b></label>
												<label>1</label>
												<label>2</label>
												<label>3</label>
												<label>4</label>
												<label>5</label>
												<label style='visibility: hidden;'><b>".$high."</b></label>

											</div>
											
											<div class='d-flex justify-content-between align-items-center d-print-none mb-3'>

													<label><b>".$low."</b></label>
													<input style='' type='radio' name='".$questions['id_question']." answer' value='1'>
													<input type='radio' name='".$questions['id_question']." answer' value='2'>
													<input type='radio' name='".$questions['id_question']." answer' value='3'>
													<input type='radio' name='".$questions['id_question']." answer' value='4'>
													<input type='radio' name='".$questions['id_question']." answer' value='5'>
													<label><b>".$high."</b></label>
											</div>
										</div>	
								</div>
				
				</div>
			</div>

";
		}
		elseif($questions['q_type'] == 'drop_down'){
			$output .= "
		<div class='card card-outline card-success' style='margin-top:-17px;'>
			
			<div class='card-body' >
					<div class='row' >

									<h5><strong> ".$num.".  ".$questions['question']."</strong></h5>

										<div class='col-md-12' >
											
											<br>
											
											
											<div class='d-flex justify-content-between align-items-center d-print-none mb-3'>

													<select class='form-select form-select-lg' name='' id=''>
														<option value=''>Faculty-list</option>
													</select>
											</div>
										</div>	
								</div>
				
				</div>
			</div>

";
		}
		else{
			$output .= "
		<div class='card card-outline card-success' style='margin-top:-17px;'>
			
			<div class='card-body' >
					<div class='row' >

									<h5><strong> ".$num.".  ".$questions['question']."</strong></h5>

										<div class='col-md-12' >
											<input type='hidden'  name='qid[]'' value=".$questions['id_question'].">	
											<br>
											
											
											<div class='d-flex justify-content-between align-items-center d-print-none mb-3'>

													<input class='form-control form-control-sm' type='text' name='qid[]'>
											</div>
										</div>	
								</div>
				
				</div>
			</div>

";
		}


		
$num++;
	}
}




echo $output;




?>