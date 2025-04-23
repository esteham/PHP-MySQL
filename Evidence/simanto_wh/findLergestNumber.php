<?php
$result = ''; // To store the output message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = $_POST['numbers'];

    // Split input by commas or spaces
    $numbers = preg_split('/[\s,]+/', $input);

    // Filter out valid numeric values
    $validNumbers = array_filter($numbers, 'is_numeric');

    if (count($validNumbers) < 1) {
        $result = "<div class='message error'>Please enter at least one valid number.</div>";
    } else {
        $max = max($validNumbers);
        $result = "<div class='message success'>Largest number is: $max</div>";
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            text-align: center;
        }
        input[type="text"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .result-box {
            width: 30%;
            margin: 20px auto 0;
            text-align: center;
        }
        .message {
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>

<h2>Find the Largest Number</h2>

<form method="post" action="">
    <input type="text" name="numbers" placeholder="Enter numbers separated by space or comma" required>
    <br>
    <input type="submit" value="Find Largest">
</form>

<!-- Result shown below form -->
<div class="result-box">
    <?= $result ?>
</div>

</body>
</html>
