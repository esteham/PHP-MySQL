<?php

abstract class Car
{
	protected $tankVolume;

	public function setTankVolume($volume)
	{
		$this->tankVolume = $volume;
	}

	abstract public function calcNumMilesonFullTank();
}

class Honda extends Car
{
	public function calcNumMilesonFullTank()
	{
		$miles = $this->tankVolume*30;
		return $miles;
	}
}

class Toyota extends Car
{
	public function calcNumMilesonFullTank()
	{
		$miles = $this->tankVolume*33;
		return $miles;
	}

	public function getColor()
	{
		return "Blue";
	}
}

$toyota = new Toyota();

$toyota->setTankVolume(10);
echo $toyota->calcNumMilesonFullTank()."<br>";
echo $toyota->getColor();

$honda1 = new Honda();
$honda1->setTankVolume(10);
echo $honda1->calcNumMilesonFullTank()."<br>";

?>