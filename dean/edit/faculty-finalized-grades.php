<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "facultyStudentGrades";

include $baseUrl . "assets/templates/dean/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Edit Finalized Grades</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" href="../view/faculty-student-grades?academicYear=<?= sanitize($_GET["academicYear"]); ?>&semester=<?= sanitize($_GET["semester"]); ?>">
		<i class="fa-solid fa-chevron-left me-2"></i>
		Back
	</a>
</div>

<div class="card">
	<div class="card-body">

		<?php

		$referenceNumber = $_SESSION["username"];
		$academicYear = sanitize($_GET["academicYear"]);
		$semester = sanitize($_GET["semester"]);
		$classCode = sanitize($_GET["classCode"]);

		$deanClasses = array();

		$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND reference_number = '$referenceNumber'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($deanClasses, $row["class_code"]);
			}
		}

		if (in_array($classCode, $deanClasses)) {
			$classDetails = "";
		
			$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND class_code = '$classCode'";
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$classDetails .= $row["class_code"] . "\t" . $row["section"] . "\t" . $row["subject_code"] . "\t" . $row["units"] . "\t" . $row["faculty_name"];

					$section = $row["section"];
					$subjectCode = $row["subject_code"];
					$subjectTitle = $row["subject_title"];
					$units = $row["units"];
				}
			}

			echo "<div class='d-flex justify-content-between align-items-end'>
				<div>
					<h4>" . $section . "</h4>
					<h2 class='mb-0'>" . $subjectCode . "</h2>
				</div>

				<div>
					<h4 class='text-end'>" . $units . " Units</h4>
					<h2 class='mb-0'>" . $subjectTitle . "</h2>
				</div>
			</div>";
		} else {
			echo "<div class='text-center'>Class not found.</div>";
		}

		?>

	</div>
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

<div class="alert alert-info" role="alert">
    <strong>Note!</strong> Press enter key to save the entered grade and move to the next student.
</div>

<?php

$facultyClasses = array();

$sql = "SELECT * FROM class_schedules WHERE academic_year = '$academicYear' AND semester = '$semester' AND reference_number = '$referenceNumber' AND status <> 'finalized'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		array_push($facultyClasses, $row["class_code"]);
	}
}

if (in_array($classCode, $facultyClasses)) {
	echo "<div class='card'>
		<div class='card-body'>
			<div class='table-responsive'>
				<table class='table table-bordered table-border-dark table-striped-light table-sm w-100 mb-0' id='datatable'>
					<thead>
						<tr class='bg-secondary text-white text-center'>
							<th width='5%'>#</th>
							<th width='10%'>Student Number</th>
							<th width='45%'>Full Name</th>
							<th width='10%'>Class Code</th>
							<th width='10%'>Equivalent</th>
							<th width='10%'>Remarks</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>";
} else {
	echo "<div class='card'>
		<div class='card-body text-center'>
			Class not found.
		</div>
	</div>";
}

?>

<?php

include $baseUrl . "assets/templates/dean/footer.inc.php";

?>

<script type="text/javascript">
	$(document).ready(function(){
		var url = new URL(window.location.href);
		var academicYear = url.searchParams.get("academicYear");
		var semester = url.searchParams.get("semester");
		var classCode = url.searchParams.get("classCode");

		$(document).ready( 
			function() {
				$('#datatable').DataTable({
					dom: 'Bfrtip',
					buttons: [
						'copy', 'csv', 'excel'
					],
					"columnDefs": [
						{ className: "text-center", "targets": [ 0 ] },
						{ className: "text-center student-number", "targets": [ 1 ] },
						{ className: "student-name", "targets": [ 2 ] },
						{ className: "text-center", "targets": [ 3 ] },
						{ className: "equivalent", "targets": [ 4 ] },
						{ className: "text-center remarks", "targets": [ 5 ] },
					],
					"iDisplayLength": 100,
					"ordering": false,
					"processing": true,
					"serverSide": true,
					"ajax":{
						"url": `../../assets/api/dean/faculty-finalized-grade.inc.php?getFinalizedGrades&academicYear=${academicYear}&semester=${semester}&classCode=${classCode}`,
						"type": "POST"
					},
					"fnDrawCallback": function(json) {
						$(".equivalent input").keypress(function(event) {
							if (event.keyCode == 13) {
								let equivalent = $(this);

								let url = new URL(window.location.href);
								let academicYear = url.searchParams.get("academicYear");
								let semester = url.searchParams.get("semester");
								let classCode = url.searchParams.get("classCode");
								let studentNumber = $(this).parents("td").siblings(".student-number").html();
								let studentName = $(this).parents("td").siblings(".student-name").html();
								let finalGrade = $(this).val().toUpperCase();

								switch(finalGrade) {
									case "1":
									case "1.0":
									case "1.00":
										finalGrade = "1.00";
										break;
									case "1.25":
										finalGrade = "1.25";
										break;
									case "1.5":
									case "1.50":
										finalGrade = "1.50";
										break;
									case "1.75":
										finalGrade = "1.75";
										break;
									case "2":
									case "2.0":
									case "2.00":
										finalGrade = "2.00";
										break;
									case "2.25":
										finalGrade = "2.25";
										break;
									case "2.5":
									case "2.50":
										finalGrade = "2.50";
										break;
									case "2.75":
										finalGrade = "2.75";
										break;
									case "3":
									case "3.0":
									case "3.00":
										finalGrade = "3.00";
										break;
									case "5":
									case "5.0":
									case "5.00":
										finalGrade = "5.00";
										break;
									case "6":
									case "6.0":
									case "6.00":
										finalGrade = "6.00";
										break;
									case "7":
									case "7.0":
									case "7.00":
										finalGrade = "7.00";
										break;
									case "8":
									case "8.0":
									case "8.00":
										finalGrade = "8.00";
										break;
									case "9":
									case "9.0":
									case "9.00":
										finalGrade = "9.00";
										break;
									default:
										finalGrade = finalGrade;

								}

								const allowedEquivalents = ["", "1.00", "1.25", "1.50", "1.75", "2.00", "2.25", "2.50", "2.75", "3.00", "5.00", "6.00", "7.00", "8.00", "9.00", "LOA", "CRD"];

								if (allowedEquivalents.includes(finalGrade)) {
									$.ajax({
										url: "../../assets/includes/dean/faculty-finalized-grade.inc.php",
										type: "POST",
										data: {
											updateStudentGrade : "",
											academicYear : academicYear,
											semester : semester,
											classCode : classCode,
											studentNumber : studentNumber,
											studentName : studentName,
											finalGrade : finalGrade
										},
										dataType: "json",
										beforeSend: function() {
									        equivalent.parents(".equivalent").siblings(".remarks").html("Loading..");
									    },
										success: function(data) {
											if (data.type == "error") {
												Swal.fire(
													'Error!',
													data.value + '.',
													'error'
												)
											}

											if (data.type == "success") {
												equivalent.val(data.equivalent);
												equivalent.parents(".equivalent").siblings(".remarks").html(data.remarks);
												equivalent.parents(".equivalent").siblings(".units").html(data.units);
												equivalent.parents(".equivalent").parents("tr").next("tr").children(".equivalent").children("input").select();
												
											}							
										}
									});
								} else {
									Swal.fire(
										'Error!',
										'Invalid input.',
										'error'
									)
								}
							}
						});
					}
				});
			}
		);
							
	});
</script>