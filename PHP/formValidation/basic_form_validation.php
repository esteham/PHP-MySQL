<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Validate name
    if (empty($_POST["name"])) {
        $errors[] = "Name is required.";
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    // Validate password
    if (empty($_POST["password"])) {
        $errors[] = "Password is required.";
    } elseif (strlen($_POST["password"]) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    } else {
        $password = htmlspecialchars($_POST["password"]);
    }

    // Validate confirm password
    if (empty($_POST["confirm_password"])) {
        $errors[] = "Confirm Password is required.";
    } elseif ($_POST["password"] !== $_POST["confirm_password"]) {
        $errors[] = "Passwords do not match.";
    }

    // Validate address
    if (empty($_POST["address"])) {
        $errors[] = "Address is required.";
    } else {
        $address = htmlspecialchars($_POST["address"]);
    }

    // Validate gender
    if (empty($_POST["gender"])) {
        $errors[] = "Gender is required.";
    } else {
        $gender = htmlspecialchars($_POST["gender"]);
    }

    // If no errors, process the form
    if (empty($errors)) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Registration Form</title>
</head>
<body>
    <h2>Registration Form</h2>
    <?php
    if (!empty($errors)) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li style='color: red;'>$error</li>";
        }
        echo "</ul>";
    }
    ?>
    <form action="" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>"><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>

        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password"><br><br>

        <label for="address">Address:</label><br>
        <textarea id="address" name="address"><?php echo isset($address) ? $address : ''; ?></textarea><br><br>

        <label for="gender">Gender:</label><br>
        <input type="radio" id="male" name="gender" value="Male" <?php echo (isset($gender) && $gender == 'Male') ? 'checked' : ''; ?>>
        <label for="male">Male</label><br>
        <input type="radio" id="female" name="gender" value="Female" <?php echo (isset($gender) && $gender == 'Female') ? 'checked' : ''; ?>>
        <label for="female">Female</label><br><br>

        <button type="submit">Register</button>
    </form>

    <?php
    if (isset($success) && $success) {
        echo "<h3>Registration Successful!</h3>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Name</th><td>$name</td></tr>";
        echo "<tr><th>Email</th><td>$email</td></tr>";
        echo "<tr><th>Password</th><td>$password</td></tr>";
        echo "<tr><th>Address</th><td>$address</td></tr>";
        echo "<tr><th>Gender</th><td>$gender</td></tr>";
        echo "</table>";
    }
    ?>
</body>
</html>