<?php

include $baseUrl . "assets/includes/dbh.inc.php";

allowedRole($baseUrl, "admin");

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
	<!-- FANCYAPPS CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
	<!-- FONTAWESOME CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<!-- MAIN CSS -->
	<link href="<?= $baseUrl; ?>assets/css/main.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap">
</head>
<body>
	<div class="wrapper">
		<nav class="sidebar js-sidebar user-select-none" id="sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand d-flex flex-column align-items-center text-center" href="<?= $baseUrl; ?>admin">
					<img class="pe-none w-40" src="<?= $baseUrl; ?>assets/images/photos/cca-logo.png">
					<span class="align-middle">City College of Angeles</span>
				</a>

				<ul class="sidebar-nav">
					<li class="sidebar-item <?= page("dashboard", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>admin">
							<i class="fa-solid fa-chart-pie align-middle"></i>
							<span class="align-middle">Dashboard</span>
						</a>
					</li>

					<li class="sidebar-item <?= page("users", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>admin/users">
							<i class="fa-solid fa-users align-middle"></i>
							<span class="align-middle">Users</span>
						</a>
					</li>
					
					<li class="sidebar-item <?= page("freshmenApplicants", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>admin/freshmen-applicants">
							<i class="fa-solid fa-people-group align-middle"></i>
							<span class="align-middle">Freshmen Applicants</span>
						</a>
					</li>

					<li class="sidebar-item <?= page("academicYears", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>admin/academic-years">
							<i class="fa-solid fa-school align-middle"></i>
							<span class="align-middle">Academic Years</span>
						</a>
					</li>

					<li class="sidebar-item <?= page("classSchedules", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>admin/class-schedules">
							<i class="fa-solid fa-calendar-days align-middle"></i>
							<span class="align-middle">Class Schedules</span>
						</a>
					</li>

					<li class="sidebar-item <?= page("enrolledStudents", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>admin/enrolled-students">
							<i class="fa-solid fa-user-check align-middle"></i>
							<span class="align-middle">Enrolled Students</span>
						</a>
					</li>

					<li class="sidebar-item <?= page("studentGrades", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>admin/student-grades">
							<i class="fa-solid fa-star align-middle"></i>
							<span class="align-middle">Student Grades</span>
						</a>
					</li>

					<li class="sidebar-item <?= page("reportCards", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>admin/report-cards">
							<i class="fa-solid fa-award align-middle"></i>
							<span class="align-middle">Report Cards</span>
						</a>
					</li>

					<li class="sidebar-item <?= page("honorStudents", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>admin/honor-students">
							<i class="fa-solid fa-dove align-middle"></i>
							<span class="align-middle">Honor Students</span>
						</a>
					</li>
					
					<li class="sidebar-item <?= page("evaluations", $page); ?>">
						<a class="sidebar-link" href="<?= $baseUrl; ?>admin/evaluation/">
								<i class="fa fa-area-chart"></i>
							<span class="align-middle">Evaluation Result</span>
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
								<a class="dropdown-item" href="<?= $baseUrl; ?>admin/profile">
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