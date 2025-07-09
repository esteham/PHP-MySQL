<?php

session_start();
require_once 'class.user.php';

$user = new USER();

if(!$user->is_logged_in() || $_SESSION['status'] != 'active')
{
	header('location: login.php');
	exit;
}
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="col-md-10 content-area">
	<?php
		
		if(isset($_GET['page']))
		{
			$page = $_GET['page'];
			$file = "pages/{$page}.php";

			if(file_exists($file))
			{
				include $file;
			}

			else
			{
				echo "<h4>Page Not Found!</h4>";
			}
		}

		else
		{
			include 'pages/dashboard.php';
		}

	?>
</div>

<?php
include 'includes/footer.php';
?>