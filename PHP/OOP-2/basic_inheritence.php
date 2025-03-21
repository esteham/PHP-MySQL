<?php

class MyClass
{
	public function hello()
	{
		echo "Hello from the parent class";
	}

	public function thanks()
	{
		echo "Thanks from parent class";
	} 

}

class NewClass extends MyClass
{
	public function thanks()
	{
		echo "Thanks from child class";
	} 
}

$obj1 = new MyClass;
$obj1->hello();
$obj1->thanks();



$obj2 = new NewClass; 
$obj2->hello();
$obj2->thanks();
?>