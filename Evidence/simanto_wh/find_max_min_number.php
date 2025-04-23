<?php

$error = '';
$result = '';
$minResult = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $numbers = $_POST['numbers'];

    $numArray = array_map('trim', preg_split('/[\s,]+/', $numbers));

    $numArray = array_filter($numArray, 'is_numeric');

    if (!empty($numArray)) 
    {
        // Find the largest and smallest numbers
        $largest = $numArray[0];
        $smallest = $numArray[0];

        foreach ($numArray as $num) 
        {
            if ($num > $largest) 
            {
                $largest = $num;
            }
            if ($num < $smallest) 
            {
                $smallest = $num;
            } 
        }

        $result = "The largest number is: " . $largest;
        $minResult = "The smallest number is: " . $smallest;
    } 
    else 
    {
        $error = "Please enter valid numbers.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Find Largest and Smallest Number</title>
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
            padding: 12px;
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

<h2>Find the Largest and Smallest Number</h2>

<form method="post" action="">
    <input type="text" name="numbers" placeholder="Enter numbers separated by space or comma" required>
    <br>
    <input type="submit" value="Find Largest and Smallest">
</form>


<div class="result-box">
    <?php if ($error): ?>
        <div class="message error"><?= $error ?></div>
    <?php elseif ($result): ?>
        <div class="message success"><?= $result ?></div>
    <?php endif; ?>
    <?php if ($minResult): ?>
        <div class="message success"><?= $minResult ?></div>
    <?php endif; ?>
</div>

</body>
</html>
