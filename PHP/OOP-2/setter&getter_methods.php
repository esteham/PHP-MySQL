<?php

class MyClass
{
	private $pin;
	public $name;


	public function showInfo() //Getter Method
	{
		echo "Pincode is:".$this->pin."Name is:".$this->name;
	}

	public function setPin($mypin)
	{
		$this->pin = $mypin;
	}
}

$emp1 = new MyClass();
$emp1->name = "Kamal";
$emp1->setPin(1001);
//$emp1->pin = 1001;
$emp1->showInfo();


?>