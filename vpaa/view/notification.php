<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "notifications";

include $baseUrl . "assets/templates/vpaa/header.inc.php";

?>

<h1 class="h3 mb-3">View Notification</h1>

<div class="row">
	<div class="col-md-6 offset-md-3">
		<div class="card">
			<div class="card-body">
				<div class="list-group mb-3">

					<?php

					$username = $_SESSION["username"];
					$notificationId = sanitize($_GET["notificationId"]);

					$sql = "SELECT * FROM notifications WHERE username = '$username' AND id = $notificationId";
					$result = mysqli_query($conn, $sql);

					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<a class='list-group-item'>
								<div class='row g-0 align-items-center'>
									<div class='col-10'>
										<div class='text-dark'>" . $row["title"] . "</div>
										<div class='text-muted small mt-1'>" . $row["description"] . "</div>
										<div class='text-muted small mt-1'>" . date('M d, Y | g:iA', strtotime($row["created_at"])) . "</div>
									</div>
								</div>
							</a>";
						}
					}

					?>

				</div>

				<div class="text-center">
					<a class="btn btn-main btn-lg" href="<?= $baseUrl; ?>vpaa/view/notifications">Show all</a>
				</div>
			</div>
		</div>
	</div>
</div>
		

<?php

include $baseUrl . "assets/templates/vpaa/footer.inc.php";

?>