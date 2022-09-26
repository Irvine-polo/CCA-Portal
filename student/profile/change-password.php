<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "profile";

include $baseUrl . "assets/templates/student/header.inc.php";

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
							<a class='list-group-item list-group-item-action' href='./'>Profile</a>
							<a class='list-group-item list-group-item-action active' href='./change-password'>Change Password</a>
						</div>	
					</div>
				</div>
			</div>

			<div class='col-md-8'>
				<form class='card' action='../../assets/includes/student/profile.inc.php' method='POST' enctype='multipart/form-data'>
					<div class='card-body'>
						<div class='mb-3'>
							<label>Current Password</label>
							<div class='input-group'>
								<span class='input-group-text'>
									<i class='fa-solid fa-lock'></i>
								</span>
								<input class='form-control form-control-lg password' type='password' name='currentPassword' required>
							</div>
						</div>

						<div class='mb-3'>
							<label>
								New Password
								<i class='fa-solid fa-circle-info text-info' data-bs-toggle='tooltip' data-bs-placement='right' data-bs-html='true' title='Password must contain:<br><ul><li>at least 8 characters</li><li>an uppercase letter</li><li>a lowercase letter</li><li>a number</li></ul>'></i>
							</label>
							<div class='input-group'>
								<span class='input-group-text'>
									<i class='fa-solid fa-lock'></i>
								</span>
								<input class='form-control form-control-lg password' type='password' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}' name='newPassword' required>
							</div>
						</div>

						<div class='mb-3'>
							<label>Confirm New Password</label>
							<div class='input-group'>
								<span class='input-group-text'>
									<i class='fa-solid fa-lock'></i>
								</span>
								<input class='form-control form-control-lg password' type='password' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}' name='confirmNewPassword' required>
							</div>
						</div>

						<div class='mb-3 user-select-none' id='showPassword'>
							<label class='form-check'>
								<input class='form-check-input' type='checkbox'>
								<span class='form-check-label'>
									Show password
								</span>
							</label>
						</div>

						<div class='text-center'>
							<button class='btn btn-success btn-lg' type='submit' name='submitChangePassword'>Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>";
	}
}

?>

<?php

include $baseUrl . "assets/templates/student/footer.inc.php";

?>

<script type="text/javascript">
	$("#showPassword").click(function(){
		if ($("#showPassword input").is(":checked")) {
			$(".password").attr("type", "text");
		} else {
			$(".password").attr("type", "password");
		}
	});
</script>