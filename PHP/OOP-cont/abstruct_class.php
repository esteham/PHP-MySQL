<?php

/*abstract class Base
{
	abstract function printdata();
	function pr()
	{
		echo "Base Class";
	}

}

class Derived extends Base
{
	function printdata()
	{
		echo "Derived Class";
	}
}

//$obj1 = new Base;
$obj2 = new Derived;
$obj2->printdata();*/

abstract class Base
{
	function __construct()
	{
		echo "This is a construct function from abstract class";
	}
	abstract function printdata();
	

}

class Derived extends Base
{
	function __construct()
	{
		echo "\nDerived class constructor";
	}
	
	function printdata()
	{
		echo "Derived Class";
	}
}

//$obj1 = new Base;
$obj2 = new Derived;
$obj2->printdata();



?>