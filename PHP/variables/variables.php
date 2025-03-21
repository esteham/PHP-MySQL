<?php

$a = "This is a string";
$b = 5;

echo $a." ".$b;

echo "<p>This is a paragraph</p>";

$x = "5String10value";
$y = 25;
$z = $x + $y;
echo $z;

echo "<br>";

$number = 5;
echo $sum = 15+$number;
//echo $sum = 'twenty';

echo "<br>";

$total = 5;
$count = "10";
$total+= $count; //Type juggling
print $total."<br>";
echo gettype($total);

echo "<br>";

$dt = date("F,d,D,Y");
echo $dt;

echo "<br>";

printf("%dMobile phones cost is:$%.2f",100,50.255);

echo "<br>";

$c = true;

$d = array(10,20,"xyz");

echo "<pre>";
echo var_dump($total,$x,$dt,$c,$d);
echo "</pre>";
echo "<br>";

echo "<pre>";
echo print_r($d);
echo "</pre>"; 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Form</title>
</head>
<body>
	<form>
		<label>Username:</label><br>
		<input type="text" name="uname"><br>
		<label>Paswword:</label><br>
		<input type="password" name="pass"><br><br>
		<input type="submit" name="submit" value="submit">

	</form>

</body>
</html>