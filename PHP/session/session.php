<?php
// Set text style for output: blue color, font size 20px, and centered alignment
echo "<p style='color:blue; font-size:20px; text-align:center;'>";

// Set the default timezone to Asia/Dhaka
date_default_timezone_set('Asia/Dhaka');

// Start the session (must be called before using any $_SESSION variables)
session_start();

// Assign a session variable 'user' with value "Xihad"
$_SESSION['user'] = "Xihad";

// Display the session variable 'user'
echo ("Your username is : ".$_SESSION['user']);

// Unset (delete) the session variable 'user'
unset($_SESSION['user']);

// Try to display 'user' again — this will show nothing because it was unset
echo ("Your username is: ".$_SESSION['user']);

// Display the current session ID
echo "<br>";
echo session_id(); 

// Display the session name (default is usually PHPSESSID)
echo "<br>";
echo session_name();

// Display the path where session data is saved on the server
echo "<br>";
echo session_save_path();

// Display the current session status as an integer:
// 0 = PHP_SESSION_DISABLED, 1 = PHP_SESSION_NONE, 2 = PHP_SESSION_ACTIVE
echo "<br>";
echo session_status();

// Display session cache expiration time in minutes
echo "<br>";
echo session_cache_expire();

// Display the current cache limiter (default is usually "nocache")
echo "<br>";
echo session_cache_limiter();

// Generate and display a new session ID (doesn't change current session)
echo "<br>";
echo session_create_id();

echo "<br>";
echo "<br>";

// Set two custom session variables
$_SESSION['mySession'] = "Hello World";
$_SESSION['loggedOut'] = date('Y-m-d H:i:s'); // Save logout time

// Encode all session data as a serialized string
$sessionenc = session_encode();

// Display the encoded session string
echo $sessionenc;

// Close the paragraph
echo "</p>";
?>
