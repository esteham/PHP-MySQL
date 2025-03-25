<?php

if(isset($_POST['submit']))
{
	if((!isset($_POST['fname'])) || (!isset($_POST['lname'])) || (!isset($_POST['address'])) || (!isset($_POST['email'])) || (!isset($_POST['pass'])) || (!isset($_POST['gender'])))
	{
		$error = "*"."Please fill all required fields";
	}

	if($_POST['pass'] != $_POST['confirm_pass'])
	{
		$error = "Password does not match!";
	}

	else
	{
		$firstname = $_POST['fname'];
		$lastname = $_POST['lname'];
		$address = $_POST['address'];
		$email = $_POST['email'];
		$password = $_POST['pass'];
		$hashed = password_hash($password, PASSWORD_DEFAULT);
		$gender = $_POST['gender'];
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Basic Registration Form</title>
</head>
<body>

	<h1>Please Enter Your Following Information</h1>
	<fieldset>
		<legend><b>User Register Here...</b></legend>
		<form method="post" action="">
			
			<?php

				if(isset($_POST['submit']))
				{
					if(!empty($error))
					{
						echo "<p style='color: red;'>".$error."</p>";
					}
				}
			?>

			First Name:<br>
			<input type="text" name="fname">
			<span style="color: red;">*</span>
			<br>

			Last Name:<br>
			<input type="text" name="lname">
			<span style="color: red;">*</span>
			<br>

			Address:<br>
			<input type="text" name="address">
			<span style="color: red;">*</span>
			<br>

			Email:<br>
			<input type="email" name="email">
			<span style="color: red;">*</span>
			<br>

			Password:<br>
			<input type="Password" name="pass">
			<span style="color: red;">*</span>
			<br>

			Confirm Password:<br>
			<input type="Password" name="confirm_pass">
			<span style="color: red;">*</span>
			<br>

			Gender:<br>
			<input type="radio" name="gender" value="male">Male
			<input type="radio" name="gender" value="female">Female
			<br><br>
			<input type="submit" name="submit" value="Register">
		</form>
	</fieldset>
<table border="1">
	<tr>
		<th>Field</th>
		<th>Values</th>
	</tr>
	<tr>
		<td>First Name</td>
		<td><?php echo $firstname; ?></td>
	</tr>
	<tr>
		<td>Last Name</td>
		<td><?php echo $lastname; ?></td>
	</tr>
	<tr>
		<td>Address</td>
		<td><?php echo $address; ?></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><?php echo $email; ?></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><?php echo $hashed; ?></td>
	</tr>
	<tr>
		<td>Gender</td>
		<td><?php echo $gender; ?></td>
	</tr>


</table>
</body>
</html>