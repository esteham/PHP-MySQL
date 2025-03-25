<?php

$n = 10;

try 
{
	if($n <= 0)
	{
		throw new Exception("Invalid number. Number cannot be 0 or negative");
	}

	else
	{
		echo "Number is valid";
	}
} 

catch (Exception $e) 
{
	echo $e->getMessage();
}




?>