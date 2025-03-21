<?php

interface my_print
{
	public function printdata();
}

interface select
{
	public function getData();
}

interface MyInterface extends my_print, select
{
	public function addData();
}

class MyClass implements MyInterface
{
	public function printdata()
	{
		echo "This function will print information";
	}

	public function getData()
	{
		echo "This function will read information";
	}

	public function addData()
	{
		echo "This function will add data";
	}

}

class MyClass2 extends MyClass
{

}

$obj = new MyClass2();
$obj->printdata();
$obj->addData();


?>