<?php

$baseUrl = "../../../";

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "vpaa");

if (isset($_GET["viewNotification"])) {
	$notificationId = sanitize($_GET["notificationId"]);

	$sql = "UPDATE notifications SET has_seen = 1 WHERE id = $notificationId";
	
	if (!mysqli_query($conn, $sql)) {
		header("Location: " . $baseUrl . "vpaa/view/notification?notificationId=" . $notificationId . "error=Update <b>NOTIFICATION STATUS</b> error");
		exit();
	}

	header("Location: " . $baseUrl . "vpaa/view/notification?notificationId=" . $notificationId);
	exit();
}

if (isset($_POST["loadMoreNotifications"])) {
	$username = $_SESSION["username"];
	$start = sanitize($_POST["start"]);
	$limit = sanitize($_POST["limit"]);

	$sql = "SELECT * FROM notifications WHERE username = '$username' ORDER BY id DESC LIMIT $start, $limit";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			if ($row["has_seen"] == 0) {
				echo "<a href='../../assets/includes/vpaa/notification.inc.php?viewNotification&notificationId=" . $row["id"] . "' class='list-group-item fw-bold'>
					<div class='row g-0 align-items-center'>
						<div class='col-10'>
							<div class='text-dark'>" . $row["title"] . "</div>
							<div class='text-muted small mt-1'>" . $row["description"] . "</div>
							<div class='text-muted small mt-1'>" . date('M d, Y | g:iA', strtotime($row["created_at"])) . "</div>
						</div>
					</div>
				</a>";
			} else {
				echo "<a href='../../assets/includes/vpaa/notification.inc.php?viewNotification&notificationId=" . $row["id"] . "' class='list-group-item'>
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
	}
}