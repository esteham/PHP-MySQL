<!DOCTYPE html>
<html>
<head>
    <title>PHP Form Example</title>
</head>
<body>
    <h2>PHP Contact Form</h2>
    <form action="process.php" method="post">
        Name: <input type="text" name="name" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Message: <textarea name="message" required></textarea><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
