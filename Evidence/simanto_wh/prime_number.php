<?php
error_reporting(0);

if(isset($_POST['submit']))
{
    $num = $_POST['num'];

    for ($i = 2; $i < $num; $i++) 
    {
        if($num % $i == 0)
        {            
            $myval = True; 
        }
    }

    if(isset($myval) && $myval)
    {
        $message = "$num is not a prime number";
        $messageClass = "error";
    }
    elseif ($num == 0 || $num == 1 || $num < 0) 
    {
        $message = "$num is not a prime or non-prime number";
        $messageClass = "error";
    }
    else
    {
        $message = "$num is a prime number";
        $messageClass = "success";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prime Number Check</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
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
            width: 92%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            width: 100%;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .result-container {
            width: 30%;
            margin: 20px auto 0;
            padding: 20px;
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .message {
            padding: 10px;
            text-align: center;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 15px;
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

<h2>Prime Number Check</h2>

<div class="form-container">
    <form method="post" action="">
        <label for="num">Enter a number:</label>
        <input type="text" name="num" id="num" required>
        <input type="submit" name="submit" value="Check">
    </form>


    <!-- Result Box -->
    <?php if (!empty($message)): ?>
        
            <div class="message <?= $messageClass ?>"><?= $message ?></div>
        
    <?php endif; ?>
</div>

</body>
</html>
