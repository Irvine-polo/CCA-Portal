<?php

$baseUrl = "../";

$title = "City College of Angeles - Totalis Humanae";
$page = "dashboard";

include $baseUrl . "assets/templates/admin/header.inc.php";

?>

<h1 class="h3 mb-3">Dashboard</h1>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col mt-0">
						<h5 class="card-title">Users</h5>
					</div>

					<div class="col-auto">
						<div class="stat text-brown">
							<i class="fa-solid fa-users align-middle"></i>
						</div>
					</div>
				</div>

				<?php

				$sql = "SELECT * FROM users WHERE is_active = 1";
				$result = mysqli_query($conn, $sql);
				
				echo "<h1 class='display-6 text-center mt-3 mb-0'>" . mysqli_num_rows($result) . "</h1>";

				?>

			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col mt-0">
						<h5 class="card-title">Students</h5>
					</div>

					<div class="col-auto">
						<div class="stat text-brown">
							<i class="fa-solid fa-user-graduate align-middle"></i>
						</div>
					</div>
				</div>
				
				<?php

				$sql = "SELECT * FROM users WHERE role = 'student' AND is_active = 1";
				$result = mysqli_query($conn, $sql);
				
				echo "<h1 class='display-6 text-center mt-3 mb-0'>" . mysqli_num_rows($result) . "</h1>";

				?>

			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col mt-0">
						<h5 class="card-title">Faculty</h5>
					</div>

					<div class="col-auto">
						<div class="stat text-brown">
							<i class="fa-solid fa-chalkboard-user align-middle"></i>
						</div>
					</div>
				</div>
				
				<?php

				$sql = "SELECT * FROM users WHERE role = 'faculty' AND is_active = 1";
				$result = mysqli_query($conn, $sql);
				
				echo "<h1 class='display-6 text-center mt-3 mb-0'>" . mysqli_num_rows($result) . "</h1>";

				?>

			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col mt-0">
						<h5 class="card-title">Deans</h5>
					</div>

					<div class="col-auto">
						<div class="stat text-brown">
							<i class="fa-solid fa-user-tie align-middle"></i>
						</div>
					</div>
				</div>
				
				<?php

				$sql = "SELECT * FROM users WHERE role = 'dean' AND is_active = 1";
				$result = mysqli_query($conn, $sql);
				
				echo "<h1 class='display-6 text-center mt-3 mb-0'>" . mysqli_num_rows($result) . "</h1>";

				?>

			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col mt-0">
						<h5 class="card-title">Coordinators</h5>
					</div>

					<div class="col-auto">
						<div class="stat text-brown">
							<i class="fa-solid fa-user-gear align-middle"></i>
						</div>
					</div>
				</div>
				
				<?php

				$sql = "SELECT * FROM users WHERE role = 'coordinator' AND is_active = 1";
				$result = mysqli_query($conn, $sql);
				
				echo "<h1 class='display-6 text-center mt-3 mb-0'>" . mysqli_num_rows($result) . "</h1>";

				?>

			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col mt-0">
						<h5 class="card-title">Registrars</h5>
					</div>

					<div class="col-auto">
						<div class="stat text-brown">
							<i class="fa-solid fa-user-gear align-middle"></i>
						</div>
					</div>
				</div>
				
				<?php

				$sql = "SELECT * FROM users WHERE role = 'registrar' AND is_active = 1";
				$result = mysqli_query($conn, $sql);
				
				echo "<h1 class='display-6 text-center mt-3 mb-0'>" . mysqli_num_rows($result) . "</h1>";

				?>

			</div>
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/admin/footer.inc.php";

?>