<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "classSchedules";

include $baseUrl . "assets/templates/student/header.inc.php";

?>

<h1 class="h3 mb-3">Class Schedules</h1>

<div class="row">
	
	<?php

	

	$sql = "SELECT * FROM academic_years WHERE is_active = 1";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$academicYear = $row["academic_year"];
			$semester = $row["semester"];
		}
	}

	$studentNumber = $_SESSION["username"];

	$sql = "SELECT * FROM student_subjects WHERE academic_year = '$academicYear' AND semester = '$semester' AND student_number = '$studentNumber'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$classCode = $row["class_code"];

			$sql2 = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode' ORDER BY class_code ASC";
			$result2 = mysqli_query($conn, $sql2);
			
			if (mysqli_num_rows($result2) > 0) {
				while ($row2 = mysqli_fetch_assoc($result2)) {
					echo "<div class='col-md-6 col-xxl-4'>
						<div class='card'>
							<div class='card-body'>
								<h3 class='text-center mb-0'>" . $row2["subject_code"] . "</h3>
								<p class='text-center mb-0'>" . $row2["class_code"] . " • " . $row2["section"] . "</p>

								<hr>

								<div class='row text-center mb-3'>
									<div class='col-4 fw-bold'>
										Lec Hours
									</div>
									<div class='col-4 fw-bold'>
										Lab Hours
									</div>
									<div class='col-4 fw-bold'>
										Units
									</div>
									<div class='col-4'>
										" . $row2["lec_hours"] . "
									</div>
									<div class='col-4'>
										" . $row2["lab_hours"] . "
									</div>
									<div class='col-4'>
										" . $row2["units"] . "
									</div>
								</div>

								<div class='row'>
									<div class='col-6'>
										<table class='table table-bordered table-sm text-center table-border-dark mb-0'>
											<tr class='bg-green text-white'>
												<td colspan='2'>Synchronous</td>
											</tr>
											<tr>
												<td class='bg-gray-100'>Day</td>
												<td class='bg-gray-100'>Time</td>
											</tr>
											<tr>
												<td>" . $row2["sync_day"] . "</td>
												<td>" . $row2["sync_time"] . "</td>
											</tr>
										</table>
									</div>

									<div class='col-6'>
										<table class='table table-bordered table-sm text-center table-border-dark mb-0'>
											<tr class='bg-green text-white'>
												<td colspan='2'>Asynchronous</td>
											</tr>
											<tr>
												<td class='bg-gray-100'>Day</td>
												<td class='bg-gray-100'>Time</td>
											</tr>
											<tr>
												<td>" . $row2["async_day"] . "</td>
												<td>" . $row2["async_time"] . "</td>
											</tr>
										</table>
									</div>
								</div>";

								// <div class='d-grid g-2 mt-3'>
									// <a class='btn btn-info btn-sm' href='./view/assessments/midterms?classCode=" . $row2["class_code"] . "&subjectCode=" . $row2["subject_code"] . "'>
									// 	View Assessments
									// </a>
								// </div>

								$check_exist = $conn->query("SELECT * FROM evaluation_set WHERE status = 'active' AND eval_type = 'Faculty_Performance'")->num_rows;
							if ($check_exist != 0) {
							
								$eval_info = $conn->query("SELECT * FROM evaluation_set WHERE status = 'active' AND eval_type = 'Faculty_Performance'")->fetch_assoc();
								$evaluation_id = $eval_info['id'];
								$subject_code = $row2['subject_code'];
								$prof_name = $row2['faculty_name'];
								$fac_id =$conn->query("SELECT * FROM users WHERE CONCAT(lastname,', ',firstname) = '$prof_name'")->fetch_assoc();
								$uname= $fac_id['username'];
								$evaluated_exist = $conn->query("SELECT * FROM response_completed WHERE faculty_id = '$uname' AND username = '$studentNumber' AND eval_set = '$evaluation_id' AND subject_code = '$subject_code'")->num_rows;
							
								if ($evaluated_exist == 0) {
									$_SESSION['student_sub'] = $_SERVER['REQUEST_URI'];
									$end = $eval_info['end_date'];
									$newDate = date("M d", strtotime($end));
									$prof_name = $row2['faculty_name'];
									$faculty_id =$conn->query("SELECT * FROM users WHERE CONCAT(lastname,', ',firstname) = '$prof_name'")->fetch_assoc();
								 echo "<div class='d-grid mb-2'>
										<div style='margin-top:10px; margin-bottom:10px;'>
										<hr>
											<label style='float:right;'>Due ".$newDate."</label>
										</div>
									    <a href='evaluation?p=".$faculty_id['username']."&e=".$evaluation_id."&s=".$subject_code."' class='btn btn-info btn-sm'>Evaluate Faculty</a>
									</div>";
    								
    
								}//end
								
								$sql_sub = $conn->query("SELECT substitute_reference_number,substitute_faculty_name	 FROM class_schedules WHERE class_code = '$classCode'")->fetch_assoc();
    								if($sql_sub['substitute_reference_number'] != ""){
    								    $username_sub = $sql_sub['substitute_reference_number'];
    								    $evaluated_exist2 = $conn->query("SELECT * FROM response_completed WHERE faculty_id = '$username_sub' AND username = '$studentNumber' AND eval_set = '$evaluation_id' AND subject_code = '$subject_code'")->num_rows;
    								    if ($evaluated_exist2 == 0) {
    								    ?>
    								    
    								    <div class='d-grid'>
        									 <?php echo"<a href='evaluation?p=".$sql_sub['substitute_reference_number']."&e=".$evaluation_id."&s=".$subject_code."' class='btn btn-warning btn-sm'>Evaluate Subtitute</a>"; ?>
    									</div>
    								
    									<?php
    							        }
    								}
								
								
								

							}
							echo "</div>
						</div>
					</div>";
				}
			}
		}
	} else {
		echo "<div class='col-12'>
			<div class='card'>
				<div class='card-body text-center'>
					Not Enrolled!
				</div>
			</div>
		</div>";
	}

	?>

</div>

<?php

include $baseUrl . "assets/templates/student/footer.inc.php";

?>