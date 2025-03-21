<?php
$a1 = array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow"); 
$a2 = array("e"=>"red","f"=>"black","g"=>"purple"); 
$a3 = array("a"=>"red","b"=>"black","c"=>"yellow");

$intersection = array_intersect($a1, $a2, $a3);

echo "<pre>";
print_r($intersection);
echo "</pre>";



?>