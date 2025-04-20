<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Collecting the inputs
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Variable to store error messages
    $error = '';

    // Check if the username contains '@'
    if (strpos($username, '@') === false) {
        $error = "The username must contain the '@' symbol.";
    }

    // Check if the username length is between 4 and 8 characters
    elseif (strlen($username) < 4 || strlen($username) > 8) {
        $error = "The username must be between 4 and 8 characters.";
    }

    // If there are no errors
    else {
        // Display a simple success message
        echo "Login successful, User: " . htmlspecialchars($username);
        // In a real application, database validation and session management can be added here
        exit;
    }

    // If any of the above conditions fail, display the error message
    echo "<div style='text-align: center; color: red; font-weight: bold; margin-top: 10px;'>$error</div>";
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            background-color: #fff;
            width: 30%;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>    
<h2>Login Form</h2>
<form method="post" action="">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <input type="submit" value="Login">
</form>
</body>
</html>