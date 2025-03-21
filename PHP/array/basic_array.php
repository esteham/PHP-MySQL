<?php
$arr = array("araman",45,"Trainer","Mohammodpur");
echo $arr[2];

echo "<br>";

echo "<pre>";
print_r($arr);
echo "</pre>";

echo "<br>";

echo "<pre>";
var_dump($arr);
echo "</pre>";

echo "<br>";

print "<ul>";

for ($i = 0; $i <= 3 ; $i++) 
{
	echo "<li>";
	echo $arr[$i];
	echo "</li>";
}

print "</ul>";

echo "<br>";

if(in_array(45, $arr))
{
	echo "Data Found";
}

else
{
	echo "Data Not Found";
}

echo "<br>";

echo array_search("Trainer", $arr);

?>