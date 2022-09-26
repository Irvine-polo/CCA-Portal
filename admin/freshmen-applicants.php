<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "freshmenApplicants";

include $baseUrl . "assets/templates/admin/header.inc.php";

?>

<h1 class="h3 mb-3">Freshmen Applicants</h1>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<h3 class='text-center mb-3'>Profiles</h3>

				<hr>

				<div class="row g-1">
					<div class="col-md-4">
						<div class="d-grid">
							<a class="btn btn-info btn-sm" href="./view/freshmen-applicant-profiles">
								<i class="fa-solid fa-eye"></i>
							</a> 
						</div>
					</div>

					<div class="col-md-4">
						<div class="d-grid">
							<a class="btn btn-success btn-sm" href="./import/freshmen-applicant-profiles">
								<i class="fa-solid fa-upload"></i>
							</a>
						</div>
					</div>

					<div class="col-md-4">
						<div class="d-grid">
							<a class="btn btn-primary btn-sm" href="">
								<i class="fa-solid fa-plus"></i>
							</a> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<h3 class='text-center mb-3'>Educational Backgrounds</h3>

				<hr>

				<div class="row g-1">
					<div class="col-md-4">
						<div class="d-grid">
							<a class="btn btn-info btn-sm" href="./view/freshmen-applicant-educational-backgrounds">
								<i class="fa-solid fa-eye"></i>
							</a> 
						</div>
					</div>

					<div class="col-md-4">
						<div class="d-grid">
							<a class="btn btn-success btn-sm" href="./import/freshmen-applicant-educational-backgrounds">
								<i class="fa-solid fa-upload"></i>
							</a>
						</div>
					</div>

					<div class="col-md-4">
						<div class="d-grid">
							<a class="btn btn-primary btn-sm" href="">
								<i class="fa-solid fa-plus"></i>
							</a> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<h3 class='text-center mb-3'>Emergency Informations</h3>

				<hr>

				<div class="row g-1">
					<div class="col-md-4">
						<div class="d-grid">
							<a class="btn btn-info btn-sm" href="./view/freshmen-applicant-emergency-informations">
								<i class="fa-solid fa-eye"></i>
							</a> 
						</div>
					</div>

					<div class="col-md-4">
						<div class="d-grid">
							<a class="btn btn-success btn-sm" href="./import/freshmen-applicant-emergency-informations">
								<i class="fa-solid fa-upload"></i>
							</a>
						</div>
					</div>

					<div class="col-md-4">
						<div class="d-grid">
							<a class="btn btn-primary btn-sm" href="">
								<i class="fa-solid fa-plus"></i>
							</a> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/admin/footer.inc.php";

?>