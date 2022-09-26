<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "currentGrades";

include $baseUrl . "assets/templates/student/header.inc.php";

?>

<h1 class="h3 mb-3">Current Grades</h1>

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

$sql = "SELECT * FROM student_courses WHERE academic_year = '$academicYear' AND semester = '$semester' AND student_number = '$studentNumber'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		echo "<div class='card'>
			<div class='card-body'>
				<h5 class='card-title mb-3'>" . $semester . " Semester, Academic Year " . $academicYear . "</h5>

				<div class='table-responsive'>
					<table class='table table-bordered table-border-dark table-striped table-sm text-center mb-0'>
						<thead class='bg-secondary text-white'>
							<tr>
								<th width='12%'>Class Code</th>
								<th width='12%'>Course Code</th>
								<th width='40%'>Course Title</th>
								<th width='12%'>Midterm Grade</th>
								<th width='12%'>Final Grade</th>
								<th width='12%'>Remarks</th>
							</tr>
						</thead>

						<tbody>";
							$sql = "SELECT * FROM student_subjects LEFT JOIN class_schedules ON student_subjects.class_code = class_schedules.class_code WHERE student_subjects.academic_year = '$academicYear' AND student_subjects.semester = '$semester' AND student_subjects.student_number = '$studentNumber' ORDER BY student_subjects.class_code ASC";
							$result = mysqli_query($conn, $sql);
							
							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) {
									$classCode = $row["class_code"];

									$sql2 = "SELECT * FROM student_grades WHERE academic_year = '$academicYear' AND semester = '$semester' AND student_number = '$studentNumber' AND class_code = '$classCode'";
									$result2 = mysqli_query($conn, $sql2);
									
									if (mysqli_num_rows($result2) > 0) {
										while ($row2 = mysqli_fetch_assoc($result2)) {

											$midtermGrade = $row2["midterm_grade"] != "" ? $row2["midterm_grade"] : "-";
											$finalGrade = $row2["final_grade"] != "" ? $row2["final_grade"] : "-";

											echo "<tr>
												<td>" . $row2["class_code"] . "</td>
												<td>" . $row2["subject_code"] . "</td>
												<td class='text-start'>" . $row2["subject_title"] . "</td>
												<td>" . $midtermGrade . "</td>
												<td>" . $finalGrade . "</td>
												<td>" . $row2["remarks"] . "</td>
											</tr>";
										}
									} else {
										echo "<tr>
											<td>" . $row["class_code"] . "</td>
											<td>" . $row["subject_code"] . "</td>
											<td class='text-start'>" . $row["subject_title"] . "</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
										</tr>";
									}
								}
							}
						echo "</tbody>
					</table>
				</div>
			</div>
		</div>";
	}
} else {
	echo "<div class='card'>
		<div class='card-body text-center'>
			Not Enrolled!
		</div>
	</div>";
}

?>

<?php

include $baseUrl . "assets/templates/student/footer.inc.php";

?>