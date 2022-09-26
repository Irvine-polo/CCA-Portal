<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluation";

include $baseUrl . "assets/templates/hr/header.inc.php";
	

?>
<?php 

$qry = $conn->query("SELECT * FROM evaluation_set where id = ".$_GET['id'])->fetch_assoc();

foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;

}

$_SESSION['eval'] = $_GET['id'];
 ?>
<style type="text/css">	
#btn-back-to-top {
  position: fixed;
  bottom: 20px;
  right: 20px;
  display: none;
  z-index: 1;
}
</style>
<button
        type="button"
        class="btn btn-success btn-floating btn-lg"
        id="btn-back-to-top"
        >
  <i class="fas fa-arrow-up"></i>
</button>

<div id="message"></div>

<div class="col-lg-12">
	<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
		<a href="view-eval?eval=view_evaluation&id=<?php echo$_SESSION['eval'] ?>"><h1 class="h3 mb-3">View Evaluation</h1></a>

		<a class="btn btn-primary" href="evaluation_sets?eval=<?php echo$stitle ?>">Back</a>
</div>
			<div class="row">
				<div class="col-md-4">
					<div class="card card-outline card-primary">
						<div class="card-header">
							<h3 class="card-title">Evaluation Survey Details</h3>
						</div>
						<div class="card-body p-0 py-2">
							<div class="container-fluid">
								<p>Title: <b><?php echo $stitle ?></b></p>
								<p>Survey for: <b><?php echo $eval_type ?></b></p>
								<p class="mb-0">Description:</p>
								<small><?php echo $description; ?></small>
								<br><br>
								<p>Start: <b><?php echo date("M d, Y",strtotime($start_date)) ?></b></p>
								<p>End: <b><?php echo date("M d, Y",strtotime($end_date)) ?></b></p>
								<?php 
								$res_num = $conn->query("SELECT id FROM response_completed WHERE eval_set = '$id'")->num_rows;
								 ?>
								<p>Responses: <b><?php echo$res_num ?></b></p>
								

							</div>
							<hr class="border-primary">
						</div>
					</div>


					<?php 
					$check = $conn->query("SELECT * FROM evaluation_set WHERE id ='$id'")->fetch_assoc();
					if ($check['status'] != 'active') {
						?>	
						<div class="card card-outline card-primary">
						<div class="card-header">
							
							<h3 class="card-title">Section order by</h3>
						</div>
						<div class="card-body p-0 py-2">
							<div class="container-fluid">
								<form action="" id="manage-sort">
									<div class="card-body ui-sortable">
										
										<div id="section_sortable"></div>
										<?php 
										$sql = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$id' order by order_by");
													//echo "<div class='card-body ui-sortable'>";
												
												while ($row = $sql->fetch_assoc()) {
												
															echo "<div class='callout callout-info'>";
																	echo "<ul class='list-group'>";
																				echo "<div class='d-flex list-group-item' style='cursor: -webkit-grab; cursor: grab;'>

																					<span style='margin-right:15px; margin-top:5px;' class='handle fa fa-bars'></span>
																					<li class='list-group'><b>".$row['title']."</b></li> ";
																			echo "</div>

																					</ul>";
																	echo "<br>";
																	echo "<input type='hidden' name='qid[]' value='".$row['id']."'>	";
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
		
				<div class="card-header" style="background: #4f6932; margin-bottom: -50px;">
					<div class="d-flex justify-content-between align-items-center d-print-none mb-3" >
						<h3 class="card-title" style="color: white; border-radius: 10px; "><b>Survey Questionaire</b></h3>

						<?php
						if ($check['status'] != 'active') {
							echo "	<button type='button' class='btn btn-success new_question' data-bs-toggle='modal' data-bs-target='#questionModal' data-bs-href=''>
				             <i class='fa fa-plus'></i> Add New Question
				            </button>";
						}
						 ?>
						
					</div>

					
				</div>
					
								<div id="question_survey"></div>
								 <div id="upload_loading"></div>

								<?php 
								//if table is empty
								
								$sql_check = $conn->query("SELECT * FROM title_question WHERE evaluation_table = '$id'")->num_rows;
								if ($sql_check <= 1 ) {
										if ($check['status'] == 'active') {
													echo '
														<div class="text-center"style="margin-top: 70px; margin-bottom:-50px;">
															<p style="color:red;"><b>Disable the evaluation table to edit</b></p>
														</div>
												';
										
										}
									
										else{
												echo "<div id='upload_q' class='text-center' style='margin-top: 150px;'>
												<button class='btn btn-light' data-bs-toggle='modal' type='button'data-bs-target='#existquestionModal' data-bs-href=''>Use Existing Questions</button>
												</div>";
										}
								}
								
								
								 ?>
								 
								
								

					
			</div>


	</div>
</div>





 <?php

include $baseUrl . "assets/templates/hr/footer.inc.php";

?>
<!--  Create Question Modal    -->
<div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="Insert Question" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="createQuestion">Create Question</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="form_question">
					<div class="form-group">
						<div class="container1">
							<input type="hidden" name="eval-table_id" value="<?php echo$id ?>">
						<label class="control-label">Header: </label>
						<input required class="form-control form-control-sm" type="text" name="header" id="header">
						<label>Percentage:</label>

						<div class="d-flex">
								<input style="width:70px;" required class="form-control" type="number" name="percentage" id="percentage" min="0" max="100" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;"><b style="font-size:18px;">%</b>
						</div>

						<label required class="control-label">Description: </label>
						<textarea name="description" id="description" cols="30" rows="4" class="form-control" ></textarea>
						<br><br>
						
						<?php $row_q = 1; ?>
						<label class="control-label">Question </label>
						<input required class="form-control form-control-sm" type="text" name="mytext[]" id="mytext[]">
						<select name="q_type[]" id="q_type[]" required>
							<option disabled selected value="" >Select Question type</option>
							<option value="radio">Radio button (rate 1-5)</option>
							<option value="text_box">Text</option>
						
							
						</select>


						<div class="fields"></div>
						<br>
						<?php if ($eval_type != "Faculty_Performance") {
							echo'<div style="text-align: center;"><button class="btn btn-primary add_form_field" id="add_question"><span style="font-size:16px; font-weight:bold;">Add Question+</span></button></div></div>';
						}else{
							echo'<div style="text-align: center;"><button class="btn btn-primary add_form_field2" id="add_question"><span style="font-size:16px; font-weight:bold;">Add Question+</span></button></div></div>';
						}
						 ?>
						
						
					</div>

					<div class="form-group">
						

					</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				
				<input type="hidden" name="action" id="action" value="insert_question"></input>
				<input type="submit" name="form_action" class="btn btn-success" id="post_question" value="Post"></input>
			</div>
			</form>
		</div>
	</div>

</div>

<!--  Use Existing Question Modal    -->
<div class="modal fade" id="existquestionModal" tabindex="-1" aria-labelledby="Insert Question" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="existquestionModal">Select Existing Table</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="form_question_existing">
					<div class="form-group">
						<div class="mb-3">
								<label class="form-label" >Select Table:</label>
								<select class="form-select form-select-lg" name="select_eval" id="select_eval" required>
								<option value ='' selected>--Evaluation Name--</option>
									<?php $call_tables = $conn->query("SELECT * FROM evaluation_set WHERE id <> '$id' AND eval_type = '$eval_type'");
									while ($row = $call_tables->fetch_assoc()) {
										echo"<option value ='".$row['id']."'>".$row['title']." - ".$row['eval_type']."</option>";
									}

									 ?>
								</select>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				
				<input type="hidden" name="action" id="action" value="upload_existing_question"></input>
				<input type="hidden" name="eval_id" id="eval_id" value="<?php echo$id ?>">
				<input type="submit" name="form_action" class="btn btn-success" id="upload_question" value="Done"></input>
			</div>
			</form>
		</div>
	</div>

</div>



<!--  DELETE QUESTION  -->
<div class="modal fade" id="questionDelete" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteModalLabel">Delete Questions</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete question <strong class="title"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<a href="#" class="btn btn-danger href">Delete</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	let questionDelete = document.getElementById("questionDelete");

	questionDelete.addEventListener("show.bs.modal", function (event) {
		let button = event.relatedTarget;

		let title = button.getAttribute("data-bs-title");
		let modalBodyName = questionDelete.querySelector(".modal-body .title");
		modalBodyName.innerHTML = title;

		let href = button.getAttribute("data-bs-href");
		let modalFooterHref = questionDelete.querySelector(".modal-footer .href");
		modalFooterHref.href = href;
	});



//Get the button
let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (
    document.body.scrollTop > 20 ||
    document.documentElement.scrollTop > 20
  ) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
// When the user clicks on the button, scroll to the top of the document
mybutton.addEventListener("click", backToTop);

function backToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

</script>

<!-- drop down  -->
<style>
.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown:hover .dropbtn {
  background-color: #3e8e41;
}
input[type='radio'] {
    transform: scale(1.8);
    accent-color: green;
}
</style>



<!-- Sortable    -->
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

<script>
	$(document).ready(function(){
		load_question();
		
	
		function load_question(){
			$.ajax({
				url:'api/fetch_questions.php?id=<?php echo $id ?>',
				method:'POST',
				success: function(data){
					$('#question_survey').html(data);
				}
			});
		}



		$('#form_question').on('submit', function(event){
				event.preventDefault();
				$('#form_action').attr('disabled', 'disabled');
				var form_data = $(this).serialize();
				$.ajax({
				url:"api/evaluation.inc",
				method:"POST",
				data:form_data,
				success:function(data)
				{
							
							$('#header').val('');
							$('#percentage').val('');
							$('#description').val('');
							$('#mytext').val('');
							$('#questionModal').modal('hide');
							$('#form_action').attr('disabled', false);
							$('#message').html(data);
							load_question();
							setTimeout(function(){
								location.reload()
							},1000)

				
				}
			});

		});


		$('#form_question_existing').on('submit', function(event){
				event.preventDefault();
				$('#upload_question').attr('disabled', 'disabled');
				var form_data = $(this).serialize();
				$.ajax({
				url:"api/evaluation.inc",
				method:"POST",
				data:form_data,
			
				success:function(data)
				{
							$('#select_eval').val('');
							$('#upload_q').hide();
							$('#upload_loading').hide();
							$('#existquestionModal').modal('hide');
							$('#form_action').attr('disabled', false);
							$('#message').html(data);
							load_question();
				}
			});

		});
			var max_fields = 30;
	    var wrapper = $(".fields");
	    var add_button = $(".add_form_field");
	    var number_q = 2;

	    var x = 1;
	    $(add_button).click(function(e) {
	        e.preventDefault();
	        if (x < max_fields) {
	            x++;
	        
	            $(wrapper).append('<div><br><br><label class="control-label">Question</label><button style="float:right;" class="btn btn-danger delete">Delete</button><input id="mytext[]" required class="form-control form-control-sm" type="text" name="mytext[]"/><select name="q_type[]" id="q_type[]" required><option disabled selected value="" >Select Question type</option><option value="radio">Radio button (rate1-5)</option><option value="text_box">Text</option></select><br></div>'); //add input box
	        } else {
	            alert('You Reached the limits')
	        }
	    });

	    $(wrapper).on("click", ".delete", function(e) {
	        e.preventDefault();
	        $(this).parent('div').remove();
	        x--;
	    });


	    var max_fields = 30;
	    var wrapper = $(".fields");
	    var add_button = $(".add_form_field2");
	    var number_q = 2;

	    var x = 1;
	    $(add_button).click(function(e) {
	        e.preventDefault();
	        if (x < max_fields) {
	            x++;
	        
	            $(wrapper).append('<div><br><br><label class="control-label">Question</label><button style="float:right;" class="btn btn-danger delete">Delete</button><input id="mytext[]" required class="form-control form-control-sm" type="text" name="mytext[]"/><select name="q_type[]" id="q_type[]" required><option disabled selected value="" >Select Question type</option><option value="radio">Radio button (rate1-5)</option><option value="text_box">Text</option></select><br></div>'); //add input box
	        } else {
	            alert('You Reached the limits')
	        }
	    });

	    $(wrapper).on("click", ".delete", function(e) {
	        e.preventDefault();
	        $(this).parent('div').remove();
	        x--;
	    });





		$('.ui-sortable').sortable({
			placeholder: "ui-state-highlight",
			 update: function( ) {
			 	//alert("Saving question sort order.","info")
		        $.ajax({
		        	url:"api/sort.php?action=action_update_qsort",
		        	method:'POST',
		        	data:$('#manage-sort').serialize(),
		        	success:function(resp){
		        		$('#message').html(resp);
		        		if(resp == 1){
			 				//alert("Question order sort successfully saved.","success")
			 				load_question();
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
