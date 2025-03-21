<?php

function whatDate()
{
	return "Today is:"." ".date("F d,Y");
}

echo whatDate();

echo "<br>";

function add()
{
	$a = 10;
	$b = 15;
	$c = $a + $b;
	return $c;
}

echo add();

?>