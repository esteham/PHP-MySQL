<?php
// Creating an associative array (Country => Capital)
$country_capitals = [
    "Bangladesh" => "Dhaka",
    "India" => "New Delhi",
    "Australia" => "Canberra",
    "Canada" => "Ottawa",
    "Germany" => "Berlin"
];

// Sorting by country name (key sorting)
ksort($country_capitals);

// Printing data from the array
echo "<h3 style='text-align: center;'>Country and Capitals (Sorted by Country Name):</h3>";
foreach ($country_capitals as $country => $capital) {
    echo "<p style='text-align: center;'>Country: $country, Capital: $capital</p>";
}
?>
