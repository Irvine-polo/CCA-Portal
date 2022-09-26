<?php

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "faculty");

$username = $_SESSION["username"];

?>
<?php 
//UPDATE EVALUATION-------
$sql = $conn->query("SELECT * FROM evaluation_set WHERE status <>'completed' order by date_created ASC");
$current_date = date('Y-m-d');
while ($data = $sql->fetch_assoc()) {
	if ($current_date < $data['start_date']) {
		$id = $data['id'];
		$status = 'pending';
		$update = $conn->query("UPDATE evaluation_set SET status = '$status' WHERE id = '$id'");
	}
	elseif ($data['start_date'] <= $current_date && $data['status'] == 'pending' ) {
		$id = $data['id'];
		$title = $data['title'];
		$end_date = $data['end_date'];
		$status = 'active';
		$update = $conn->query("UPDATE evaluation_set SET status = '$status' WHERE id = '$id' AND status = 'pending' ");
		//notifications insert
		$title_notif = "Evaluation for ".$title;
		$exists = $conn->query("SELECT title FROM notifications WHERE title = '$title_notif'")->num_rows;
		if ($exists == 0) {
			$call_faculty_sql = $conn->query("SELECT * FROM users WHERE role <> 'student' AND role <> 'hr'");
			while($row = $call_faculty_sql->fetch_assoc()){
				$username = $row['username'];
				$title = $title_notif;
				$description = "<b>".$title."</b><p> Go to Evaluate Faculty tab and click evaluate. This Evaluation Ends on ".$end_date."</p>";
				$createdAt = date("Y-m-d H:i:s", time());
				$hasSeen = 0;

				$insert = $conn->query("INSERT INTO notifications(username, title, description, created_at, has_seen)VALUES('$username','$title','$description','$createdAt','$hasSeen')");
			}
		}
	}
	elseif ($current_date >= $data['end_date'] && $data['status'] == 'active') {
		$id = $data['id'];

		$status = 'completed';
		$update = $conn->query("UPDATE evaluation_set SET date_completed = '$current_date', status = '$status' WHERE id = '$id' AND status = 'active'");
	}
}
//UPDATE SHARE RESULT----------------------------
 $current_date2 = date('Y-m-d');
	$sql2 = $conn->query("SELECT * FROM evaluation_set WHERE status = 'completed' AND start_share <> '0000-00-00'  order by date_created DESC");
	while ($data2 = $sql2->fetch_assoc()) {
		if ($current_date2 >= $data2['start_share'] ) {
			$title = $data2['title'];
			$visible = 1;
			$update = $conn->query("UPDATE evaluation_set SET visible = '$visible' WHERE title = '$title'");

			//NOTIFICATION
			$title_notif = "Evaluation for ".$title." results is now completed.";
			$exists = $conn->query("SELECT title FROM notifications WHERE title = '$title_notif'")->num_rows;
			if ($exists == 0) {
				$call_faculty_sql = $conn->query("SELECT * FROM users WHERE role <> 'student' AND role <> 'hr'");
				while($row = $call_faculty_sql->fetch_assoc()){
					$username = $row['username'];
					$title = $title_notif;
					$description = "<b>".$title."</b><p> is now completed. Go to Evaluation Results tab to view results.</p>";
					$createdAt = date("Y-m-d H:i:s", time());
					$hasSeen = 0;
					$insert = $conn->query("INSERT INTO notifications(username, title, description, created_at, has_seen)VALUES('$username','$title','$description','$createdAt','$hasSeen')");
					}
			}
		}
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="theme-color" content="#4F6932">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="Jimwel and Irvine">
	<meta name="keywords" content="CCA Portal, City College of Angeles Portal, City College of Angeles, Portal">
	<meta name="description" content="The City College of Angeles is committed to offer quality education for the holistic development of competitive and technically-capable professionals with deep sense of excellence, resiliency, stewardship, and patrimony.">

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://portal.cca.edu.ph">
	<meta property="og:title" content="City College of Angeles - Totalis Humanae">
	<meta property="og:description" content="The City College of Angeles is committed to offer quality education for the holistic development of competitive and technically-capable professionals with deep sense of excellence, resiliency, stewardship, and patrimony.">
	<meta property="og:image" content="https://portal.cca.edu.ph/assets/images/photos/thumbnail.png">

	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="https://portal.cca.edu.ph">
	<meta property="twitter:title" content="City College of Angeles - Totalis Humanae">
	<meta property="twitter:description" content="The City College of Angeles is committed to offer quality education for the holistic development of competitive and technically-capable professionals with deep sense of excellence, resiliency, stewardship, and patrimony.">
	<meta property="twitter:image" content="https://portal.cca.edu.ph/assets/images/photos/thumbnail.png">
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/x-icon" href="<?= $baseUrl; ?>assets/images/icons/favicon.ico">
	<title><?= $title; ?></title>
	<!-- BOOTSTRAP CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
	<!-- ADMIN KIT CSS -->
	<link href="<?= $baseUrl; ?>assets/css/app.css" rel="stylesheet">
	<!-- DATATABLES BOOTSTRAP CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
	<!-- FONTAWESOME CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<!-- MAIN CSS -->
	<link href="<?= $baseUrl; ?>assets/css/main.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap">
</head>
<body>
	<div class="wrapper">
		<nav class="sidebar js-sidebar user-select-none d-print-none" id="sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand d-flex flex-column align-items-center text-center" href="<?= $baseUrl; ?>faculty">
					<img class="pe-none w-40" src="<?= $baseUrl; ?>assets/images/photos/cca-logo.png">
					<span class="align-middle">City College of Angeles</span>
				</a>

				<ul class="sidebar-nav">
					<li class="sidebar-item <?= page("classSchedules", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>faculty">
							<i class="fa-solid fa-calendar-week align-middle"></i>
							<span class="align-middle">Class Schedules</span>
						</a>
					</li>

					<li class="sidebar-item <?= page("studentGrades", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>faculty/student-grades">
							<i class="fa-solid fa-star align-middle"></i>
							<span class="align-middle">Student Grades</span>
						</a>
					</li>

					<li class="sidebar-item <?= page("evaluation_result", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>faculty/evaluation/result">
							<i class="fa fa-area-chart"></i>
							<span class="align-middle">Evaluation Result</span>
						</a>
					</li>

					<li class="sidebar-item <?= page("evaluation-tab", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>faculty/evaluation-tab">
							<i class="fa-solid fa-chart-pie align-middle"></i>
							<span class="align-middle">Evaluate Faculty</span>
						</a>
					</li>
				</ul>
			</div>
		</nav>

		<div class="main bg-phoenix">
			<nav class="navbar navbar-expand navbar-light navbar-bg d-print-none bg-white-85">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>

									<?php

									$sql = "SELECT * FROM notifications WHERE username = '$username' AND has_seen = 0";
									$result = mysqli_query($conn, $sql);
									
									if (mysqli_num_rows($result) > 0) {
										if (mysqli_num_rows($result) > 4) {
											echo "<span class='indicator'>4+</span>";
										} else {
											echo "<span class='indicator'>" . mysqli_num_rows($result) . "</span>";
										}
									}

									?>

								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									Notifications
								</div>
								<div class="list-group">
									
									<?php

									$sql = "SELECT * FROM notifications WHERE username = '$username' ORDER BY id DESC LIMIT 4";
									$result = mysqli_query($conn, $sql);
									
									if (mysqli_num_rows($result) > 0) {
										while ($row = mysqli_fetch_assoc($result)) {
											if ($row["has_seen"] == 0) {
												echo "<a href='" . $baseUrl . "assets/includes/faculty/notification.inc.php?viewNotification&notificationId=" . $row["id"] . "' class='list-group-item fw-bold'>
													<div class='row g-0 align-items-center'>
														<div class='col-2'>
															<i class='text-primary' data-feather='bell'></i>
														</div>
														<div class='col-10'>
															<div class='text-dark'>" . $row["title"] . "</div>
															<div class='text-muted small mt-1'>" . $row["description"] . "</div>
															<div class='text-muted small mt-1'>" . date('M d, Y | g:iA', strtotime($row["created_at"])) . "</div>
														</div>
													</div>
												</a>";
											} else {
												echo "<a href='" . $baseUrl . "assets/includes/faculty/notification.inc.php?viewNotification&notificationId=" . $row["id"] . "' class='list-group-item'>
													<div class='row g-0 align-items-center'>
														<div class='col-2'>
															<i class='text-primary' data-feather='bell'></i>
														</div>
														<div class='col-10'>
															<div class='text-dark'>" . $row["title"] . "</div>
															<div class='text-muted small mt-1'>" . $row["description"] . "</div>
															<div class='text-muted small mt-1'>" . date('M d, Y | g:iA', strtotime($row["created_at"])) . "</div>
														</div>
													</div>
												</a>";
											}
										}
									} else {
										echo "<div class='list-group-item text-center'>
											No Notifications to show.
										</div>";
									}

									?>

								</div>
								<div class="dropdown-menu-footer">
									<a href="<?= $baseUrl; ?>faculty/view/notifications" class="text-muted">Show all notifications</a>
								</div>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" data-bs-toggle="dropdown">
								<i class="align-middle" data-feather="settings"></i>
							</a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block user-select-none" data-bs-toggle="dropdown">
								
								<?php

								$usersId = $_SESSION["user_id"];

								$sql = "SELECT * FROM users WHERE id = $usersId";
								$result = mysqli_query($conn, $sql);

								if (mysqli_num_rows($result) > 0) {

									while ($row = mysqli_fetch_assoc($result)) {

										$firstname = $row["firstname"];
										$middlename = $row["middlename"];
										$lastname = $row["lastname"];

										if ($middlename != "") {
											$middlename = substr($row["middlename"], 0, 1) . ".";
										}

										$fullname = $firstname . " " . $middlename . " " . $lastname;

										echo "<img src='" . $baseUrl . "assets/uploads/avatars/" . $row["avatar"] . "' class='avatar img-fluid rounded pe-none me-1' alt='" . $row["firstname"] . "' style='object-fit: cover;'> <span class='text-dark'>" . $fullname . "</span>";

									}

								}

								?>
								
							</a>

							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="<?= $baseUrl; ?>faculty/profile">
									<i class="align-middle me-1" data-feather="user"></i> 
									Profile
								</a>
								<a class="dropdown-item" href="<?= $baseUrl; ?>assets/includes/sessions.inc.php?signOut">
									<i class="align-middle me-1" data-feather="log-out"></i> 
									Log out
								</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">