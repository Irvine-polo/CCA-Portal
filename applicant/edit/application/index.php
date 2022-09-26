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

	$sql = "SELECT * FROM applicant_profiles WHERE control_number = '$controlNumber' AND academic_year = '$academicYear'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<div class='px-md-4 py-5'>
				<div class='container'>
					<div class='alert alert-info alert-dismissible fade show' role='alert'>
						<strong>Note:</strong> You can update your informations until <b>" . date('F d, Y', strtotime($row["expired_at"])) . "</b>.
					</div>

					<div class='row'>
						<div class='col-md-4'>
							<div class='card'>
								<div class='card-body'>
									<h5 class='card-title mb-3'>Form Links</h5>

									<div class='list-group'>
										<a class='list-group-item list-group-item-action active' href='./'>Personal Information</a>
										<a class='list-group-item list-group-item-action' href='./educational-background'>Educational Background</a>
										<a class='list-group-item list-group-item-action' href='./emergency-information'>Emergency Information</a>
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
							<h1 class='h3 mb-3'>Applicant's Personal Information</h1>";

							$sql2 = "SELECT * FROM applicant_profiles WHERE control_number = '$controlNumber' AND academic_year = '$academicYear'";
							$result2 = mysqli_query($conn, $sql2);
							
							if (mysqli_num_rows($result2) > 0) {
								while ($row2 = mysqli_fetch_assoc($result2)) {
									echo "<div class='card mb-0'>
										<form class='card-body' id='form'>
											<div class='mb-3'>
												<label>Full Name</label>
												<input class='form-control form-control-lg' type='text' name='fullname' value='" . $row2["fullname"] . "' required>
											</div>
											
											<div class='mb-3'>
												<label>Course</label>
												<input class='form-control form-control-lg' type='text' name='course' value='" . properCaseCourse($row2["course"]) . "' disabled>
											</div>

											<div class='row'>
												<div class='col-md-3'>
													<div class='mb-3'>
														<label>Course Code</label>
														<input class='form-control form-control-lg' type='text' name='course' value='" . $row2["course"] . "' disabled>
													</div>
												</div>
												
												<div class='col-md-3'>
													<div class='mb-3'>
														<label>Year Level</label>
														<input class='form-control form-control-lg' type='text' name='course' value='1st Year' disabled>
													</div>
												</div>

												<div class='col-md-6'>
													<div class='mb-3'>
														<label>Email Address</label>
														<input class='form-control form-control-lg' type='text' name='emailAddress' value='" . $row2["email_address"] . "' disabled>
													</div>
												</div>
											</div>

											<div class='row'>
												<div class='col-md-4'>
													<div class='mb-3'>
														<label>Address</label>
														<input class='form-control form-control-lg' type='text' name='address' value='" . $row2["address"] . "' required>
													</div>
												</div>";
												
												$barangays = array(
													"Agapito del Rosario",
													"Amsic",
													"Anunas",
													"Balibago",
													"Capaya I",
													"Capaya II",
													"Claro M. Recto",
													"Cuayan",
													"Cutcut",
													"Cutud",
													"Lourdes North West",
													"Lourdes Sur",
													"Malabanias",
													"Margot",
													"Mining",
													"Ninoy Aquino (Marisol)",
													"Pampang",
													"Pandan",
													"Pulung Maragul",
													"Pulungbulu",
													"Pulung Cacutud",
													"Salapungan",
													"San Jose",
													"San Nicolas",
													"Santa Teresita",
													"Santa Trinidad",
													"Santo Cristo",
													"Santo Domingo",
													"Santo Rosario",
													"Sapalibutad",
													"Tabun",
													"Virgen Delos Remedios"
												);

												echo "<div class='col-md-4'>
													<div class='mb-3'>
														<label>Barangay</label>
														<select class='form-select form-select-lg' id='barangay' name='barangay' required>
															<option value='' disabled " . selected("", $row2["barangay"]) . ">--Select--</option>
															<option value='Agapito del Rosario' " . selected("Agapito del Rosario", $row2["barangay"]) . ">Agapito del Rosario</option>
															<option value='Amsic' " . selected("Amsic", $row2["barangay"]) . ">Amsic</option>
															<option value='Anunas' " . selected("Anunas", $row2["barangay"]) . ">Anunas</option>
															<option value='Balibago' " . selected("Balibago", $row2["barangay"]) . ">Balibago</option>
															<option value='Capaya I' " . selected("Capaya I", $row2["barangay"]) . ">Capaya I</option>
															<option value='Capaya II' " . selected("Capaya II", $row2["barangay"]) . ">Capaya II</option>
															<option value='Claro M. Recto' " . selected("Claro M. Recto", $row2["barangay"]) . ">Claro M. Recto</option>
															<option value='Cuayan' " . selected("Cuayan", $row2["barangay"]) . ">Cuayan</option>
															<option value='Cutcut' " . selected("Cutcut", $row2["barangay"]) . ">Cutcut</option>
															<option value='Cutud' " . selected("Cutud", $row2["barangay"]) . ">Cutud</option>
															<option value='Lourdes North West' " . selected("Lourdes North West", $row2["barangay"]) . ">Lourdes North West</option>
															<option value='Lourdes Sur' " . selected("Lourdes Sur", $row2["barangay"]) . ">Lourdes Sur</option>
															<option value='Malabanias' " . selected("Malabanias", $row2["barangay"]) . ">Malabanias</option>
															<option value='Margot' " . selected("Margot", $row2["barangay"]) . ">Margot</option>
															<option value='Mining' " . selected("Mining", $row2["barangay"]) . ">Mining</option>
															<option value='Ninoy Aquino (Marisol)' " . selected("Ninoy Aquino (Marisol)", $row2["barangay"]) . ">Ninoy Aquino (Marisol)</option>
															<option value='Pampang' " . selected("Pampang", $row2["barangay"]) . ">Pampang</option>
															<option value='Pandan' " . selected("Pandan", $row2["barangay"]) . ">Pandan</option>
															<option value='Pulung Maragul' " . selected("Pulung Maragul", $row2["barangay"]) . ">Pulung Maragul</option>
															<option value='Pulungbulu' " . selected("Pulungbulu", $row2["barangay"]) . ">Pulungbulu</option>
															<option value='Pulung Cacutud' " . selected("Pulung Cacutud", $row2["barangay"]) . ">Pulung Cacutud</option>
															<option value='Salapungan' " . selected("Salapungan", $row2["barangay"]) . ">Salapungan</option>
															<option value='San Jose' " . selected("San Jose", $row2["barangay"]) . ">San Jose</option>
															<option value='San Nicolas' " . selected("San Nicolas", $row2["barangay"]) . ">San Nicolas</option>
															<option value='Santa Teresita' " . selected("Santa Teresita", $row2["barangay"]) . ">Santa Teresita</option>
															<option value='Santa Trinidad' " . selected("Santa Trinidad", $row2["barangay"]) . ">Santa Trinidad</option>
															<option value='Santo Cristo' " . selected("Santo Cristo", $row2["barangay"]) . ">Santo Cristo</option>
															<option value='Santo Domingo' " . selected("Santo Domingo", $row2["barangay"]) . ">Santo Domingo</option>
															<option value='Santo Rosario' " . selected("Santo Rosario", $row2["barangay"]) . ">Santo Rosario</option>
															<option value='Sapalibutad' " . selected("Sapalibutad", $row2["barangay"]) . ">Sapalibutad</option>
															<option value='Tabun' " . selected("Tabun", $row2["barangay"]) . ">Tabun</option>
															<option value='Virgen Delos Remedios' " . selected("Virgen Delos Remedios", $row2["barangay"]) . ">Virgen Delos Remedios</option>";

															if (!in_array($row2["barangay"], $barangays)) {
																echo "<option value='Other' selected>Other</option>";	
															} else {
																echo "<option value='Other'>Other</option>";
															}
															
														echo "</select>
													</div>
												</div>
												
												<div class='col-md-4'>
													<div class='mb-3'>
														<label>City/Municipality</label>
														<input class='form-control form-control-lg' type='text' name='city' value='" . $row2["city"] . "' required>
													</div>
												</div>
											</div>

											<div class='row d-none' id='otherBarangay'>
												<div class='mb-3'>
													<label>Enter your Barangay</label>
													<input class='form-control form-control-lg' type='text' name='otherBarangay' value='" . $row2["barangay"] . "'>
												</div>
											</div>
											
											<div class='row'>
												<div class='col-md-4'>
													<div class='mb-3'>
														<label>Contact Number</label>
														<input class='form-control form-control-lg' type='text' data-type='number' pattern='[0-9]{11}' name='contactNumber' value='" . $row2["contact_number"] . "' required>
													</div>
												</div>

												<div class='col-md-4'>
													<div class='mb-3'>
														<label>Age</label>
														<input class='form-control form-control-lg' type='text' data-type='number' name='age' value='" . $row2["age"] . "' required>
													</div>
												</div>

												<div class='col-md-4'>
													<div class='mb-3'>
														<label>Civil Status</label>
														<input class='form-control form-control-lg' type='text' name='civilStatus' value='" . $row2["civil_status"] . "' required>
													</div>
												</div>
											</div>	

											<div class='row'>
												<div class='col-md-4'>
													<div class='mb-3'>
														<label>Sex</label>
														<select class='form-select form-select-lg' name='sex' required>
															<option value='' disabled " . selected("", $row2["sex"]) . ">--Select--</option>
															<option value='Male' " . selected("Male", $row2["sex"]) . ">Male</option>
															<option value='Female' " . selected("Female", $row2["sex"]) . ">Female</option>
														</select>
													</div>
												</div>

												<div class='col-md-4'>
													<div class='mb-3'>
														<label>Nationality</label>
														<input class='form-control form-control-lg' type='text' name='nationality' value='" . $row2["nationality"] . "' required>
													</div>
												</div>

												<div class='col-md-4'>
													<div class='mb-3'>
														<label>Religion</label>
														<input class='form-control form-control-lg' type='text' name='religion' value='" . $row2["religion"] . "' required>
													</div>
												</div>
											</div>

											<div class='row'>
												<div class='col-md-4'>
													<div class='mb-3'>
														<label>Is PWD?</label>
														<select class='form-select form-select-lg' name='isPWD' required>
															<option value='' disabled " . selected("", $row2["is_pwd"]) . ">--Select--</option>
															<option value='Yes' " . selected("Yes", $row2["is_pwd"]) . ">Yes</option>
															<option value='No' " . selected("No", $row2["is_pwd"]) . ">No</option>
														</select>
													</div>
												</div>

												<div class='col-md-8'>
													<div class='mb-3'>
														<label>Place of Birth</label>
														<input class='form-control form-control-lg' type='text' name='placeOfBirth' value='" . $row2["place_of_birth"] . "' required>
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
				data: $('#form').serialize() + "&submitUpdateApplicantProfile",
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

		if ($("#barangay").val() == "Other") {
			$("#otherBarangay").removeClass("d-none");
		} else {
			$("#otherBarangay").addClass("d-none");
		}

		$("#barangay").on("change", function() {
			if ($("#barangay").val() == "Other") {
				$("#otherBarangay").removeClass("d-none");
				$("#otherBarangay input").focus();
			} else {
				$("#otherBarangay").addClass("d-none");
			}
		});
	});
</script>