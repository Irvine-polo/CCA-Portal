<?php

include $baseUrl . "assets/includes/dbh.inc.php";

if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] == "student") {
		header("Location: " . $baseUrl . "student");
		exit();
	} else if ($_SESSION["role"] == "faculty") {
		header("Location: " . $baseUrl . "faculty");
		exit();
	} else if ($_SESSION["role"] == "coordinator") {
		header("Location: " . $baseUrl . "coordinator");
		exit();
	} else if ($_SESSION["role"] == "secretary") {
		header("Location: " . $baseUrl . "secretary");
		exit();
	} else if ($_SESSION["role"] == "dean") {
		header("Location: " . $baseUrl . "dean");
		exit();
	} else if ($_SESSION["role"] == "hr") {
		header("Location: " . $baseUrl . "hr");
		exit();
	} else if ($_SESSION["role"] == "registrar") {
		header("Location: " . $baseUrl . "registrar");
		exit();
	} else if ($_SESSION["role"] == "vpaa") {
		header("Location: " . $baseUrl . "vpaa");
		exit();
	} else if ($_SESSION["role"] == "admin") {
		header("Location: " . $baseUrl . "admin");
		exit();
	} else if ($_SESSION["role"] == "setPassword") {
		header("Location: " . $baseUrl . "set-password");
		exit();
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
	<!-- FONTAWESOME CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<!-- MAIN CSS -->
	<link href="<?= $baseUrl; ?>assets/css/main.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap">
</head>
<body class="bg-phoenix d-flex flex-column min-vh-100">