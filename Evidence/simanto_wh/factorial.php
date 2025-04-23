<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factorial Count</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 50px;
            margin: 0;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-container {
            width: 30%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            width: 100%;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .result-box {
            margin-top: 20px;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            border-radius: 6px;
        }
        .result-box p {
            font-size: 18px;
        }
    </style>
</head>
<body>

<h2>Factorial Count</h2>

<div class="form-container">
    <form method="post">
        <label for="number">Enter a Number</label>
        <input type="text" name="number" id="number" required>
        <input type="submit" name="submit" value="Check">
    </form>

    <?php
    error_reporting(0);

    if ($_POST['submit'] == 'Check') 
    {
        $input = $_POST['number'];

        // Check if input is a valid number
        if (is_numeric($input) && $input >= 0) 
        {
            $fact = 1;

            for ($i = $input; $i >= 1; $i--) 
            {
                $fact = $fact * $i;
            }

            /*echo "<div class='result-box'><p>The factorial of " . $input . " is: " . $fact . "</p></div>";*/
            echo "<div class='result-box' style='background-color: #d4edda; color: #155724;'><p>The factorial of " . $input . " is: " . $fact . "</p></div>";;
        } 
        else 
        {
            echo "<div class='result-box' style='background-color: #f8d7da; color: #721c24;'><p>Please enter a valid positive number.</p></div>";
        }
    }
    ?>

</div>

</body>
</html>
