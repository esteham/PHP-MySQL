<?php

$a = array("red","green","blue");

array_push($a, "purple","maroon");
array_pop($a);
array_shift($a);
array_unshift($a, "rose");
echo "<pre>";
print_r($a);
echo "</pre>";

?>