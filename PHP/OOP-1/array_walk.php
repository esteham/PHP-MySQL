<?php

/*function arraywalk($value,$key)
{
	echo "The key is $key and the value is $value<br>";
}

$a = array("d"=>"yellow","a"=>"red","z"=>"green","x"=>"lemon","b"=>"lime");
array_walk($a, "arraywalk");*/

function employees($value,$key,$p)
{
	echo "<pre>";
	echo "$key $p $value";
	echo "</pre>";
}

$emp = ["Jwel","Arif","Kamal","Rebeca","Kabir","Jalal"];
array_walk($emp, "employees","has the name");
?>