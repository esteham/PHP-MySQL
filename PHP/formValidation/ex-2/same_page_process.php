<!DOCTYPE html>
<html>
<head>
    <title>PHP Form Example</title>
</head>
<body>
    <h2>PHP Contact Form</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Name:<br>
		<input type="text" name="name" size="30" required><br><br>
        Email:<br>
		<input type="email" name="email" required><br><br>
		
		Collecting Books:<br>
		<select name="books[]" size="5" multiple>
			<option>History of Philosophy</option>
			<option>Sophie's World</option>
			<option>Thought of Philosophy</option>
			<option>Big Bank Thoury</option>
			<option>Anncient of Philosopy</option>
			<option>Modern Philosophy</option>
		</select>
		
        Message:<br>
		<textarea name="message" required></textarea><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php

	if($_POST)
	{
		echo "<p>Welcome <b>$_POST[name]</b></p>";
		echo "<p>Email <b>$_POST[email]</b></p>";
		echo "<p>Your Comment <b>$_POST[message]</b></p>";
		echo "<p>You have chosen the following book </p>";
		
		echo "<ol>";
		
			foreach($_POST['books'] as $book)
			{
				echo "<li>$book</li>";
			}
		
		echo "</ol>";
	}

?>