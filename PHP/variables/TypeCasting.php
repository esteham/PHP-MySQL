<?php

$foo = '6bar55r';
$bar = true;

//echo gettype($foo);

settype($foo, 'integer');

echo gettype($foo);

echo "<br>";

$foo = 28.50;
$b = (int)$foo;
echo gettype($b);
echo $b;
?>