<?php

/*$arr1 = array("k","f","g","h","i","j","a","x");

array_multisort($arr1);

echo "<pre>";
print_r($arr1);*/

$result = array(
				array("country"=>"Bangladesh","capital"=>"Dhaka"),
				array("country"=>"India","capital"=>"Delhi"),
				array("country"=>"USA","capital"=>"Washington DC"),
				array("country"=>"Canada","capital"=>"Autoa")
);

$capitals = array();

foreach ($result as $key=>$value) 
{
	$capitals[$key] = $value['country'];
}

array_multisort($capitals,SORT_DESC,$result);
print_r("Modified Arrays are:<br>");
echo "<pre>";
print_r($result);
echo "</pre>";
?>