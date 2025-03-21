<?php

print "<table border='1'>";

for ($i = 1; $i <= 12 ; $i++) 
{
	print "<tr>";

	for ($j = 1; $j <= 12 ; $j++) 
	{
		print "<td>";
		print ($i * $j);
		print "</td>";
	}

	print "</tr>";
}

print "</table>";


?>