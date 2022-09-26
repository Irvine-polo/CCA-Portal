<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluation";

include $baseUrl . "assets/templates/hr/header.inc.php";
	
if (isset($_GET['qid'])) {
	$head_id = $_GET['qid'];
	$eval_set = $_GET['eval'];
}
$eval = $_SESSION['eval'];
$eval_type = $conn->query("SELECT * FROM evaluation_set WHERE id = '$eval_set'")->fetch_assoc();
$info = $conn->query("SELECT * FROM title_question WHERE id = '$head_id'")->fetch_assoc();

?>
<style>
	#f-size input , label{
		 font-size: 20px;
	}
</style>

<div id="message"></div>

<div class="col-lg-12">
	<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
			<h1 class="h3 mb-3">Edit Questions</h1>
			<a class="btn btn-primary" href="view-eval?eval=view_evaluation&id=<?php echo$eval ?>">Back</a>
	</div>
	<div class="row">
		<div class="col-md-4">
					<div class="card card-outline card-primary">
						<div class="card-header">
							<h3 class="card-title">Evaluation Survey Details</h3>
						</div>
						<div class="card-body p-0 py-2">
							<div class="container-fluid">
								<p>Title: <b><?php echo $eval_type['title'] ?></b></p>
								<p>Survey for: <b><?php echo $eval_type['eval_type'] ?></b></p>
								<p class="mb-0">Description:</p>
								<small><?php echo $eval_type['description']; ?></small>
								<br><br>
								<p>Start: <b><?php echo date("M d, Y",strtotime($eval_type['start_date'])) ?></b></p>
								<p>End: <b><?php echo date("M d, Y",strtotime($eval_type['end_date'])) ?></b></p>
								<?php 
								$res_num = $conn->query("SELECT id FROM response_completed WHERE eval_set = '$eval'")->num_rows;
								 ?>
								<p>Responses: <b><?php echo$res_num ?></b></p>
								

							</div>
							<hr class="border-primary">
						</div>
					</div>


					<?php 
					$check = $conn->query("SELECT * FROM evaluation_set WHERE id ='$eval'")->fetch_assoc();
					if ($check['status'] != 'active') {
						?>	
						<div class="card card-outline card-primary">
						<div class="card-header">
							
							<h3 class="card-title">Question order by</h3>
						</div>
						<div class="card-body p-0 py-2">
							<div class="container-fluid">
								<form action="" id="manage-sort">
									<div class="card-body ui-sortable">
										
										<div id="section_sortable"></div>
										<?php 
										$sql = $conn->query("SELECT * FROM questions WHERE survey_id = '$eval' AND header_id = '$head_id' order by q_order_by");
													//echo "<div class='card-body ui-sortable'>";
												while ($row = $sql->fetch_assoc()) {
												
															echo "<div class='callout callout-info'>";
																	echo "<ul class='list-group'>";
																				echo "<li style='cursor: -webkit-grab; cursor: grab;' class='list-group-item '>
																				<span style='margin-right:20px;' class='handle fa fa-bars'></span>
																				".$row['q_order_by'].". ".$row['question']."</li>";
																	echo "</ul>";
																	echo "<br>";
																	echo "<input type='hidden' name='qid[]' value='".$row['id_question']."'>	";
															echo "</div>";
													
												}
										 ?>
										
									
									</div>
								</form>
								
								

							</div>
							<hr class="border-primary">
						</div>
					</div>
						<?php
					} ?>
					

			</div>
	


	<div class="col-md-8" style="">
		<div class="card">
			<div class="card-body">
				<form id="editQuestion">
					<div class="form-group" id="f-size">
							<label  class="control-label"><b>Header: </b></label>
							<input required  class="form-control form-control-sm" type="text" name="header" value="<?php echo$info['title'] ?>">
							<label class="control-label"><b>Percentage:</b></label>

							<div class="d-flex">
									<input style="width:70px;" value="<?php echo$info['percentage'] ?>" required class="form-control form-control-sm" type="number" name="percentage" id="percentage" min="0" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;"><b style="font-size:18px;">%</b>
							</div>
							<label required class="control-label"><b>Description: </b></label>
							<textarea name="description" id="description" cols="30" rows="10" class="form-control" ><?php echo $info['description']; ?></textarea>
							<br>
							<input type="hidden" name="newField[]" value="empty">
							<div class="fields"></div>
								<div class="col-lg-12 text-right justify-content-center d-flex">
									<?php if ($eval_type['eval_type'] != "Faculty_Performance" && $eval_type['eval_type'] != "Self_Evaluation"){ ?>
										<button type="button" class="btn btn-primary add_form_field" id="add_question">+</button>
									<?php }else{ ?>
										<button type="button" class="btn btn-primary add_form_field2" id="add_question">+</button>
									<?php } ?>
								</div>
					</div>
				
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				

				<?php
					$sql = $conn->query("SELECT * FROM questions WHERE header_id = '$head_id' order by (q_order_by) ASC");
					$count = $conn->query("SELECT * FROM questions WHERE header_id = '$head_id'");
					$num = 1;
					while ($row = $sql->fetch_assoc()) {
						?>
							<div class='form-group'>
						
											
								<label class='control-label'><b><?php echo$num ?>. Question</b>
									<?php 
									if ($count->num_rows > 1) {
										?>
										 <button type="button" class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#questionDelete_single' data-bs-question='<?php echo$row['question'] ?>' data-bs-href='api/evaluation.inc.php?deleteItem=<?php echo$row['id_question'] ?>&head_id=<?php echo$head_id ?>&eval=<?php echo$eval_set ?>'>Delete</button>
										<?php
									}
									 ?>
								</label><br>
							<input type="hidden" name="qid[]" value="<?php echo$row['id_question'] ?>">
							<!-- <input required style='font-size:18px;' class='form-control form-control-sm' type='text' name='question[]' value='<?php //echo$row['question'] ?>'> -->
							<textarea name='question[]'  cols="30" rows="3" class="form-control" required><?php echo$row['question'] ?></textarea>
							<select name="q_type[]" id="q_type[]" required>
								<option hidden selected value="<?php echo $row['q_type']; ?>" ><?php echo $row['q_type']; ?></option>
								<option value="radio">Radio button</option>
								<option value="text_box">Text</option>
								
								
							</select>

						

					<br><br>
						<?php		
						$num++;	
					}

				 ?>
				 
				</div>		
			</div>
		</div>
	</div>
