<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "deanUsers";

include $baseUrl . "assets/templates/dean/header.inc.php";

?>

<?php

$sql = "SELECT * FROM users WHERE role = 'vpaa' OR role = 'hr' OR role = 'dean' OR role = 'coordinator' OR role = 'faculty' OR role = 'registrar' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$latestReferenceNumberTaken = $row["username"];
	}
}	

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Add User</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" onclick="history.back()">
		<i class="fa-solid fa-chevron-left me-2"></i>
		Back
	</a>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="mb-0">
					<label>Latest Reference Number taken</label>
					<input class="form-control form-control-lg" type="text" value="<?= $latestReferenceNumberTaken; ?>" disabled>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<form class="card" action="../../assets/includes/dean/dean-user.inc.php" method="POST" autocomplete="off">
			<div class="card-body">

				<?php

				if (isset($_GET["username"], $_GET["initialPassword"])) {
					echo "<div class='mb-3'>
						<label>Username</label>
						<input class='form-control form-control-lg' type='text' value='" . value('username') . "'>
					</div>

					<div class='mb-3'>
						<label>Initial Password</label>
						<input class='form-control form-control-lg' type='text' value='" . value('initialPassword') . "'>
					</div>";
				} else {
					echo "<div class='row'>
						<div class='col-md-6'>
							<div class='mb-3'>
								<label>Institute</label>
								<input class='form-control form-control-lg' name='institute' value='" . strtoupper($_SESSION["institute"]) . "' required readonly>
							</div>
						</div>

						<div class='col-md-6'>
							<div class='mb-3'>
								<label>Role</label>
								<select class='form-select form-select-lg' name='role' required>
									<option value='' selected disabled>--Select Role--</option>
									<option value='faculty'>Faculty</option>
									<option value='coordinator'>Coordinator</option>
								</select>
							</div>
						</div>
					</div>

					<div class='row'>
						<div class='col-md-4'>
							<div class='mb-3'>
								<label>Username</label>
								<input class='form-control form-control-lg' data-type='number' type='text' name='username' value='CCA-" . str_pad((intval(substr($latestReferenceNumberTaken, 4)) + 1), 4, '0', STR_PAD_LEFT) . "' readonly>
							</div>
						</div>

						<div class='col-md-8'>
							<div class='mb-3'>
								<label>Email Address</label>
								<input class='form-control form-control-lg' type='email' name='emailAddress' value='' required>
							</div>
						</div>
					</div>

					<div class='mb-3'>
						<label>First Name</label>
						<input class='form-control form-control-lg' name='firstname' required>
					</div>

					<div class='row'>
						<div class='col-md-6'>
							<div class='mb-3'>
								<label>Middle Name</label>
								<input class='form-control form-control-lg' name='middlename'>
							</div>
						</div>

						<div class='col-md-6'>
							<div class='mb-3'>
								<label>Last Name</label>
								<input class='form-control form-control-lg' name='lastname' required>
							</div>
						</div>
					</div>

					<div class='mb-3'>
						<label class='form-check user-select-none'>
							<input class='form-check-input' type='checkbox' required>
							<span class='form-check-label'>Verify</span>
						</label>
					</div>

					<div class='text-center'>
						<button class='btn btn-success btn-lg' type='submit' name='submitAddUser'>
							Submit
						</button>
					</div>";
				}

				?>
				
			</div>
		</form>	
	</div>
</div>

<?php

include $baseUrl . "assets/templates/dean/footer.inc.php";

?>