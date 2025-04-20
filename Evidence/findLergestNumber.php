<?php
// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Getting user input
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $num3 = $_POST['num3'];

    // Determining the largest number
    if ($num1 >= $num2 && $num1 >= $num3) {
        echo "<h3 style='text-align: center;'>Largest number is: $num1</h3>";
    } elseif ($num2 >= $num1 && $num2 >= $num3) {
        echo "<h3 style='text-align: center;'>Largest number is: $num2</h3>";
    } else {
        echo "<h3 style='text-align: center;'>Largest number is: $num3</h3>";
    }
    
}
?>


<!-- HTML form to get user input -->
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
    Enter First Number: <input type="number" name="num1" required><br><br>
    Enter Second Number: <input type="number" name="num2" required><br><br>
    Enter Third Number: <input type="number" name="num3" required><br><br>
    <input type="submit" value="Find Largest">
</form>
</body> 
</html>
