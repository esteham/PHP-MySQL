<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Initialize an error array
    $errors = [];

    // Validate username (min length of 3 characters)
    if (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters long.";
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate password strength (min 8 characters, must contain numbers, letters, and special characters)
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    } elseif (!preg_match("/[A-Za-z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[\W_]/", $password)) {
        $errors[] = "Password must contain letters, numbers, and special characters.";
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // If there are errors, display them
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
        // Proceed with registration (e.g., save to database)
        echo "<p style='color: green;'>Registration successful!</p>";

        // You would typically save the user data to your database here
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>PHP Form Example</title>
</head>
<body>
   <form action="register.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>
    <br>

    <button type="submit" name="submit">Register</button>
</form>

</body>
</html>