<?php
$baseUrl = "../../../";
$title = "City College of Angeles - Totalis Humanae";
$page = "classSchedules";
include $baseUrl . "assets/templates/student/header.inc.php";
?> <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script><?php
if ($_SESSION['eval_set'] == null) {
	$redirect = $_SESSION['student_sub'];

	?>
	<script type="text/javascript">
		  window.location.href='<?php echo$redirect ?>';
	</script>
	<?php

}

$eval_set = $_SESSION['eval_set'];
$prof_id = $_SESSION['prof'];

$try = $conn->query("SELECT * FROM users WHERE username = '$prof_id'")->fetch_assoc();
$faculty_name = $try['lastname'].", ".$try['firstname'];
$subject = $_SESSION['subject_code'];	

$student_id = $_SESSION['username'];
$get_role = $conn->query("SELECT username,role FROM users WHERE username = '$student_id'")->fetch_assoc();
$role = $get_role['role'];

$_SESSION['attempt'] = $_SESSION['eval_set'];

$attempt=$_SESSION['attempt'];
if (isset($_SESSION['attempt'])) {
			$_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
			$redirect = $_SESSION['student_sub'];
		}

$sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$eval_set' order by order_by ASC ");
echo "
	<div style='padding:20px;'>
			<h2 class='h3 mb-3'> <b> ".$faculty_name. "</b> - ".$subject."</h2>
	</div>

";
?>

<style type="text/css">
.tab {
  margin-top: 40px;
}


/*.step {
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

<div id='message'></div>

<form id='form_response'>
	<div style='margin-bottom: -55px;'>
			<div class='row'>
				<div class='col-md-8 offset-md-2'>
					<div class='card' >
					
							<img style="max-height: 30%; object-fit: cover; border-radius:8px;" src="<?php echo$baseUrl ?>assets/images/photos/student_eval_bg.png">
						
					</div>
				</div>
			</div>
		</div>
<?php
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

		}

		else{
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
		$num++;
		$f++;
	}


echo "</div>

";
}
?>

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
					<input class='' type='hidden' name='prof_id' id='prof_id' value="<?php echo $prof_id; ?>">
					<input class='' type='hidden' name='student_id' id='student_id' value="<?php echo $student_id; ?>">
					<input class='' type='hidden' name='role' id='role' value="<?php echo $role; ?>">
					<input class='' type='hidden' name='subject_code' id='subject_code' value="<?php echo $_SESSION['subject_code'] ?>">
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
<!-- MAIN JS -->
<script src="<?= $baseUrl; ?>assets/js/main.js"></script>


<!-- <script type="text/javascript">
	var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); 

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById('form_action').click();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
   $('html, body').animate({scrollTop:0}, '300');
}


function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...

    var unanswered = new Array();
    // Loop through available sets
    $('#option').each(function () {
        // Question text
        var question = $(this).prev();
        // Validate
        if (!$(this).find('input').is(':checked')) {
            // Didn't validate ... dispaly alert or do something
            unanswered.push(question.text());
            //question.css('color', 'red'); // Highlight unanswered question
             Swal.fire({
							  icon: 'error',
							  title: 'Oops...',
							  text: 'Please answer all fields in this evaluation form!',
							})
            valid = false;
        }    
    });
    if (unanswered.length > 0) {
        Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text: 'Please answer all fields in this evaluation form!',
			})
        valid = false;
    }
    if (y[i].value == "") {
	     y[i].className += "invalid";
	     Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text: 'Please answer all fields in this evaluation form!',
			})
	     valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}


function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
</script> -->

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
						  text: 'Your response has been recorded',
						  showConfirmButton: false,
						  timer: 1500
						}).then(function() {
						     window.location.href='<?php echo$redirect ?>';
						});

					
				}
			});


		});
	});
	history.forward();
</script>