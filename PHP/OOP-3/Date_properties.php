<?php
//date(format, timestamp)-->y-m-d, H:i:s

echo date("Y-m-d");
echo "<br>";
echo date("d/m/Y");
echo "<br>";
echo date("l, F j, Y");
?>

<?php
echo "<br>";
echo date("h:i:s A");
echo "<br>";
echo date("H:i:s");
?>

<?php
echo "<br>";
$day = date("l", strtotime("2025-12-25"));
echo "December 25, 2025 falls on:$day";
?>

<?php
echo "<br>";
echo "Year: ". date("Y"). "<br>";
echo "Month: ". date("F")."<br>";
echo "Day " .date("d")."<br>";
?>

<?php
echo "<br>";

$future_date = strtotime("+7 days");
echo "Date after 7 days: ".date("Y-m-d", $future_date);
?>

<?php
echo "<br>";
echo "Current Timestamp: " .time()."<br>";
echo "Converted Date: " .date("Y-m-d H:i:s", 1742269442);
?>

<?php
echo "<br>";
$date = new DateTime();
$date->modify("+1 month");
echo "Next Month: ".$date->format("Y-m-d");
?>

<?php
echo "<br>";
date_default_timezone_set("Asia/Dhaka");
echo "bangladesh Time: ".date("Y-m-d H:i:s");

?>