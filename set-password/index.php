<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "signIn";

include $baseUrl . "assets/templates/set-password/header.inc.php";

?>

<div class="px-md-4 py-5">
	<div class="container">
		<form class="form-login card bg-white-85 border-bottom-main px-3 py-4 mb-0 mx-auto" id="form">
			<div class="card-body">
				<div class="text-center mb-3">
					<img class="pe-none w-30" src="../assets/images/photos/cca-logo.png">
					<h3 class="user-select-none">City College of Angeles</h3>
				</div>

				<div id="alertWrapper"></div>

				<div class="mb-3">
					<label class="form-label">
						Password						
						<i class="fa-solid fa-circle-info text-info" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-html="true" title="Password must contain:<br><ul><li>at least 8 characters</li><li>an uppercase letter</li><li>a lowercase letter</li><li>a number</li></ul>"></i>
					</label>
					<div class="input-group">
						<span class="input-group-text">
							<i class="fa-solid fa-lock"></i>
						</span>
						<input class="form-control form-control-lg password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="password" required>
					</div>
				</div>

				<div class="mb-3">
					<label>Confirm Password</label>
					<div class="input-group">
						<span class="input-group-text">
							<i class="fa-solid fa-lock"></i>
						</span>
						<input class="form-control form-control-lg password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="confirmPassword" required>
					</div>
				</div>

				<div class="mb-3 user-select-none" id="showPassword">
					<label class="form-check">
						<input class="form-check-input" type="checkbox">
						<span class="form-check-label">
							Show password
						</span>
					</label>
				</div>

				<div class="text-center">
					<button class="btn btn-main btn-lg" id="submitButton" type="submit">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/set-password/footer.inc.php";

?>

<script type="text/javascript">
	$(document).ready(function() { 
		$('#form').submit(function(e) {	
			e.preventDefault();

			$.ajax({
				url: "../assets/includes/sessions.inc.php",
				type: "POST",
				data: $('#form').serialize() + "&submitSetPassword",
				dataType: "json",
				beforeSend: function(data) {
					$('#alertWrapper').html(``);
					$("#submitButton").prop("disabled", true);
					$("#submitButton").html(`<span class="spinner-grow spinner-grow-sm"></span> Loading..`);
				},
				success: function(data) {
					console.log();
					if (data.type == "error") {
						$('#alertWrapper').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong>Error!</strong> ${data.value}.
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>`);

						$("#submitButton").prop("disabled", false);
						$("#submitButton").html(`Submit`);
					}

					if (data.type == "redirect") {
						window.location.href = `../${data.value}`;
					}
				}
			});

			return false;
		});
	});

	$("#showPassword").click(function(){
		if ($("#showPassword input").is(":checked")) {
			$(".password").attr("type", "text");
		} else {
			$(".password").attr("type", "password");
		}
	});
</script>