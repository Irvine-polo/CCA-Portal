<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "reportCards";

include $baseUrl . "assets/templates/admin/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Report Cards</h1>

	<div class="d-flex align-items-center">
		<select class="form-select me-2" id="academicYearFull">

			<?php

			$sql = "SELECT * FROM student_grades WHERE final_grade <> '' GROUP BY academic_year, semester ORDER BY CONCAT(academic_year, ' ', semester) DESC";
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
				echo "<option value=''>No Academic Years available</option>";
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

<div id="studentNumberWrapper"></div>

<div id="reportCardsWrapper"></div>

<?php

include $baseUrl . "assets/templates/admin/footer.inc.php";

?>

<script type="text/javascript">
	$.ajax({
		type: "GET",
		url: "../assets/includes/admin/report-card.inc.php?getStudentNumbers&academicYearFull=" + $("#academicYearFull").val(),
		dataType: "html",
		beforeSend: function () {
			$("#academicYearFull").prop("disabled", true);
			$("#studentNumberSelect").prop("disabled", true);
			$('#studentNumberWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
		},
		success: function(data){
			$("#studentNumberWrapper").html(data);

			$.ajax({
				type: "GET",
				url: "../assets/includes/admin/report-card.inc.php?getReportCards&academicYearFull=" + $("#academicYearFull").val() + "&studentNumberSelect=" + $("#studentNumberSelect").val() + "&studentNumberInput=" + $("#studentNumberInput").val(),
				dataType: "html",
				beforeSend: function () {
					$("#academicYearFull").prop("disabled", true);
					$("#studentNumberSelect").prop("disabled", true);
					$('#reportCardsWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
				},
				success: function(data) {
					$("#academicYearFull").prop("disabled", false);
					$("#studentNumberSelect").prop("disabled", false);
					$("#reportCardsWrapper").html(data);
					$("#studentNumberSelect").focus();
				}
			});
		}
	});

	$(document).on("change", "#academicYearFull", function(){
		$.ajax({
			type: "GET",
			url: "../assets/includes/admin/report-card.inc.php?getStudentNumbers&academicYearFull=" + $("#academicYearFull").val(),
			dataType: "html",
			beforeSend: function () {
				$("#academicYearFull").prop("disabled", true);
				$("#studentNumberSelect").prop("disabled", true);
				$('#studentNumberWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
			},
			success: function(data){
				$("#studentNumberWrapper").html(data);

				$.ajax({
					type: "GET",
					url: "../assets/includes/admin/report-card.inc.php?getReportCards&academicYearFull=" + $("#academicYearFull").val() + "&studentNumberSelect=" + $("#studentNumberSelect").val() + "&studentNumberInput=" + $("#studentNumberInput").val(),
					dataType: "html",
					beforeSend: function () {
						$("#academicYearFull").prop("disabled", true);
						$("#studentNumberSelect").prop("disabled", true);
						$('#reportCardsWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
					},
					success: function(data) {
						$("#academicYearFull").prop("disabled", false);
						$("#studentNumberSelect").prop("disabled", false);
						$("#reportCardsWrapper").html(data);
						$("#academicYearFull").focus();
					}
				});
			}
		});
	});

	$(document).on("change", "#studentNumberSelect", function(){
		$.ajax({
			type: "GET",
			url: "../assets/includes/admin/report-card.inc.php?getReportCards&academicYearFull=" + $("#academicYearFull").val() + "&studentNumberSelect=" + $("#studentNumberSelect").val() + "&studentNumberInput=" + $("#studentNumberInput").val(),
			dataType: "html",
			beforeSend: function () {
				$("#academicYearFull").prop("disabled", true);
				$("#studentNumberSelect").prop("disabled", true);
				$('#reportCardsWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
			},
			success: function(data) {
				$("#academicYearFull").prop("disabled", false);
				$("#studentNumberSelect").prop("disabled", false);
				$("#reportCardsWrapper").html(data);
				$("#studentNumberSelect").focus();
			}
		});
	});

	$(document).on("input", "#studentNumberInput", function(){
		$.ajax({
			type: "GET",
			url: "../assets/includes/admin/report-card.inc.php?getReportCards&academicYearFull=" + $("#academicYearFull").val() + "&studentNumberSelect=" + $("#studentNumberSelect").val() + "&studentNumberInput=" + $("#studentNumberInput").val(),
			dataType: "html",
			beforeSend: function () {
				$('#reportCardsWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
			},
			success: function(data) {
				$("#reportCardsWrapper").html(data);
			}
		});
	});

	$(document).on("keydown", function(e) {
		if (e.key == "f" || e.key == "F") {
			$("#studentNumberSelect").focus();
		}
	})
</script>