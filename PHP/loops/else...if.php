<?php

$priceOfBeef = 500;

if($priceOfBeef <= 100)
{
	echo "Buy 5kg Beef";
}

else if($priceOfBeef == 500)
{
	echo "Buy 3kg Beef";
}

else if($priceOfBeef == 350)
{
	echo "Buy 2kg Beef";
}

else
{
	echo "Dont buy beef, because its price is higher than $priceOfBeef";
}

?>