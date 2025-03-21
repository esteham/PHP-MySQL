<?php

function saleTax($price, $tax=.02)
{
	$total = $price + ($price * $tax);
	echo "Total cost is: $total"."<br>";
}

//saleTax(15);

$a = "saleTax";
$a(15);

echo "<br>";

function customFont($font, $size=1.5)
{
	echo "<p style=\"font-family:$font;font-size:{$size}em;\">Welcome Text!</p>";
}

customFont("Arial",2);
customFont("Times",3);
customFont("Courier");
?>