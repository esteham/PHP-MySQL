<?php
// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input (comma-separated numbers)
    $input = $_POST['numbers'];

    // Split the input into an array by commas
    $numbers = explode(',', $input);

    // Remove extra spaces around each number
    $numbers = array_map('trim', $numbers);

    // Convert strings to numbers
    $numbers = array_map('floatval', $numbers);

    // Find the largest number
    $largest = max($numbers);

    echo "<h3 style='text-align: center;'>Largest number is: $largest</h3>";
}
?>

<!-- HTML form (single input field) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Largest Number</title>
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
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<h2>Find the Largest Number</h2>
<form method="post" action="">
    Enter 3 numbers separated by commas (e.g. 5, 8, 3):<br><br>
    <input type="text" name="numbers" required><br><br>
    <input type="submit" value="Find Largest">
</form>
</body> 
</html>
