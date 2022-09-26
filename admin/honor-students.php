<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "honorStudents";

include $baseUrl . "assets/templates/admin/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Honor Students</h1>

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

			?>
			
		</select>
		
		<button class="btn btn-primary d-flex justify-content-between align-items-center" onclick="window.print();">
			<i class="fa-solid fa-print me-2"></i>
			Print
		</button>
	</div>	
</div>

<div id="coursesWrapper"></div>

<div id="honorsWrapper"></div>

<?php

include $baseUrl . "assets/templates/admin/footer.inc.php";

?>

<script type="text/javascript">
	$.ajax({
		type: "GET",
		url: "../assets/includes/admin/honor-student.inc.php?getCourses&academicYearFull=" + $("#academicYearFull").val(),
		dataType: "html",
		beforeSend: function () {
			$("#academicYearFull").prop("disabled", true);
			$("#coursesSelect").prop("disabled", true);
			$("#sortHonorStudentsSelect").prop("disabled", true);
			$('#coursesWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
		},
		success: function(data){
			$("#coursesWrapper").html(data);

			$.ajax({
				type: "GET",
				url: "../assets/includes/admin/honor-student.inc.php?getHonorStudents&academicYearFull=" + $("#academicYearFull").val() + "&course=" + $("#coursesSelect").val() + "&sortHonorStudentsSelect=" + $("#sortHonorStudentsSelect").val(),
				dataType: "html",
				beforeSend: function () {
					$("#academicYearFull").prop("disabled", true);
					$("#coursesSelect").prop("disabled", true);
					$("#sortHonorStudentsSelect").prop("disabled", true);
					$('#honorsWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
				},
				success: function(data) {
					$("#academicYearFull").prop("disabled", false);
					$("#coursesSelect").prop("disabled", false);
					$("#sortHonorStudentsSelect").prop("disabled", false);
					$("#honorsWrapper").html(data);
					$("#coursesSelect").focus();
				}
			});
		}
	});

	$(document).on("change", "#academicYearFull", function(){
		$.ajax({
			type: "GET",
			url: "../assets/includes/admin/honor-student.inc.php?getCourses&academicYearFull=" + $("#academicYearFull").val(),
			dataType: "html",
			beforeSend: function () {
				$("#academicYearFull").prop("disabled", true);
				$("#coursesSelect").prop("disabled", true);
				$("#sortHonorStudentsSelect").prop("disabled", true);
				$('#coursesWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
			},
			success: function(data){
				$("#coursesWrapper").html(data);

				$.ajax({
					type: "GET",
					url: "../assets/includes/admin/honor-student.inc.php?getHonorStudents&academicYearFull=" + $("#academicYearFull").val() + "&course=" + $("#coursesSelect").val() + "&sortHonorStudentsSelect=" + $("#sortHonorStudentsSelect").val(),
					dataType: "html",
					beforeSend: function () {
						$("#academicYearFull").prop("disabled", true);
						$("#coursesSelect").prop("disabled", true);
						$("#sortHonorStudentsSelect").prop("disabled", true);
						$('#honorsWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
					},
					success: function(data) {
						$("#academicYearFull").prop("disabled", false);
						$("#coursesSelect").prop("disabled", false);
						$("#sortHonorStudentsSelect").prop("disabled", false);
						$("#honorsWrapper").html(data);
						$("#academicYearFull").focus();
					}
				});
			}
		});
	});

	$(document).on("change", "#coursesSelect", function(){
		$.ajax({
			type: "GET",
			url: "../assets/includes/admin/honor-student.inc.php?getHonorStudents&academicYearFull=" + $("#academicYearFull").val()  + "&course=" + $("#coursesSelect").val() + "&sortHonorStudentsSelect=" + $("#sortHonorStudentsSelect").val(),
			dataType: "html",
			beforeSend: function () {
				$("#academicYearFull").prop("disabled", true);
				$("#coursesSelect").prop("disabled", true);
				$("#sortHonorStudentsSelect").prop("disabled", true);
				$('#honorsWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
			},
			success: function(data) {
				$("#academicYearFull").prop("disabled", false);
				$("#coursesSelect").prop("disabled", false);
				$("#sortHonorStudentsSelect").prop("disabled", false);
				$("#honorsWrapper").html(data);
				$("#coursesSelect").focus();
			}
		});
	});

	$(document).on("change", "#sortHonorStudentsSelect", function(){
		$.ajax({
			type: "GET",
			url: "../assets/includes/admin/honor-student.inc.php?getHonorStudents&academicYearFull=" + $("#academicYearFull").val()  + "&course=" + $("#coursesSelect").val() + "&sortHonorStudentsSelect=" + $("#sortHonorStudentsSelect").val(),
			dataType: "html",
			beforeSend: function () {
				$("#academicYearFull").prop("disabled", true);
				$("#coursesSelect").prop("disabled", true);
				$("#sortHonorStudentsSelect").prop("disabled", true);
				$('#honorsWrapper').html(`<div class='card'><div class='card-body text-center'><span class="spinner-grow spinner-grow-sm"></span> Loading..</div></div>`);
			},
			success: function(data) {
				$("#academicYearFull").prop("disabled", false);
				$("#coursesSelect").prop("disabled", false);
				$("#sortHonorStudentsSelect").prop("disabled", false);
				$("#honorsWrapper").html(data);
				$("#sortHonorStudentsSelect").focus();
			}
		});
	});

	$(document).on("keydown", function(e) {
		if (e.key == "f" || e.key == "F") {
			$("#coursesSelect").focus();
		}
	})
</script>