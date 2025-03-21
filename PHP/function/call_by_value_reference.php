<?php

	function addFive($num)
	{
		$num+= 5;
	}

	function addSix(&$num)
	{
		$num+= 6;
	}

	$origNum = 10;
	addFive($origNum);//call by value
	echo "Original value is $origNum<br>";

	addSix($origNum);//call by reference
	echo "Original value is $origNum";

?>