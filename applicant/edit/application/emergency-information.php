<?php

$baseUrl = "../../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "application";

include $baseUrl . "assets/templates/home/header.inc.php";

?>

<?php

if (isset($_SESSION["controlNumber"])) {
	$controlNumber = $_SESSION["controlNumber"];
	$academicYear = $_SESSION["academicYear"];

	$sql = "SELECT * FROM applicant_emergency_informations WHERE control_number = '$controlNumber' AND academic_year = '$academicYear'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<div class='px-md-4 py-5'>
				<div class='container'>
					<div class='row'>
						<div class='col-md-4'>
							<div class='card'>
								<div class='card-body'>
									<h5 class='card-title mb-3'>Form Links</h5>

									<div class='list-group'>
										<a class='list-group-item list-group-item-action' href='./'>Personal Information</a>
										<a class='list-group-item list-group-item-action' href='./educational-background'>Educational Background</a>
										<a class='list-group-item list-group-item-action active' href='./emergency-information'>Emergency Information</a>
									</div>	
								</div>
							</div>

							<div class='card mb-0'>
								<div class='card-body'>
									<div class='mb-3'>
										<label>Control Number</label>
										<div class='input-group'>
											<span class='input-group-text'>
												<i class='fa-solid fa-user'></i>
											</span>
											<input class='form-control form-control-lg' type='text' value='" . $controlNumber . "' disabled>
										</div>
									</div>

									<div class='mb-3'>
										<label>Academic Year</label>
										<div class='input-group'>
											<span class='input-group-text'>
												<i class='fa-solid fa-calendar-days'></i>
											</span>
											<input class='form-control form-control-lg' type='text' value='" . $academicYear . "' disabled>
										</div>
									</div>

									<div class='text-center'>
										<a class='btn btn-danger btn-lg' href='../../../assets/includes/home/freshmen-applicant.inc.php?signOut'>
											<i class='fa-solid fa-arrow-right-from-bracket'></i>
											Exit
										</a>
									</div>
								</div>
							</div>
						</div>

						<div class='col-md-8'>
							<h1 class='h3 mb-3'>Applicant's Emergency Information</h1>";

							$sql2 = "SELECT * FROM applicant_emergency_informations WHERE control_number = '$controlNumber' AND academic_year = '$academicYear'";
							$result2 = mysqli_query($conn, $sql2);
							
							if (mysqli_num_rows($result2) > 0) {
								while ($row2 = mysqli_fetch_assoc($result2)) {
									echo "<div class='card mb-0'>
										<form class='card-body' id='form'>
											<div class='mb-3'>
												<label>Full Name</label>
												<input class='form-control form-control-lg' type='text' name='fullname' value='" . $row2["fullname"] . "' required>
											</div>

											<div class='row'>
												<div class='col-md-7'>
													<div class='mb-3'>
														<label>Name of Guardian</label>
														<input class='form-control form-control-lg' type='text' name='nameOfGuardian' value='" . $row2["name_of_guardian"] . "' required>
													</div>
												</div>

												<div class='col-md-5'>
													<div class='mb-3'>
														<label>Relationship with Guardian</label>
														<input class='form-control form-control-lg' type='text' name='relationshipWithGuardian' value='" . $row2["relationship_with_guardian"] . "' required>
													</div>
												</div>
											</div>

											<div class='row'>
												<div class='col-md-7'>
													<div class='mb-3'>
														<label>Address of Guardian</label>
														<input class='form-control form-control-lg' type='text' name='addressOfGuardian' value='" . $row2["address_of_guardian"] . "' required>
													</div>
												</div>

												<div class='col-md-5'>
													<div class='mb-3'>
														<label>Email Address of Guardian</label>
														<input class='form-control form-control-lg' type='text' name='emailAddressOfGuardian' value='" . $row2["email_address_of_guardian"] . "'>
													</div>
												</div>
											</div>

											<div class='row'>
												<div class='col-md-6'>
													<div class='mb-3'>
														<label>Contact Number of Guardian</label>
														<input class='form-control form-control-lg' type='text' name='contactNumberOfGuardian' value='" . $row2["contact_number_of_guardian"] . "' required>
													</div>
												</div>

												<div class='col-md-6'>
													<div class='mb-3'>
														<label>Occupation of Guardian</label>
														<input class='form-control form-control-lg' type='text' name='occupationOfGuardian' value='" . $row2["occupation_of_guardian"] . "'>
													</div>
												</div>
											</div>

											<div class='text-center'>
												<button type='button' class='btn btn-success btn-lg' data-bs-toggle='modal' data-bs-target='#agreementModal'>
                                                	Update
                                                </button>
											</div>
                                            
                                            <div class='modal fade' id='agreementModal' tabindex='-1' aria-hidden='true'>
                                            	<div class='modal-dialog'>
                                            		<div class='modal-content'>
                                            		<div class='modal-header'>
                                            			<h5 class='modal-title' id='exampleModalLabel'>Data Privacy Act</h5>
                                            				<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            			</div>
                                            			<div class='modal-body'>
                                            				<p>I hereby certify that all information entered are true and correct.</p>
                                            				
                                            				<p>I am aware and understand that being a student in this program, my administrative and academic officials may have access to my personal data that I submitted and recognize their responsibilities under the Republic Act No. 10173 (Act), also known as the Data Privacy Act of 2012. I certify that all information were true and correct.</p>
                                            			</div>
                                            			<div class='modal-footer'>
                                            				<button class='btn btn-secondary' type='button' data-bs-dismiss='modal'>Close</button>
                                            				<button class='btn btn-success' id='submitButton' type='submit'>Confirm</button>
                                            			</div>
                                            		</div>
                                            	</div>
                                            </div>
										</form>
									</div>";
								}
							}

						echo "</div>
					</div>
				</div>
			</div>";
		}
	}
} else {
	header("Location: ../../../applicant");
	exit();
}

?>

<?php

include $baseUrl . "assets/templates/home/footer.inc.php";

?>

<script type="text/javascript">
	$(document).ready(function() {
	    document.addEventListener('keypress', function (e) {
            if (e.keyCode === 13 || e.which === 13) {
                e.preventDefault();
                return false;
            }
        });
        
		$('#form').submit(function(e) {	
			e.preventDefault();

			$.ajax({
				url: "../../../assets/includes/home/freshmen-applicant.inc.php",
				type: "POST",
				data: $('#form').serialize() + "&submitUpdateApplicantEmergencyInformation",
				dataType: "json",
				beforeSend: function(data) {
					$('#alertWrapper').html(``);
					$("#submitButton").prop("disabled", true);
					$("#submitButton").html(`<span class="spinner-grow spinner-grow-sm"></span> Loading..`);
				},
				success: function(data) {
					$("#submitButton").prop("disabled", false);
					$("#submitButton").html(`Confirm`);

					window.onbeforeunload = null;

					if (data.type == "error") {
						Swal.fire(
							'Error!',
							data.value + '.',
							'error'
						)
					}

					if (data.type == "success") {
						Swal.fire(
							'Success!',
							'Your profile has been updated and your enrolment will be processed. Updates will be sent via your email address and stay posted for further annoucements.',
							'success'
						).then(function() {
						   $("#agreementModal").modal("hide");
						});
					}
				}
			});

			return false;
		});
	});
</script>