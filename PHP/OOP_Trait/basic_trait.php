<?php

/*trait Logger
{
	public function log($message)
	{
		echo "[Log]: ".$message."<br>";
	}
}

class User
{
	use Logger;
	public function createUser()
	{
		

		$this->log("User created successfully");
	}
}

class Product
{
	use Logger;
	public function addProduct()
	{
		

		$this->log("Product added successfully");
	}
}

$user = new User();
$user->createUser();

$product = new Product();
$product->addProduct();*/

/*trait Logger
{
	public function log($message)
	{
		echo "[Log]: ".$message."<br>";
	}
}

trait Timestamp
{
	public function getTimestamp()
	{
		return Date("Y-m-d H:i:s");
	}
}

class User
{
	use Logger, Timestamp;
	public function createUser()
	{

		$this->log("User created at:".$this->getTimestamp());
	}
}

$user = new User();
$user->createUser();*/

trait Message
{
	abstract public function customMessage($msg);

	public function defaultMessage()
	{
		echo "This is a default message.<br>";
	}
}

class Myclass
{
	use Message;
	public function customMessage($msg)
	{
		echo "Custome Message: ".$msg."<br>";
	}
}

$obj = new Myclass();
$obj->customMessage("Hello, Trait!");
$obj->defaultMessage();

?>