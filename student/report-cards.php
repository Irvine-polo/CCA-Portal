<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "reportCards";

include $baseUrl . "assets/templates/student/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Report Cards</h1>

	<div class="d-flex align-items-center">
		<select class='form-select me-2' id='academicYearFull' autofocus>
			
			<?php

			$studentNumber = $_SESSION["username"];

			$sql = "SELECT *
FROM student_grades
LEFT JOIN class_schedules
ON student_grades.class_code = class_schedules.class_code
WHERE CONCAT(student_grades.academic_year, ' ', student_grades.semester) LIKE '%$academicYearFull%' AND CONCAT(class_schedules.academic_year, ' ', class_schedules.semester) LIKE '%$academicYearFull%' AND student_grades.student_number = '$studentNumber' AND class_schedules.status = 'finalized' AND student_grades.final_grade <> ''
GROUP BY CONCAT(student_grades.academic_year, ' ', student_grades.semester) 
ORDER BY CONCAT(student_grades.academic_year, ' ', student_grades.semester) DESC";
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$academicYear = $row["academic_year"];
					$semester = $row["semester"];

					$semesterFull = $semester;

					if ($semester != "Summer") {
						$semesterFull .= " Semester";
					}

					echo "<option value='" . $row["academic_year"] . " " . $row["semester"] . "'>A.Y. " . $academicYear . ", " . $semesterFull . "</option>";
				}
			} else {
				echo "<option value='no class recored available'>No Class Records available</option>";
			}

			if (mysqli_num_rows($result) > 1) {
				echo "<option value=''>All</option>";
			}

			?>

		</select>
		
		<button class="btn btn-primary d-flex justify-content-between align-items-center" onclick="window.print();">
			<i class="fa-solid fa-print me-2"></i>
			Print
		</button>
	</div>
</div>

<div id="reportCardsWrapper"></div>

<?php

include $baseUrl . "assets/templates/student/footer.inc.php";

?>

<script type="text/javascript">
	$.ajax({
		type: "GET",
		url: "../assets/includes/student/report-card.inc.php?getReportCards&academicYearFull=" + $("#academicYearFull").val(),
		dataType: "html",
		beforeSend: function () {
			$("#academicYearFull").prop("disabled", true);
			$('#reportCardsWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
		},
		success: function(data) {
			$("#academicYearFull").prop("disabled", false);
			$("#reportCardsWrapper").html(data);
			$("#academicYearFull").focus();
		}
	});

	$(document).on("change", "#academicYearFull", function(){
		$.ajax({
			type: "GET",
			url: "../assets/includes/student/report-card.inc.php?getReportCards&academicYearFull=" + $("#academicYearFull").val(),
			dataType: "html",
			beforeSend: function () {
				$("#academicYearFull").prop("disabled", true);
				$('#reportCardsWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
			},
			success: function(data) {
				$("#academicYearFull").prop("disabled", false);
				$("#reportCardsWrapper").html(data);
				$("#academicYearFull").focus();
			}
		});
	});

	$(document).on("keydown", function(e) {
		if (e.key == "f" || e.key == "F") {
			$("#academicYearFull").focus();
		}
	})
</script>