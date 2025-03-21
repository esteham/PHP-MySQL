<?php

echo md5("araman777"); //32 bit encryption so this is not safe for encrypting safe data.

echo "<br>";

if(is_numeric(587))
{
	echo "This is Number";
}

else
{
	echo "Not a Number";
}

echo "<br>";

echo number_format(2500.1510,1);

echo "<br>";

echo sqrt(100);

echo "<br>";

echo pi();

echo "<br>";

$password = "secret";
$hashed = password_hash($password, PASSWORD_DEFAULT);
echo $hashed;

?>