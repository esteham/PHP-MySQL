<?php

$products = array("RAM","Processor","RAM","Motherboard","Keyboard","Mouse","Motherboard","Graphic Card","Mouse","Processor","SSD");

$uniqueproducts = array_unique($products);

echo "<pre>";
print_r($uniqueproducts);
echo "</pre>";



?>