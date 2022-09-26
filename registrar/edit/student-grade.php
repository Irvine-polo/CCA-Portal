<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "studentGrades";

include $baseUrl . "assets/templates/registrar/header.inc.php";

$academicYear = sanitize($_GET["academicYear"]);
$semester = sanitize($_GET["semester"]);
$classCode = sanitize($_GET["classCode"]);
$studentNumber = sanitize($_GET["studentNumber"]);

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Edit Student Grade</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" href="./student-grades?academicYear=<?= sanitize($_GET["academicYear"]); ?>&semester=<?= sanitize($_GET["semester"]); ?>&classCode=<?= sanitize($_GET["classCode"]); ?>">
		<i class="fa-solid fa-chevron-left me-2"></i>
		Back
	</a>
</div>

<div class="card">
	<div class="card-body">
		<h5 class="card-title">Grade Legend</h5>

		<table class="table-bordered text-center w-100 mb-0" style="table-layout: fixed;">
			<tr>
				<th>6.00</th>
				<th>7.00</th>
				<th>8.00</th>
				<th>9.00</th>
				<th>LOA</th>
				<th>CRD</th>
			</tr>
			<tr>
				<td>FA</td>
				<td>NFE</td>
				<td>UW</td>
				<td>DRP</td>
				<td>LOA</td>
				<td>CREDITED</td>
			</tr>
		</table>
	</div>
</div>

<div class="row">
	<div class="col-md-6 offset-md-3">
		<div class="card">
			<form class="card-body" action="../../assets/includes/registrar/student-grade.inc.php" method="POST">
				
				<?php

				$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode'";
				$result = mysqli_query($conn, $sql);
				
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<div class='row'>
							<div class='col-md-6'>
								<div class='mb-3'>
									<label>Academic Year</label>
									<input class='form-control form-control-lg' type='text' name='academicYear' value='" . $academicYear . "' readonly>
								</div>
							</div>

							<div class='col-md-6'>
								<div class='mb-3'>
									<label>Semester</label>
									<input class='form-control form-control-lg' type='text' name='semester' value='" . $semester . "' readonly>
								</div>
							</div>
						</div>

						<div class='row'>
							<div class='col-md-3'>
								<div class='mb-3'>
									<label>Class Code</label>
									<input class='form-control form-control-lg' type='text' name='classCode' value='" . $classCode . "' readonly>
								</div>
							</div>

							<div class='col-md-3'>
								<div class='mb-3'>
									<label>Section</label>
									<input class='form-control form-control-lg' type='text' name='section' value='" . $row["section"] . "' readonly>
								</div>
							</div>

							<div class='col-md-4'>
								<div class='mb-3'>
									<label>Course Code</label>
									<input class='form-control form-control-lg' type='text' name='subjectCode' value='" . $row["subject_code"] . "' readonly>
								</div>
							</div>

							<div class='col-md-2'>
								<div class='mb-3'>
									<label>Units</label>
									<input class='form-control form-control-lg' type='text' name='units' value='" . $row["units"] . "' readonly>
								</div>
							</div>
						</div>
						
						<div class='mb-3'>
							<label>Course Title</label>
							<input class='form-control form-control-lg' type='text' name='subjectTitle' value='" . $row["subject_title"] . "' readonly>
						</div>";

						$sql2 = "SELECT * FROM student_grades WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode' AND student_number = '$studentNumber'";
						$result2 = mysqli_query($conn, $sql2);
						
						if (mysqli_num_rows($result2) > 0) {
							while ($row2 = mysqli_fetch_assoc($result2)) {
								echo "<div class='mb-3'>
									<label>Student Name</label>
									<input class='form-control form-control-lg' type='text' name='studentName' value='" . $row2["student_name"] . "' readonly>
								</div>

								<div class='row'>
									<div class='col-md-4'>
										<div class='mb-3'>
											<label>Student Number</label>
											<input class='form-control form-control-lg' type='text' name='studentNumber' value='" . $row2["student_number"] . "' readonly>
										</div>
									</div>

									<div class='col-md-4'>
										<div class='mb-3'>
											<label>Equivalent</label>
											<input class='form-control form-control-lg' id='equivalent' type='text' name='finalGrade' value='" . $row2["final_grade"] . "' required>
										</div>
									</div>

									<div class='col-md-4'>
										<div class='mb-3'>
											<label>Remarks</label>
											<input class='form-control form-control-lg' id='remarks' type='text' name='remarks' value='" . $row2["remarks"] . "' readonly>
										</div>
									</div>
								</div>";
							}
						} else {
						    $sql2 = "SELECT * FROM student_courses WHERE academic_year = '$academicYear' AND semester = '$semester' AND student_number = '$studentNumber'";
    						$result2 = mysqli_query($conn, $sql2);
    						
    						if (mysqli_num_rows($result2) > 0) {
    							while ($row2 = mysqli_fetch_assoc($result2)) {
    							    $studentName = $row2["lastname"] . ", " . $row2["firstname"] . " " . $row2["middlename"];
    							    $studentName = strtoupper($studentName);
    							    
        						    echo "<div class='mb-3'>
        								<label>Student Name</label>
        								<input class='form-control form-control-lg' type='text' name='studentName' value='" . $studentName . "' readonly>
        							</div>
        
        							<div class='row'>
        								<div class='col-md-4'>
        									<div class='mb-3'>
        										<label>Student Number</label>
        										<input class='form-control form-control-lg' type='text' name='studentNumber' value='" . $row2["student_number"] . "' readonly>
        									</div>
        								</div>
        
        								<div class='col-md-4'>
        									<div class='mb-3'>
        										<label>Equivalent</label>
        										<input class='form-control form-control-lg' id='equivalent' type='text' name='finalGrade' required>
        									</div>
        								</div>
        
        								<div class='col-md-4'>
        									<div class='mb-3'>
        										<label>Remarks</label>
        										<input class='form-control form-control-lg' id='remarks' type='text' name='remarks' readonly>
        									</div>
        								</div>
        							</div>";
    							}
    						} else {
    						    echo "<div class='mb-3'>
    								<label>Student Name</label>
    								<input class='form-control form-control-lg' type='text' name='studentName' required>
    							</div>
    
    							<div class='row'>
    								<div class='col-md-4'>
    									<div class='mb-3'>
    										<label>Student Number</label>
    										<input class='form-control form-control-lg' type='text' name='studentNumber' required>
    									</div>
    								</div>
    
    								<div class='col-md-4'>
    									<div class='mb-3'>
    										<label>Equivalent</label>
    										<input class='form-control form-control-lg' id='equivalent' type='text' name='finalGrade' required>
    									</div>
    								</div>
    
    								<div class='col-md-4'>
    									<div class='mb-3'>
    										<label>Remarks</label>
    										<input class='form-control form-control-lg' id='remarks' type='text' name='remarks' readonly>
    									</div>
    								</div>
    							</div>";
    						}
						}

						echo "<div class='mb-3'>
							<label>Password</label>
							<input class='form-control form-control-lg' type='password' name='password' required>
						</div>";
					}
				}

				?>

				<div class="text-center">
					<button class="btn btn-main btn-lg" id="submitButton" type="submit" name="updateStudentGrade" disabled>Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/registrar/footer.inc.php";

