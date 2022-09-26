<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "facultyClassSchedules";

include $baseUrl . "assets/templates/coordinator/header.inc.php";

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

	$referenceNumber = $_SESSION["username"];

	$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND (reference_number = '$referenceNumber' OR substitute_reference_number = '$referenceNumber')";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<div class='col-md-6 col-xxl-4'>
				<div class='card'>
					<div class='card-body'>
						<h3 class='text-center mb-0'>" . $row["subject_code"] . "</h3>
						<p class='text-center mb-0'>" . $row["class_code"] . " • " . $row["section"] . "</p>

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
								" . $row["lec_hours"] . "
							</div>
							<div class='col-4'>
								" . $row["lab_hours"] . "
							</div>
							<div class='col-4'>
								" . $row["units"] . "
							</div>
						</div>

						<div class='row'>
							<div class='col-6'>
								<table class='table table-bordered table-sm text-center table-border-dark'>
									<tr class='bg-green text-white'>
										<td colspan='2'>Synchronous</td>
									</tr>
									<tr>
										<td class='bg-gray-100'>Day</td>
										<td class='bg-gray-100'>Time</td>
									</tr>
									<tr>
										<td>&zwj;" . $row["sync_day"] . "&zwj;</td>
										<td>&zwj;" . $row["sync_time"] . "&zwj;</td>
									</tr>
								</table>
							</div>

							<div class='col-6'>
								<table class='table table-bordered table-sm text-center table-border-dark'>
									<tr class='bg-green text-white'>
										<td colspan='2'>Asynchronous</td>
									</tr>
									<tr>
										<td class='bg-gray-100'>Day</td>
										<td class='bg-gray-100'>Time</td>
									</tr>
									<tr>
										<td>&zwj;" . $row["async_day"] . "&zwj;</td>
										<td>&zwj;" . $row["async_time"] . "&zwj;</td>
									</tr>
								</table>
							</div>
						</div>

						<div class='row g-1'>
							<div class='col-12'>
								<div class='d-grid'>
									<a class='btn btn-primary btn-sm' href='./view/faculty-class-list?classCode=" . $row["class_code"] . "'>
										View Class List
									</a> 
								</div>
							</div>";

							/*
							<div class='col-6'>
								<div class='d-grid'>
									<a class='btn btn-warning btn-sm' href='./view/assessments/midterms?classCode=" . $row["class_code"] . "'>
										View Assessments
									</a>
								</div>
							</div>

							<div class='col-6'>
								<div class='d-grid'>
									<a class='btn btn-info btn-sm' href='./view/class-records/midterms?classCode=" . $row["class_code"] . "'>
										View Class Records
									</a>
								</div>
							</div>
							

							<div class='col-12'>
								<div class='d-grid'>
									<a class='btn btn-main btn-sm' href='./import/finalized-grades?classCode=" . $row["class_code"] . "'>
										Import / Reimport Finalized Grades
									</a>
								</div>
							</div>
							*/
						echo "</div>
					</div>
				</div>
			</div>";
		}
	} else {
		echo "<div class='card'>
			<div class='card-body text-center'>
				No Loads to show!
			</div>
		</div>";
	}

	?>

</div>

<?php

include $baseUrl . "assets/templates/coordinator/footer.inc.php";

?>