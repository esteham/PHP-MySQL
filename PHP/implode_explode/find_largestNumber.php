<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Largest Number</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="numbers">Enter numbers separated by comma:</label>
        <input type="text" name="numbers" id="numbers">
        <input type="submit" value="Find Largest Number">
    </form>
</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD']=="POST")
{
    $numbers = $_POST["numbers"];
    $numbersArray = array_map('trim',explode(",", $numbers));
    $numbersArray = array_filter($numbersArray,'is_numeric');

    if(!empty($numbersArray))
    {
        $largest = $numbersArray[0];
        foreach($numbersArray as $number)
        {
            if($number > $largest)
            {
                $largest = $number;
            }
        }
        echo "<p style='text-align:center;'>Largest number is: $largest</p>";
    }

    else
    {
        echo "Please enter valid numbers";
    }
}

?>