</div>
			

					<br>
				 <div class="col-lg-12 text-right justify-content-center d-flex">

					 <input type="hidden" name="header_id" id="header_id" value="<?php echo$head_id ?>">
					 <input type="hidden" name="eval_set" id="eval_set" value="<?php echo$eval_set ?>">
					 <input type="hidden" name="action" id="action" value="update_question">
					 <input type="submit" name="form_action" id="form_action" value="Update" class="btn btn-warning">
				</div>
				 </form>
			</div>
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/hr/footer.inc.php";

?>
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

<!--  DELETE QUESTION  -->
<div class="modal fade" id="questionDelete_single" tabindex="-1" aria-labelledby="deleteModalLabel_single" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteModalLabel_single">Delete Questions</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete question <strong class="question"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-danger href">Delete</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	let questionDelete = document.getElementById("questionDelete_single");

	questionDelete_single.addEventListener("show.bs.modal", function (event) {
		let button = event.relatedTarget;

		let question = button.getAttribute("data-bs-question");
		let modalBodyName = questionDelete_single.querySelector(".modal-body .question");
		modalBodyName.innerHTML = question;

		let href = button.getAttribute("data-bs-href");
		let modalFooterHref = questionDelete_single.querySelector(".modal-footer .href");
		modalFooterHref.href = href;
	});
</script>



<script type="text/javascript">
$(document).ready(function(){


		var max_fields = 10;
	    var wrapper = $(".fields");
	    var add_button = $(".add_form_field");
	    var number_q = 2;

	    var x = 1;
	    $(add_button).click(function(e) {
	        e.preventDefault();
	        if (x < max_fields) {
	            x++;
	        
	            $(wrapper).append('<div><br><br><label class="control-label"><b>Question</b></label><button style="float:right;" class="btn btn-danger delete">Delete</button><input id="newField[]" required class="form-control form-control-sm" type="text" name="newField[]"/><select name="q_type[]" id="q_type[]" required><option disabled selected value="" >Select Question type</option><option value="radio">Radio button</option><option value="text_box">Text</option></select><br></div>'); //add input box
	        } else {
	            alert('You Reached the limits')
	        }
	    });

	    $(wrapper).on("click", ".delete", function(e) {
	        e.preventDefault();
	        $(this).parent('div').remove();
	        x--;
	    });

	    var max_fields = 10;
	    var wrapper = $(".fields");
	    var add_button = $(".add_form_field2");
	    var number_q = 2;

	    var x = 1;
	    $(add_button).click(function(e) {
	        e.preventDefault();
	        if (x < max_fields) {
	            x++;
	        
	            $(wrapper).append('<div><br><br><label class="control-label"><b>Question</b></label><button style="float:right;" class="btn btn-danger delete">Delete</button><input id="newField[]" required class="form-control form-control-sm" type="text" name="newField[]"/><select name="q_type[]" id="q_type[]" required><option disabled selected value="" >Select Question type</option><option value="radio">Radio button</option><option value="text_box">Text</option></select><br></div>'); //add input box
	        } else {
	            alert('You Reached the limits')
	        }
	    });

	    $(wrapper).on("click", ".delete", function(e) {
	        e.preventDefault();
	        $(this).parent('div').remove();
	        x--;
	    });






		$('#editQuestion').on('submit', function(event){
			event.preventDefault();
			$('#form_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"api/evaluation.inc",
				method:"POST",
				data:form_data,
				success:function(data)
				{
				
							//$('#title').val('');
							//$('#start_date').val('');
							//$('#end_date').val('');
							//$('#desc').val('');
							
							$('#message').html(data);
							$('#form_action').attr('disabled', false);

					
				
			

				
				}
			});


		});

		$('.ui-sortable').sortable({
			placeholder: "ui-state-highlight",
			 update: function( ) {
			 	//alert("Saving question sort order.","info")
		        $.ajax({
		        	url:"api/sort.php?action=action_update_qsort_q",
		        	method:'POST',
		        	data:$('#manage-sort').serialize(),
		        	success:function(resp){
		        		$('#message').html(resp);
		        		if(resp == 1){
			 				//alert("Question order sort successfully saved.","success")
			 				
			 				setTimeout(function(){
								location.reload()
							},1000)
		        		}
		        	}
		        })
		    }
		});



	});
</script>