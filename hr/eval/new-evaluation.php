<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "evaluation";


include $baseUrl . "assets/templates/hr/header.inc.php";

?>



<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	  
	</div>
<div class="alert alert-danger alert-dismissible" id="error" style="display:none;">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
</div>

<div id="message"></div>



<div class="col-lg-12">
	<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
		<h1 class="h3 mb-3">New Evaluation</h1>

		<a class="btn btn-primary" href="../">Back</a>
	</div>
	<div class="col-md-6 offset-md-3">
		<div class="card">
			<div class="card-body">
				<form id="evaluation">
				
					<div class="row">
						<div class="">
							<div class="form-group">

								<div class="mb-3">
										<label class="form-label">Academic Year</label>
										<div class="input-group">
											<input class="form-control form-control-lg" id="academicYearStart" data-type="number" type="text" pattern="(20[0-5][0-9])" name="academicYearStart" required>
											<span class="input-group-text">-</span>
											<input readonly class="form-control form-control-lg" id="academicYearEnd" >

										</div>
									</div>

									<div class="mb-3">
										<label class="form-label">Semester</label>
										<select class="form-select form-select-lg" name="semester" required>
											<option value="" selected disabled>--Select Semester--</option>
											<option value="1st">1st</option>
											<option value="2nd">2nd</option>
											<option value="Summer">Summer</option>
										</select>
									</div>

								<br>
								<!-- <div class="mb-3">
									<label class="form-label">Evaluation for:</label>
									<select class="form-select form-select-lg" name="eval_type" required>
										<option value="" selected disabled></option>
										<option value="Faculty_Performance">Performance Evaluation (By students)</option>
										<option value="Peer_Evaluation">Peer Evaluation</option>
										<option value="Self_Evaluation">Self Evaluation</option>
										<option value="Faculty_Performance_Head">Faculty Performance Head (By Vpaa,Dean,Program Coordinator)</option>
										
									</select>
								</div> -->
							
							</div>
							
							<div class="form-group">
								<label for="" class="control-label">Start</label>	<br>

								<input class="form-control form-control-sm" autocomplete="off" type="text"  id="start_date" name="start_date" placeholder="yyyy/mm/dd" required>

								
					
							</div>
							<br>
							<div class="form-group">
								<label for="" class="control-label">End</label>	<br>

								<input class="form-control form-control-sm" autocomplete="off" type="text" id="end_date" name="end_date" placeholder="yyyy/mm/dd" required>

									
							
							</div><br>
						</div>
						<!-- <div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea name="description" id="desc" cols="30" rows="4" class="form-control" required><?php echo isset($description) ? $description : '' ?></textarea>
							</div>
						</div> -->
					</div>
					<hr>
					<div class="col-lg-12 text-right justify-content-center d-flex">


					<input type="hidden" name="action" id="action" value="insert" />
					<input type="hidden" name="hidden_id" id="hidden_id" />
					<input name="form-action" id="form_action" type="submit" class="btn btn-success" value="Create"></input>
				
						
						
					</div>
				</form>
			</div>
		</div>
</div>
</div>


<?php


include $baseUrl . "assets/templates/hr/footer.inc.php";

?>


	<!-- Date picker  -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<script type="text/javascript">

	//date pick
	$(document).ready(function(){
		var minDate = new Date();
			$("#start_date").datepicker({
				showAnim: 'drop',
				numberOfMonth: 1,
				minDate: minDate,
				maxDate: "1m",
				dateFormat:'yy-m-d ',
					onClose: function(selectedDate){
						$('#end_date').datepicker("option","minDate",selectedDate);
				}
			});

		

			$("#end_date").datepicker({
				showAnim: 'drop',
				numberOfMonth: 1,
				minDate: minDate,
				maxDate: "1m" ,
				dateFormat:'yy-m-d',
				onClose: function(selectedDate){
			//			$('#Start').datepicker("option","minDate",selectedDate);
				}
			});
	});




	$(document).ready(function(){
		$('#evaluation').on('submit', function(event){
			event.preventDefault();
			$('#form_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"api/evaluation.inc",
				method:"POST",
				data:form_data,
				success:function(data)
				{
							
							$('#title').val('');
							$('#start_date').val('');
							$('#end_date').val('');
							$('#desc').val('');
							$('#form_action').attr('disabled', false);
							$('#message').html(data);
							setTimeout(function(){
								window.location.href='../';
							},1500)
							
							// Swal.fire({
							//   position: 'center',
							//   icon: 'success',
							//   title: 'Success',
							//   text:'Create evaluation successfully',
							//   showConfirmButton: false,
							//   timer: 1500
							// }).then(function() {
							// 		
							// });
				}
				
			});
		});


		let academicYearStart = document.querySelector("#academicYearStart");
	let academicYearEnd = document.querySelector("#academicYearEnd");

	if (academicYearStart.value != "") {
		academicYearEnd.value = +academicYearStart.value + 1;
	}

	academicYearStart.oninput = () => {
		if (academicYearStart.value == "") {
			academicYearEnd.value = "";
		} else {
			if (academicYearStart.value.length == 4) {
				academicYearEnd.value = +academicYearStart.value + 1;	
			} else {
				academicYearEnd.value = "...";
			}
		}
	};

	});

</script>