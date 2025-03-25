<!DOCTYPE html>
<html>
<head>
	<title>Same Page Form Process</title>
</head>
<body>

	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		User Name:<br>
		<input type="text" name="user" size="20"><br>
		Books in Collection:<br>
		<select name="books[]" size="5" multiple>
			<option>Web Application Development</option>
			<option>Linux Networking</option>
			<option>XML</option>
			<option>Laravel 8</option>
			<option>MERN Stack</option>
			<option>Windows 2018 Server</option>
		</select><br>
		Comment:<br>
		<textarea cols="50" rows="2" name="comment"></textarea><br>
		<input type="submit" name="submit" value="Send">
	</form>

</body>
</html>

<?php

if($_POST)
{
	print "<p>Welcome <b>$_POST[user]</b></p>";
	print "<p>Here is your comment: <i>$_POST[comment]</i></p>";
	print "<p>You have chosen the following books:</p>";

	print "<ol>";

		foreach($_POST['books'] as $book)
		{
			print "<li>$book</li>";
		}

	print "</ol>";
}

?>