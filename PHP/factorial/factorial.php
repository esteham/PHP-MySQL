<!DOCTYPE html>
<html>
<head>
    <title>Factorial Calculator</title> <!-- Page title -->
    <style type="text/css">
        body
        {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Factorial Calculator</h2>

    <!-- HTML form to take input from user -->
    <form method="post"> <!-- Sends data using POST method -->
        Enter a number: <input type="number" name="number" required> <!-- Input field for number -->
        <input type="submit" value="Calculate"> <!-- Submit button -->
    </form>

    <?php
    // Check if the form was submitted via POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Get the input number from the form and convert it to an integer
        $n = intval($_POST["number"]);

        // Function to calculate factorial using a loop
        function factorial($n) {
            $result = 1;

            // Loop from 1 to n and multiply each value
            for ($i = 1; $i <= $n; $i++) {
                $result *= $i;
            }

            // Return the result
            return $result;
        }

        // Output the result to the user
        echo "<p>Factorial of $n is: " . factorial($n) . "</p>";
    }
    ?>
</body>
</html>

