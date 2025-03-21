<?php

include("class_person.php");

$father = new Person;

$father->name = "Mr.Rahim";
$father->age = 45;
$father->profession = "Job Holder";

$mother = new Person;
$mother->name = "Mrs. Jarina";
$mother->age = 35;
$mother->profession = "House Wife";

$baby = new Person;
$baby->name = "Mr.Baby";

$father->shop();
$mother->cook();
echo $baby->name."weight".$baby->weight."kg\n"."<br>";
$baby->eat("Burger",500);
$baby->eat("Chocolate",500);
echo $baby->name."Now weights".$baby->weight."kg\n"."<br>";

$father->sleep();
$mother->sleep();
$baby->sleep();
?>