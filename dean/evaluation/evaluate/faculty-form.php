<?php
$baseUrl = "../../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluation-tab";

include $baseUrl . "assets/templates/dean/header.inc.php";
$_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];


?>

<?php 
if (!isset($_SESSION['attempt'])) {
	?>
		<script type="text/javascript">
			     window.location.href='../../';
		</script>
	<?php
}


 ?>

<?php
$referenceNumber = $_SESSION["username"];
$user_info = $conn->query("SELECT * FROM users WHERE username = '$referenceNumber'")->fetch_assoc();
$institute = $user_info['institute'];
$faculty_role =  $user_info['role'];
$eval_set = $_SESSION['eval_set'];
//change role for faculty head
$designation =$conn->query("SELECT username,role FROM users WHERE username = '$referenceNumber'")->fetch_assoc();
if (!empty($designation)) {
	$faculty_role = $designation['role'];
}


?>


<style type="text/css">
.tab {
  margin-top: 40px;
}


/*
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}


.step.finish {
  background-color: #04AA6D;
}
*/
input[type='radio'] {
    transform: scale(1.8);
    accent-color: green;
}
</style>
<?php 
$sql_title = $conn->query("SELECT * FROM evaluation_set WHERE id = '$eval_set'")->fetch_assoc();
 ?>
<form id='form_response'>
	<div style='margin-bottom:-55px;'>
		<div class='row'>
			<div style="padding: 10px;">
						<h3><?php echo$sql_title['title']." - ".$sql_title['eval_type'] ?></h3>
				</div>
				<hr style="height:6px; background: darkgreen; margin-bottom: 30px;">
			<div class='col-md-8 offset-md-2'>
				
				<div class='card' >
					<?php 
					if ($institute == 'IBM') {
						echo "<img style='max-height: 30%; object-fit: cover; border-radius:8px;' src='".$baseUrl."assets/images/photos/ibm header.png'>";
					}
					if ($institute == 'ICSLIS') {
						echo "<img style='max-height: 30%; object-fit: cover; border-radius:8px;' src='".$baseUrl."assets/images/photos/icslis header.png'>";
					}
					if ($institute == 'IEAS') {
						echo "<img style='max-height: 30%; object-fit: cover; border-radius:8px;' src='".$baseUrl."assets/images/photos/ieas header.png'>";
					}
					 ?>	
				</div>
			</div>
		</div>
	</div>



	<?php 
		$eval_info = $conn ->query("SELECT * FROM evaluation_set WHERE id = '$eval_set'")->fetch_assoc();
		if ($eval_info['eval_type'] == "Peer_Evaluation") {
			$eval_id = $eval_info['id'];
		
		//Checking Faculty names if already evaluated
		$check_completed = $conn->query("SELECT faculty_id FROM response_completed WHERE eval_set = '$eval_id'");
		$a_completed = [];
		while ($rows = $check_completed->fetch_assoc()) {
				array_push($a_completed,$rows['faculty_id']);

		}
		
		$vals = array_count_values($a_completed);
		$array_c_exclude = [];
		foreach ($vals as $key => $value) {
			if ($value == 2) {
					array_push($array_c_exclude,$key);

			}
		}
		
	}

	$exists = $conn->query("SELECT * FROM response_completed WHERE eval_set = '$eval_set' AND username = '$referenceNumber'");
		$array_ex = [];
		while($row = $exists->fetch_assoc()){
			array_push($array_ex,$row['faculty_id']);
		}
		if (isset($_SESSION['vpaa'])) {
			$sql =$conn->query("SELECT * FROM users WHERE role = 'faculty' AND username <> '$referenceNumber'");
		}else{
				$sql =$conn->query("SELECT * FROM users WHERE institute = '$institute' AND username <> '$referenceNumber' ");
		}
	
		$array_faculty = [];
		while ($facul = $sql->fetch_assoc()) {
			array_push($array_faculty,$facul['username']);
		}
		foreach ($array_ex as $key => $value) {
			$k = $value;
			if (in_array($k,$array_faculty)) {
				$i = array_search($k,$array_faculty);
				unset($array_faculty[$i]);
			}
		}

		if ($eval_info['eval_type'] == "Peer_Evaluation") {

				foreach ($array_c_exclude as $key => $val) {
					$k = $val;
					if (in_array($k,$array_faculty)) {
						$i = array_search($k,$array_faculty);
						unset($array_faculty[$i]);
					}
				}
		
			}
		
	
	 ?>


	<?php

	$sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set'  order by order_by ASC");

	while ($row = $sql->fetch_assoc()) {
		?>
		<div class="tab">
			
				<div class='row'>
					<div class='col-md-8 offset-md-2'>
						<div class='card'>
							<div class='card-body'>
								<h3 style=' font-size:33px;'><?php echo $row['title']; ?></h3>
								<hr>
								<pre style='overflow:hidden; white-space: pre-line; font-family:sans-serif; font-size:14px;'><?php echo $row['description']; ?></pre>
								</div>
						</div>
					</div>
				</div>
			



		<?php 
		$head_id = $row['id'];
		$sql2 = $conn->query("SELECT * FROM questions WHERE header_id = '$head_id' order by q_order_by");
		$num = 1;
		$low = 'Poor';
		$high = 'Outstanding';
		$f = 1;

		while ($questions = $sql2->fetch_assoc()) {
		$qid = $questions['id_question'];
		$x = 0;
		$val = 1;

				if ($questions['q_type'] == 'radio') {
					
				?>
					<div class='row'>
						<div class='col-md-8 offset-md-2'>
							<div class='card card-outline card-success' style='margin-top:-17px;'>
								<div class='card-body' >
									<h5><strong> <?php echo "$num. "; ?> <?php echo $questions['question']; ?> </strong></h5>
									<input type='hidden' name='qid[]' value='<?php echo$questions['id_question'] ?>'>

										<div class='col-md-12' >
										
											<br>
											<div class='d-flex justify-content-between align-items-center d-print-none mb-3'>
												
											
												<label style='visibility: hidden;'><?php echo $low; ?></label>
												<label>1</label>
												<label>2</label>
												<label>3</label>
												<label>4</label>
												<label>5</label>
												<label style='visibility: hidden;'><?php echo $high; ?></label>

											</div>
											
											<div id="option" class='d-flex justify-content-between align-items-center d-print-none mb-3'>

													<label><b><?php echo $low; ?></b></label>
														<?php 
														while ($x < 5) {
															?>
															<input type='hidden' name='header[<?php echo$questions['id_question'] ?>]' value='<?php echo$questions['header_id'] ?>'>
															<input required type='radio' name='answers[<?php echo$questions['id_question'] ?>]' value='<?php echo$val ?>'>
															<?php
															$x++;
															$val++;
														}
														 ?>

													<label><b><?php echo $high; ?></b></label>
											</div>
										</div>	
								</div>
							</div>
						</div>
					</div>
					
				
					
	<?php

				}elseif($questions['q_type'] == 'text_box'){
	?>
						<div class='row'>
							<div class='col-md-8 offset-md-2'>
								<div class='card card-outline card-success' style='margin-top:-17px;'>		
									<div class='card-body' >
										<div class='row' >
											<h5><strong> <?php echo "$num. "; ?> <?php echo $questions['question']; ?></strong></h5>
											<input type='hidden' name='qid[]' value='<?php echo$questions['id_question'] ?>'>
												<div class='col-md-12' >
													<br>	
													<div class='d-flex justify-content-between align-items-center d-print-none mb-3'>
														<input type='hidden' name='header[<?php echo$questions['id_question'] ?>]' value='<?php echo$questions['header_id'] ?>'>
														<input onkeypress="return /[a-zA-Z'-'\s]/i.test(event.key)" name='answers[<?php echo$questions['id_question'] ?>]' required class='form-control form-control-sm' type='text' >
													</div>
												</div>	
										</div>
									</div>
								</div>
							</div>
						</div>	
			

	<?php	
				}
				elseif($questions['q_type'] == 'drop_down'){


																
					?>
					<div class="row">
						<div class='col-md-8 offset-md-2'>
							<div class='card card-outline card-success' style='margin-top:-17px;'>
								<div class='card-body' >
									<div class='row' >
										<h5><strong><?php echo$num .". ".$questions['question'] ?></strong></h5>
											<div class='col-md-12' >
												<br>
												<div class='d-flex justify-content-between align-items-center d-print-none mb-3'>
														<select class='form-select form-select-lg' name='prof_id' id='prof_id' required>
															<option value="" selected hidden>Faculty-name</option>
															<?php 
															foreach ($array_faculty as $key => $value) {
																$username = $value;
																$facul = $conn->query("SELECT * FROM users WHERE username = '$username'")->fetch_assoc();
																
																
																
																echo "<option value='".$facul['username']."'><b>".$facul['institute']."</b>  - ".$facul['status']." - ".$facul['lastname']." ".$facul['firstname']."</option>";
														}
															 ?>
														</select>
												</div>
											</div>	
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
				}
	$num++;
	$f++;

		}
echo "</div>


";

	} ?>
