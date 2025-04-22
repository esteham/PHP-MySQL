<?php
// Creating an associative array (Country => Capital)
$countries = [
    "Bangladesh" => "Dhaka",
    "India" => "New Delhi",
    "Australia" => "Canberra",
    "Canada" => "Ottawa",
    "Germany" => "Berlin"
];

// Sorting by country name (key sorting)
ksort($countries);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Country and Capitals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h3 {
            text-align: center;
            color: #333;
        }
        .card {
            background-color: #fff;
            width: 40%;
            margin: 10px auto;
            padding: 15px;
            border-left: 5px solid #333;
            border-radius: 5px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            color: #333;
        }
    </style>
</head>
<body>
    <h3>Country and Capitals (Sorted by Country Name)</h3>

    <?php
    // Printing data from the array
    foreach ($countries as $country => $capital) {
        echo "<div class='card'>";
        echo "Country: <strong>$country</strong><br>";
        echo "Capital: <strong>$capital</strong>";
        echo "</div>";
    }
    ?>
</body>
</html>
