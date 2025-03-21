<?php

class Category
{
	public $categoryName;

	public function __construct($categoryName)
	{
		$this->categoryName = $categoryName;
	}

	public function getCategory()
	{
		return "Catetory:".$this->categoryName;
	}
}

class Electronics extends Category
{
	public $brand;

	public function __construct($categoryName, $brand)
	{
		parent::__construct($categoryName);
		$this->brand = $brand;
	}

	public function getProductDetails()
	{
		return $this->getCategory().", Brand: ".$this->brand;
	}
}

class Clothing extends Category
{
	public $size;

	public function __construct($categoryName, $size)
	{
		parent::__construct($categoryName);
		$this->size = $size;
	}

	public function getProductDetails()
	{
		return $this->getCategory().", Size: ".$this->size;
	}
}

$mobile = new Electronics("Electronics","Samsung");
$tshirt = new Clothing("Clothing","Medium");


echo $mobile->getProductDetails()."<br>";
echo $tshirt->getProductDetails();


?>