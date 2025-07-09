<?php

session_start();
require_once 'class.user.php';

$user = new USER();

if($user->is_logged_in())
{
	if($_SESSION['status'] == 'active')
	{
		header('location: index.php');
		exit;
	}

	else
	{
		echo "Access Denied! Your accouny is inactive.";
		exit;
	}
}

$error = "";

if(isset($_POST['btn-login']))
{
	$username = strtolower($_POST['username']);
	$password = $_POST['password'];

	if($user->admninlogin($username,$password))
	{
		if($_SESSION['status'] == 'active')
		{
		header('location: index.php');
		exit;
		}
		else
		{
			$error = "Access denied! You are inactive.";
			session_destroy();
		}
	}

	else
	{
		$error = "Wrong login details!";
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" integrity="sha512-rt/SrQ4UNIaGfDyEXZtNcyWvQeOq0QLygHluFQcSjaGB04IxWhal71tKuzP6K8eYXYB6vJV4pHkXcmFGGQ1/0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-dark">
<div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
	<div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
		<h4 class="text-center mb-4">Admin Login</h4>

		<?php if($error != ""): ?>
			<div class="alert alert-danger"><?php echo $error; ?></div>
		<?php endif; ?>

		<form method="post" action="#">
			<div class="form-group">
				<label>Username</label>
				<input type="text" name="username" id="username" class="form-control" required autofocus>
			</div>

			<div class="form-group">
				<label>Password</label>
				<input type="password" name="password" id="password" class="form-control" required>
			</div>
			<button type="submit" name="btn-login" class="btn btn-dark btn-block">Login</button>
		</form>
	</div>
</div>
</body>
</html>