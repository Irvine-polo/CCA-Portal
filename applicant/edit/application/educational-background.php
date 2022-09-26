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

	$sql = "SELECT * FROM applicant_educational_backgrounds WHERE control_number = '$controlNumber' AND academic_year = '$academicYear'";
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
										<a class='list-group-item list-group-item-action active' href='./educational-background'>Educational Background</a>
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
							<h1 class='h3 mb-3'>Applicant's Educational Background</h1>";

							$sql2 = "SELECT * FROM applicant_educational_backgrounds WHERE control_number = '$controlNumber' AND academic_year = '$academicYear'";
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
												<label>Type of Applicant</label>
												<select class='form-select form-select-lg' id='typeOfApplicant' name='typeOfApplicant' required>
													<option value='' disabled " . selected("", $row2["type_of_applicant"]) . ">--Select--</option>
													<option value='Current Grade 12' " . selected("Current Grade 12", $row2["type_of_applicant"]) . ">Current Grade 12</option>
													<option value='Grade 12 Graduate' " . selected("Grade 12 Graduate", $row2["type_of_applicant"]) . ">Grade 12 Graduate</option>
													<option value='High School Graduate 2016 or Earlier' " . selected("High School Graduate 2016 or Earlier", $row2["type_of_applicant"]) . ">High School Graduate 2016 or Earlier</option>
													<option value='College Graduate Willing to Start as Freshmen' " . selected("College Graduate Willing to Start as Freshmen", $row2["type_of_applicant"]) . ">College Graduate Willing to Start as Freshmen</option>
													<option value='ALS Graduate' " . selected("ALS Graduate", $row2["type_of_applicant"]) . ">ALS Graduate</option>
												</select>
											</div>

											<div class='row d-none' id='currentGrade12'>
												<div class='col-md-8'>
													<div class='mb-3'>
														<label>Name of Senior High School Currently Enrolled In</label>
														<input class='form-control form-control-lg' type='text' name='currentG12School' value='" . $row2["current_g12_school"] . "'>
													</div>
												</div>

												<div class='col-md-4'>
													<div class='mb-3'>
														<label>Expected Year of Graduation</label>
														<input class='form-control form-control-lg' type='text' data-type='number' name='currentG12GraduationYear' value='" . $row2["current_g12_graduation_year"] . "'>
													</div>
												</div>
											</div>

											<div class='row d-none' id='grade12Graduate'>
												<div class='col-md-8'>
													<div class='mb-3'>
														<label>Name of Senior High School Last Attended</label>
														<input class='form-control form-control-lg' type='text' name='graduateG12School' value='" . $row2["graduate_g12_school"] . "'>
													</div>
												</div>

												<div class='col-md-4'>
													<div class='mb-3'>
														<label>Year Graduated</label>
														<input class='form-control form-control-lg' type='text' data-type='number' name='graduateG12GraduationYear' value='" . $row2["graduate_g12_graduation_year"] . "'>
													</div>
												</div>
											</div>

											<div class='row d-none' id='highSchoolGraduate2016orEarlier'>
												<div class='col-md-8'>
													<div class='mb-3'>
														<label>Name of High School Last Attended</label>
														<input class='form-control form-control-lg' type='text' name='graduateHsSchool' value='" . $row2["graduate_hs_school"] . "'>
													</div>
												</div>

												<div class='col-md-4'>
													<div class='mb-3'>
														<label>Year Graduated</label>
														<input class='form-control form-control-lg' type='text' data-type='number' name='graduateHsGraduationYear' value='" . $row2["graduate_hs_graduation_year"] . "'>
													</div>
												</div>
											</div>

											<div class='row d-none' id='collegeGraduateWillingToStartAsFreshmen'>
												<div class='col-md-8'>
													<div class='mb-3'>
														<label>Name of School Last Attended</label>
														<input class='form-control form-control-lg' type='text' name='graduateCollegeLastSchool' value='" . $row2["graduate_college_last_school"] . "'>
													</div>
												</div>

												<div class='col-md-4'>
													<div class='mb-3'>
														<label>Year Last Attended</label>
														<input class='form-control form-control-lg' type='text' data-type='number' name='graduateCollegeLastGraduationYear' value='" . $row2["graduate_college_last_graduation_year"] . "'>
													</div>
												</div>

												<div class='col-md-8'>
													<div class='mb-3'>
														<label>Name of High School / Senior High School Attended</label>
														<input class='form-control form-control-lg' type='text' name='graduateCollegeHsOrShsSchool' value='" . $row2["graduate_college_hs_or_shs_school"] . "'>
													</div>
												</div>

												<div class='col-md-4'>
													<div class='mb-3'>
														<label>Year Graduated</label>
														<input class='form-control form-control-lg' type='text' data-type='number' name='graduateCollegeHsOrShsGraduationYear' value='" . $row2["graduate_college_hs_or_shs_graduation_year"] . "'>
													</div>
												</div>
											</div>

											<div class='mb-3 d-none' id='alsGraduate'>
												<label>Year Passed</label>
												<input class='form-control form-control-lg' type='text' data-type='number' name='graduateALSYearPassed' value='" . $row2["graduate_als_year_passed"] . "'>
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
				data: $('#form').serialize() + "&submitUpdateApplicantEducationalBackground",
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

		if ($("#typeOfApplicant").val() == "Current Grade 12") {
			$("#currentGrade12").removeClass("d-none");
		} else if ($("#typeOfApplicant").val() == "Grade 12 Graduate") {
			$("#grade12Graduate").removeClass("d-none");
		} else if ($("#typeOfApplicant").val() == "High School Graduate 2016 or Earlier") {
			$("#highSchoolGraduate2016orEarlier").removeClass("d-none");
		} else if ($("#typeOfApplicant").val() == "College Graduate Willing to Start as Freshmen") {
			$("#collegeGraduateWillingToStartAsFreshmen").removeClass("d-none");
		} else if ($("#typeOfApplicant").val() == "ALS Graduate") {
			$("#alsGraduate").removeClass("d-none");
		}

		$("#typeOfApplicant").on("change", function() {
			if ($("#typeOfApplicant").val() == "Current Grade 12") {
				$("#currentGrade12").removeClass("d-none");
				$("#grade12Graduate").addClass("d-none");
				$("#highSchoolGraduate2016orEarlier").addClass("d-none");
				$("#collegeGraduateWillingToStartAsFreshmen").addClass("d-none");
				$("#alsGraduate").addClass("d-none");
				$("#currentGrade12 input:first").focus();
			} else if ($("#typeOfApplicant").val() == "Grade 12 Graduate") {
				$("#currentGrade12").addClass("d-none");
				$("#grade12Graduate").removeClass("d-none");
				$("#highSchoolGraduate2016orEarlier").addClass("d-none");
				$("#collegeGraduateWillingToStartAsFreshmen").addClass("d-none");
				$("#alsGraduate").addClass("d-none");
				$("#grade12Graduate input:first").focus();
			} else if ($("#typeOfApplicant").val() == "High School Graduate 2016 or Earlier") {
				$("#currentGrade12").addClass("d-none");
				$("#grade12Graduate").addClass("d-none");
				$("#highSchoolGraduate2016orEarlier").removeClass("d-none");
				$("#collegeGraduateWillingToStartAsFreshmen").addClass("d-none");
				$("#alsGraduate").addClass("d-none");
				$("#highSchoolGraduate2016orEarlier input:first").focus();		
			} else if ($("#typeOfApplicant").val() == "College Graduate Willing to Start as Freshmen") {
				$("#currentGrade12").addClass("d-none");
				$("#grade12Graduate").addClass("d-none");
				$("#highSchoolGraduate2016orEarlier").addClass("d-none");
				$("#collegeGraduateWillingToStartAsFreshmen").removeClass("d-none");
				$("#alsGraduate").addClass("d-none");
				$("#collegeGraduateWillingToStartAsFreshmen input:first").focus();		
			} else if ($("#typeOfApplicant").val() == "ALS Graduate") {
				$("#currentGrade12").addClass("d-none");
				$("#grade12Graduate").addClass("d-none");
				$("#highSchoolGraduate2016orEarlier").addClass("d-none");
				$("#collegeGraduateWillingToStartAsFreshmen").addClass("d-none");
				$("#alsGraduate").removeClass("d-none");
				$("#alsGraduate input:first").focus();		
			}
		});
	});
</script>