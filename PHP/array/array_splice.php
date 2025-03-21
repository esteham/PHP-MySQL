<?php

$arr = array("jamal","Kamal","Noman","Ali","Moni","Hasan");

$arr2 = array("Tanvir","Sagor");

array_splice($arr, 1,0,$arr2);

print_r($arr);


?>