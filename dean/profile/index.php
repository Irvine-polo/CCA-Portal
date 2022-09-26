<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "profile";

include $baseUrl . "assets/templates/dean/header.inc.php";

?>

<?php

$userId = $_SESSION["user_id"];

$sql = "SELECT * FROM users WHERE id = $userId";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		echo "<div class='d-flex justify-content-between align-items-center mb-3'>
			<h1 class='h3 mb-0'>Profile</h1>

			<h6 class='mb-0'><span class='fw-bold'>Last Login: </span>" . date('M j, Y - g:iA', strtotime($row["last_login"])) . "</h6>
		</div>

		<div class='row'>
			<div class='col-md-4'>
				<div class='card'>
					<div class='card-body'>
						<div class='list-group'>
							<a class='list-group-item list-group-item-action active' href='./'>Profile</a>
							<a class='list-group-item list-group-item-action' href='./change-password'>Change Password</a>
						</div>	
					</div>
				</div>
			</div>

			<div class='col-md-8'>
				<form class='card' action='../../assets/includes/dean/profile.inc.php' method='POST' enctype='multipart/form-data' autocomplete='off'>
					<div class='card-body'>
						<div class='row'>
							<div class='col-6 offset-3 col-md-4 offset-md-4'>
								<div class='d-flex flex-column justify-content-center align-items-center mb-3'>
									<div class='w-100'>
										<div class='ratio ratio-1x1 mb-2'>
											<img class='rounded object-fit-cover pe-none w-100' id='avatar' src='../../assets/uploads/avatars/" . $row["avatar"] . "'>
										</div>

										<input class='form-control form-control-sm' id='inputAvatar' type='file' accept='.png, .jpg, .jpeg' name='avatar'>
									</div>
								</div>
							</div>
						</div>

						<div class='row'>
							<div class='col-md-6'>
								<div class='mb-3'>
									<label>First Name</label>
									<input class='form-control form-control-lg' type='text' name='firstname' value='" . $row["firstname"] . "' required>
								</div>
							</div>

							<div class='col-md-3'>
								<div class='mb-3'>
									<label>Middle Name</label>
									<input class='form-control form-control-lg' type='text' name='middlename' value='" . $row["middlename"] . "'>
								</div>
							</div>

							<div class='col-md-3'>
								<div class='mb-3'>
									<label>Last Name</label>
									<input class='form-control form-control-lg' type='text' name='lastname' value='" . $row["lastname"] . "' required>
								</div>
							</div>
						</div>

						<div class='text-center'>
							<button class='btn btn-success btn-lg' type='submit' name='submitUpdateProfile'>Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>";
	}
}

?>

<?php

include $baseUrl . "assets/templates/dean/footer.inc.php";

?>

<script type="text/javascript">
	const avatar = document.querySelector("#avatar");
	const inputAvatar = document.querySelector("#inputAvatar");

	inputAvatar.addEventListener("change", function() {
		const file = this.files[0];

		if (file) {
			const reader = new FileReader();

			reader.addEventListener("load", function() {
				avatar.setAttribute("src", this.result);
			});

			reader.readAsDataURL(file);
		}
	});
</script>