<?php

function Stringlength($string)
{
	return strlen($string);
}
$mystring = "Welcome to Cogent";
echo Stringlength($mystring);

echo "<br>";

echo str_word_count("Welcome to Cogent");

echo "<br>";

echo strrev("Hello World");

echo "<br>";

echo strpos("araman666@gmail.com", "@");

echo "<br>";

echo str_replace("Cogent", "BaseLtd", "Welcome to Cogent");

echo "<br>";

echo substr(md5(rand(2,10)),2,6);

?>