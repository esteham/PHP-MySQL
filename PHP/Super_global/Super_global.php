<?php

/*
$_GET[]--To send or retrieve data from URL
$_POST[]--To submit data through form
$_PUT[]--For updating records/data through form submission
$_REQUEST[]--To check the requset type as $_GET[] or $_POST[]
$_SESSION[]--To store session data
$_COOKIE[]--To save the cookie value in browser
$_FILES[]--For uploading files
$_SERVER[]--To handle various server infomartion
$_GLOBAL[]--To access all global variables.
*/


echo $_SERVER['SERVER_NAME']."<br>";

echo $_SERVER['SCRIPT_NAME']."<br>";

echo $_SERVER['REMOTE_ADDR']."<br>";

echo $_SERVER['PHP_SELF']."<br>";

echo $_SERVER['HTTP_HOST']."<br>";

echo $_SERVER['HTTP_USER_AGENT']."<br>";

echo $_SERVER['SERVER_SIGNATURE']."<br>";

echo "<pre>";
print_r($_SERVER);
echo "</pre>";

echo "<br>";

$today = mktime(0,0,0,3,23,2025);
//echo $today;

printf("There are %d days in March 2025", date("t",$today));
echo "<br>";

$futuredate = strtotime("+45 days");
echo date("F d,Y", $futuredate);

echo "<br>";

$date = new DateTime();
$date->setDate(2025,04,14);
echo $date->format("F j,Y");

echo "<br>";

$terminationDate = new DateTime('2025-03-31');
$todayDate = new DateTime('today');
$span = $terminationDate->diff($todayDate);
echo "Your subscription ends in {$span->format('%a')} days!";

?>