<?php
// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input number from the form
    $number = $_POST['number'];

    // Function to check if a number is prime
    function isPrime($num) {
        // If the number is less than or equal to 1, it's not a prime
        if ($num <= 1) {
            return false;
        }
        // Special case for 2, which is a prime number
        if ($num == 2) {
            return true;
        }
        // If the number is even (except 2), it's not prime
        if ($num % 2 == 0) {
            return false;
        }
        
        // Check for factors from 3 to the square root of the number
        for ($i = 3; $i <= sqrt($num); $i += 2) {
            // If the number is divisible by any of these factors, it's not prime
            if ($num % $i == 0) {
                return false;
            }
        }
        // If no factors were found, the number is prime
        return true;
    }

    // Check if the number is prime and set the result
    if (isPrime($number)) {
        $result = "$number is a prime number."; // Prime
    } else {
        $result = "$number is not a prime number."; // Not prime
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta information for the page -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prime Number Checker</title>
    <style type="text/css">
        body
        {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Heading of the page -->
    <h2>Check if a Number is Prime</h2>

    <!-- HTML Form to take input from the user -->
    <form method="POST" action="">
        <!-- Label and input field for the number -->
        <label for="number">Enter a number:</label>
        <input type="number" id="number" name="number" required>
        <!-- Submit button to send the form -->
        <input type="submit" value="Check">
    </form>

    <?php
    // If the result is set (after form submission), display it
    if (isset($result)) {
        echo "<h3>$result</h3>"; // Output the result: whether the number is prime or not
    }
    ?>
</body>
</html>
