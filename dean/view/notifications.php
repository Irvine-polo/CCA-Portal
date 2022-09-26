<?php

$baseUrl = "../../";

$title = "City College of Angeles - Totalis Humanae";
$page = "notifications";

include $baseUrl . "assets/templates/dean/header.inc.php";

?>

<h1 class="h3 mb-3">View Notifications</h1>


<div class="row">
	<div class="col-md-6 offset-md-3">
		<div class="card">
			<div class="card-body">
				<div class="list-group mb-3" id="data"></div>

				<div class="text-center">
					<button class="btn btn-main btn-lg" id="loadMoreNotifications">Load More</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

include $baseUrl . "assets/templates/dean/footer.inc.php";

$username = $_SESSION["username"];

$sql = "SELECT * FROM notifications WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

$notificationsCount = mysqli_num_rows($result);

?>

<input type="hidden" id="notificationsCount" value="<?= $notificationsCount; ?>">

<script type="text/javascript">
	let notificationsCount = parseInt($("#notificationsCount").val());

	let start = 0;
	let limit = 5;

	$(document).ready(function() {
		$.ajax({
			url: "../../assets/includes/dean/notification.inc.php",
			type: "POST",
			data: {
				loadMoreNotifications: "",
				start: start,
				limit: limit
			},
			dataType: "text",
			beforeSend: function() {
				$("#loadMoreNotifications").prop("disabled", true);
				$("#loadMoreNotifications").html(`<span class="spinner-grow spinner-grow-sm"></span> Loading..`);
			},
			success: function(data) {
				if (data != "") {
					$("#loadMoreNotifications").prop("disabled", false);
					$("#loadMoreNotifications").html(`Load more`);
					$("#data").append(data);
					start += limit;
				}

				if (start >= notificationsCount) {
					$("#loadMoreNotifications").prop("disabled", true);
					$("#loadMoreNotifications").html(`No more notifications`);
				}

				if ($("#data").html() == "") {
					$("#data").html(
						`<div class='list-group-item text-center'>
							No Notifications to show.
						</div>`
					);
				}
			}
		});

		$('#loadMoreNotifications').click(function(e) {
			$.ajax({
				url: "../../assets/includes/dean/notification.inc.php",
				type: "POST",
				data: {
					loadMoreNotifications: "",
					start: start,
					limit: limit
				},
				dataType: "text",
				beforeSend: function() {
					$("#loadMoreNotifications").prop("disabled", true);
					$("#loadMoreNotifications").html(`<span class="spinner-grow spinner-grow-sm"></span> Loading..`);
				},
				success: function(data) {
					if (data != "") {
						$("#loadMoreNotifications").prop("disabled", false);
						$("#loadMoreNotifications").html(`Load more`);
						$("#data").append(data);
						start += limit;
					}

					if (start >= notificationsCount) {
						$("#loadMoreNotifications").prop("disabled", true);
						$("#loadMoreNotifications").html(`No more notifications`);
					}
				}
			});
		});
	});
</script>