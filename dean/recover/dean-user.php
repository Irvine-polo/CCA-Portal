<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "deanUsers";

include $baseUrl . "assets/templates/dean/header.inc.php";

?>

<div class="d-flex justify-content-between align-items-center d-print-none mb-3">
	<h1 class="h3 mb-0">Recover User</h1>

	<a class="btn btn-primary d-flex justify-content-between align-items-center" href="../dean-users">
		<i class="fa-solid fa-chevron-left me-2"></i>
		Back
	</a>
</div>

<div class="row">
	<div class="col-md-6 offset-md-3">
		<div class="card">
			<div class="card-body">
				<div class="mb-3">
					<label>Username</label>
					<input class="form-control form-control-lg" type="text" value="<?= value("username"); ?>">
				</div>

				<div class="mb-3">
					<label>Initial Password</label>
					<input class="form-control form-control-lg" type="text" value="<?= value("initialPassword"); ?>">
				</div>

				<?php

				$account = "Username: " . sanitize($_GET["username"]) . "\r\nInitial Password: " . sanitize($_GET["initialPassword"]);

				?>

				<textarea class="d-none" id="account"><?= $account; ?></textarea>

				<div class="text-center">
					<button class="btn btn-main btn-lg" onclick="copyAccount()">Copy Account</button>
				</div>
			</div>
		</div>	
	</div>
</div>

<?php

include $baseUrl . "assets/templates/dean/footer.inc.php";

?>

<script type="text/javascript">
	function copyAccount() {
		/* Get the text field */
		var copyText = document.getElementById("account");

		/* Select the text field */
		copyText.select();
		copyText.setSelectionRange(0, 99999); /* For mobile devices */

		/* Copy the text inside the text field */
		navigator.clipboard.writeText(copyText.value);

		/* Alert the copied text */
		Swal.fire(
			'Success!',
			'User Account Copied.',
			'success'
		)
	}
</script>