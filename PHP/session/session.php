<?php
echo "<p style='color:blue; font-size:20px; text-align:center;'>";
date_default_timezone_set('Asia/Dhaka');

session_start();

$_SESSION['user'] = "Xihad";
echo ("Your username is : ".$_SESSION['user']);

unset($_SESSION['user']);
echo ("Your username is: ".$_SESSION['user']);

echo "<br>";
echo session_id() ;
echo "<br>";
echo session_name();
echo "<br>";
echo session_save_path();
echo "<br>";
echo session_status();
echo "<br>";
echo session_cache_expire();
echo "<br>";
echo session_cache_limiter();
echo "<br>";
echo session_create_id();

echo "<br>";
echo "<br>";

$_SESSION['mySession'] = "Hello World";

$_SESSION['loggedOut'] = date('Y-m-d H:i:s');

$sessionenc = session_encode();
echo $sessionenc;

echo "</p>";

?>

