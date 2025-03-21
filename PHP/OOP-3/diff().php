<?php
$date1 = new DateTime("2020-01-01");
$date2 = new DateTime("2025-03-18");

$diff = $date1->diff($date2);

echo "Difference: ".$diff->format('%y years, %m months, %d days');
?>

<?php
echo "<br>";

$now = new DateTime();
$olddate = new DateTime("2000-07-25");

$diff = $olddate->diff($now);

echo "Your job life is: ".$diff->format("%y years, %m Months, %d Days");
?>

<?php
echo "<br>";

$time1 = new DateTime("2024-03-07 10:30:00");
$time2 = new DateTime("2024-03-07 15:45:30");

$diff = $time1->diff($time2);

echo "Difference: ".$diff->format("%d days, %h Hours, %i minutes, %s Seconds");

?>

<?php
echo "<br>";

$date1 = new DateTime("@1700000000");
$date2 = new DateTime();

$diff = $date1->diff($date2);

echo "Difference: ".$diff->format("%y years, %m months, %d days, %h hours, %i minutes");


?>

<?php

echo "<br>";

$date1 = new DateTime("2025-03-01");
$date2 = new DateTime("2025-03-18");

$diff = $date1->diff($date2);

echo "Total Days: ".$diff->days;
?>

<?php
echo "<br>";

$oldDate = new DateTime("2024-03-01");
$now = new DateTime();

$diff = $oldDate->diff($now);

if($diff->y >= 1)
{
	echo "Yes, the difference is more than or equal to 1 year";
}

else
{
	echo "No, the difference is less than 1 year";
}


?>