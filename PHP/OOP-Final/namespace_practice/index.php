<?php

include('test1.php');
include('test2.php');

$obj1 = new \webpack\posts\allpost\Myclass();
$obj1->hello();

$obj2 = new \webpack\posts2\allpost\Myclass();
$obj2->hello();

?>