<div class='row'>
	<div class='col-md-8 offset-md-2'>
		<div class='card'>
			<div class='card-body'>
				<div class='text-center'>	

					<div>
						<?php 
						$sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set'")->num_rows;
						$x = 1;
						while ($sql>=$x) {
							echo '<span class="step"></span>';
							$x++;
						}
						 ?>
					</div>


					<input class='' type='hidden' name='eval_set' id='eval_set' value="<?php echo $eval_set; ?>">
					<input class='' type='hidden' name='faculty_evaluator' id='faculty_evaluator' value="<?php echo $referenceNumber; ?>">
					<input class='' type='hidden' name='role' id='role' value="<?php echo $faculty_role; ?>">
					<input type="hidden" name="action" id="action" value="insert_answer" />
					<!-- <div style="overflow:auto;">
					    <div style="float:right;">
					      <button class="btn btn-light" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
					      <button class="btn btn-success" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
					    </div>
					  </div> -->

					
					<input  class='btn btn-success' type='submit' name='form_action' id='form_action'>
				</div>
			</div>
		</div>
	</div>
</div>
</form>	


<!-- ADMIN KIT JS -->
	<script src="<?= $baseUrl; ?>assets/js/app.js"></script>
	<!-- JQUERY JS -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<!-- DATATABLES JS -->
	<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
	<!-- DATATABLES BOOTSTRAP JS -->
	<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
	<!-- JQUERY FORM -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
	<!-- FANCYAPPS JS -->
	<!-- <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script> -->
	<!-- MAIN JS -->
	<script src="<?= $baseUrl; ?>assets/js/main.js"></script>

	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script type="text/javascript">
	$(document).ready(function(){
		$('#form_response').on('submit', function(event){
			event.preventDefault();
			$('#form_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"api/insert-response.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#form_action').attr('disabled', false);
					Swal.fire({
						  position: 'center',
						  icon: 'success',
						  title: 'Success!',
						  text: 'Your response will be recorded',
						  showConfirmButton: false,
						  timer: 1500
						}).then(function() {
						     window.location.href='./../../evaluation-tab';
						});

					
				}
			});


		});
	});
</script>