?>

<script type="text/javascript">
	$("#equivalent").focusout(function(){
		let finalGrade = $("#equivalent").val();
		let remarks = "";
		let isSubmittable = false;

		switch(finalGrade) {
			case "1":
			case "1.0":
			case "1.00":
				finalGrade = "1.00";
				remarks = "PASSED";
				isSubmittable = true;
				break;
			case "1.25":
				finalGrade = "1.25";
				remarks = "PASSED";
				isSubmittable = true;
				break;
			case "1.5":
			case "1.50":
				finalGrade = "1.50";
				remarks = "PASSED";
				isSubmittable = true;
				break;
			case "1.75":
				finalGrade = "1.75";
				remarks = "PASSED";
				isSubmittable = true;
				break;
			case "2":
			case "2.0":
			case "2.00":
				finalGrade = "2.00";
				remarks = "PASSED";
				isSubmittable = true;
				break;
			case "2.25":
				finalGrade = "2.25";
				remarks = "PASSED";
				isSubmittable = true;
				break;
			case "2.5":
			case "2.50":
				finalGrade = "2.50";
				remarks = "PASSED";
				isSubmittable = true;
				break;
			case "2.75":
				finalGrade = "2.75";
				remarks = "PASSED";
				isSubmittable = true;
				break;
			case "3":
			case "3.0":
			case "3.00":
				finalGrade = "3.00";
				remarks = "PASSED";
				isSubmittable = true;
				break;
			case "5":
			case "5.0":
			case "5.00":
				finalGrade = "5.00";
				remarks = "FAILED";
				isSubmittable = true;
				break;
			case "6":
			case "6.0":
			case "6.00":
				finalGrade = "6.00";
				remarks = "FA";
				isSubmittable = true;
				break;
			case "7":
			case "7.0":
			case "7.00":
				finalGrade = "7.00";
				remarks = "NFE";
				isSubmittable = true;
				break;
			case "8":
			case "8.0":
			case "8.00":
				finalGrade = "8.00";
				remarks = "UW";
				isSubmittable = true;
				break;
			case "9":
			case "9.0":
			case "9.00":
				finalGrade = "9.00";
				remarks = "DRP";
				isSubmittable = true;
				break;
			case "LOA":
				finalGrade = "LOA";
				remarks = "LOA";
				isSubmittable = true;
				break;
			case "CRD":
				finalGrade = "CRD";
				remarks = "CREDITED";
				isSubmittable = true;
				break;
			default:
				finalGrade = finalGrade;
				remarks = "Invalid Equivalent";
		}

		$("#equivalent").val(finalGrade);
		$("#remarks").val(remarks);

		if (!isSubmittable) {
			$("#submitButton").attr("disabled", true);
		} else {
			$("#submitButton").attr("disabled", false);
		}
	});
</script>