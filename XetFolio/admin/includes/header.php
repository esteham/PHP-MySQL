<?php
require_once __DIR__ . '/../class.user.php';

$user = new USER();

$id = $_SESSION['userSession'];

$stmt = "select id, pic from admin where id = :id";
$stmt = $user->runQuery($stmt);
$stmt->execute([':id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$img = $user['pic'];

?>
<!DOCTYPE html>
<html>

<head>
	<title>Admin Panel</title>

	<!-- jquery cdn 3.7.1-->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
	<link rel="icon" type="image/x-icon" href="../images/fabicon.png">
	<style type="text/css">
		body {

			font-family: 'Arial', sans-serif;
		}

		.navbar-brand {
			font-weight: bold;
		}

		.sidebar {
			min-height: 100vh;
			background-color: #f8f9fa;
			border-right: 1px solid #dee2e6;
		}

		.sidebar .nav-link .active {
			background-color: #007bff;
			color: white !important;
		}

		.content-area {
			padding: 20px;
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a href="index.php" class="navbar-brand">Admin Panel</a>
		<div class="ml-auto d-flex align-items-center">
			<form class="form-inline mr-3">
				<input type="search" name="" class="form-control form-control-sm mr-sm-2" placeholder="search...">
				<button class="btn btn-sm btn-outline-light" type="submit">search</button>
			</form>

			<div class="dropdown">
				<a href="#" class="dropdown-toggle text-white d-flex align-item-center" data-toggle="dropdown">
					<img src="assets/images/<?= $img ?>" alt="admin" width="30" height="30" class="rounded-circle mr-2"> Admin
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<a href="index.php?page=profile" class="dropdown-item">Profile</a>
					<div class="dropdown-divider"></div>
					<a href="logout.php" class="dropdown-item text-danger">Logout</a>
				</div>
			</div>
		</div>
	</nav>

	<div class="container-fluid">
		<div class="row">