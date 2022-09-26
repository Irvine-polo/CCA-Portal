<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "application";

include $baseUrl . "assets/templates/home/header.inc.php";

?>

<div class="px-md-4 py-5">
	<div class="container">

		<?php

		if (isset($_SESSION["controlNumber"])) {
			header("Location: ./edit/application");
			exit();
		} else {
			echo "<form class='form-login card bg-white-85 border-bottom-main px-3 py-4 mb-0 mx-auto' id='form'>
				<div class='card-body'>
					<div class='text-center mb-3'>
						<img class='pe-none w-30' src='../assets/images/photos/cca-logo.png'>
						<h3 class='user-select-none'>City College of Angeles</h3>
					</div>

					<div id='alertWrapper'></div>

					<div class='mb-3'>
						<label>Email Address</label>
						<div class='input-group'>
							<span class='input-group-text'>
								<i class='fa-solid fa-envelope'></i>
							</span>
							<input class='form-control form-control-lg' type='text' name='username' required>
						</div>
					</div>

					<div class='mb-3'>
						<label>Password</label>
						<div class='input-group'>
							<span class='input-group-text'>
								<i class='fa-solid fa-lock'></i>
							</span>
							<input class='form-control form-control-lg password' type='password' name='password' required>
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
						<button class='btn btn-main btn-lg' id='submitButton' type='submit'>Submit</button>
					</div>
				</div>
			</form>";
		}

		?>

	</div>
</div>

<?php

include $baseUrl . "assets/templates/home/footer.inc.php";

?>

<script type="text/javascript">
	$(document).ready(function() { 
		$('#form').submit(function(e) {	
			e.preventDefault();

			$.ajax({
				url: "../assets/includes/home/freshmen-applicant.inc.php",
				type: "POST",
				data: $('#form').serialize() + "&submitSignInApplicant",
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