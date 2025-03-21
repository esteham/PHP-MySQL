<?php

function salesTax($price, $tax)
{
	function convert_bdt($dollar, $conversion = 120)
	{
		return $dollar * $conversion;
	}

	$total = $price + ($price * $tax);
	echo "Total Cost in $: $total"." "."Cost in BDT is:"." ".convert_bdt($total);
}

salesTax(15.5,0.75);


?>