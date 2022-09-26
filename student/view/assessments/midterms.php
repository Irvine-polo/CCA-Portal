<?php

$baseUrl = "../../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "classSchedules";

include $baseUrl . "assets/templates/student/header.inc.php";

?>

<?php

$studentNumber = $_SESSION["username"];
$classCode = sanitize($_GET["classCode"]);
$subjectCode = sanitize($_GET["subjectCode"]);

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">View Assessments</h1>

	<a class="btn btn-primary" href="../../">Back</a>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="list-group">

					<?php

					echo "<a class='list-group-item list-group-item-action active' href='./midterms?classCode=" . $classCode . "&subjectCode=" . $subjectCode . "'>Midterms</a>
					<a class='list-group-item list-group-item-action' href='./finals?classCode=" . $classCode . "&subjectCode=" . $subjectCode . "'>Finals</a>
					<a class='list-group-item list-group-item-action' href='./summary?classCode=" . $classCode . "&subjectCode=" . $subjectCode . "'>Summary</a>";

					?>
					
				</div>	
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered table-border-dark table-striped table-sm text-center w-100">
						<thead>
							<tr>
								<th class="bg-gray-100" colspan="100%">Class Standing</th>
							</tr>
							<tr>
								<th width="10%">Total</th>
								<th>20</th>
								<th>50</th>
								<th>20</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<th>Score</th>
								<td>15</td>
								<td>40</td>
								<td>15</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="table-responsive">
					<table class="table table-bordered table-border-dark table-striped table-sm text-center w-100">
						<thead>
							<tr>
								<th class="bg-gray-100" colspan="100%">Exam</th>
							</tr>
							<tr>
								<th width="10%">Total</th>
								<th>50</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<th>Score</th>
								<td>35</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="table-responsive">
					<table class="table table-bordered table-border-dark table-striped table-sm text-center w-100 mb-0">
						<thead>
							<tr>
								<th class="bg-gray-100" colspan="100%">Midterm Grade</th>
							</tr>
							<tr>
								<th width="25%">Midterm Grade</th>
								<th width="25%">Percentage Grade</th>
								<th width="25%">Equivalent</th>
								<th width="25%">Remarks</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>88.50</td>
								<td>90.00</td>
								<td>1.75</td>
								<td>PASSED</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/student/footer.inc.php";

?>