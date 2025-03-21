<?php

$a = array("d"=>"yellow","a"=>"red","z"=>"green","x"=>"lemon","b"=>"lime");

ksort($a);

foreach ($a as $key=>$value) 
{
	echo "<pre>";
	echo "$key = $value";
}
?>