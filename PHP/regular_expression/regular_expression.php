<?php
/*
$string = "PHP is a web scripting language of choice";

$exp = preg_match("/PHP/", $string); //Returns 1 if the pattern was found in the string and 0 if not

if($exp)
{
	echo "A match was found";
}

else
{
	echo "No match found";
}
*/
echo "<br>";
/*
$string = "Php is a web scripting language of choice";

$exp = preg_match("/PHP/i", $string);  //Returns 1 if the pattern was found in the string and 0 if not

if($exp)
{
	echo "A match was found";
}

else
{
	echo "No match found";
}*/

/*$string = "Php is a web scripting language of choice";

$exp = preg_match_all("/web|php|scripting|server/i",$string,$array);  //Returns the number of times the pattern was found in the string, which may also be 0

echo "<pre>";
print_r($array);
echo "</pre>";
*/
echo "<br>";

/*$string = "Php is a web scripting language of choice";

$exp = preg_match_all("/w|o|t|x/i",$string,$array);  //Returns the number of times the pattern was found in the string, which may also be 0

echo "<pre>";
print_r($array);
echo "</pre>";*/

echo "<br>";

/*$string = "Php is a web scripting 522 language of choice";

$exp = preg_match_all("/522/i",$string,$array);  //Returns the number of times the pattern was found in the string, which may also be 0

echo "<pre>";
print_r($array);
echo "</pre>";*/

/*
$string = "Php is a web scripting 522 language of choice";

$exp = preg_match_all("/[wota]/i",$string,$array);  //Returns the number of times the pattern was found in the string, which may also be 0

echo "<pre>";
print_r($array);
echo "</pre>";*/

/*$string = "Php is a web scripting 522 language of choice";

$exp = preg_match_all("/[^wot]/i",$string,$array);  //Returns the number of times the pattern was found in the string, which may also be 0

echo "<pre>";
print_r($array);
echo "</pre>";*/

/*$string = "Php is a web scripting 522 language of choice";

$exp = preg_match_all("/[a-zA-Z]/i",$string,$array);   //Returns the number of times the pattern was found in the string, which may also be 0

echo "<pre>";
print_r($array);
echo "</pre>";*/

/*$string = "Php is a web scripting 522 language of choice";

$exp = preg_match_all("/[0-9a-z]/i",$string,$array);  //Returns the number of times the pattern was found in the string, which may also be 0

echo "<pre>";
print_r($array);
echo "</pre>";*/

/*$string = "file1 file2 file3 file4 file5 file6 file# file? file@";

$exp = preg_match_all("/file[1@]/i",$string,$arry);   //Returns the number of times the pattern was found in the string, which may also be 0

echo "<pre>";
print_r($arry);
echo "</pre>";*/

/*$string = "file1 file2 file3 file4 file5 file6 file# file? file@";

$exp = preg_match_all("/file[^0-9]/i",$string,$arry);  //Returns the number of times the pattern was found in the string, which may also be 0

echo "<pre>";
print_r($arry);
echo "</pre>";*/

/*$string = "file.txt
		   file.xlsx
		   file.docx
		   file.pptx
		   file.pdf";

$exp = preg_match_all("/file\w*\.(txt|docx|pptx)/", $string, $array);   //Returns the number of times the pattern was found in the string, which may also be 0

echo "<pre>";
print_r($array);
echo "</pre>";*/


/*$string = "212-456-7896";

$exp = preg_match_all("/\d{3}-(\d{3})-(\d{4})/",$string,$array);

echo "<pre>";
print_r($array);
echo "</pre>";*/

/*$string = "August 22nd
		   August 22
		   Aug 22nd
		   Aug 22";

$exp = preg_match_all("/Aug(ust)? 22(nd)?/i",$string,$array);   //Returns the number of times the pattern was found in the string, which may also be 0

echo "<pre>";
print_r($array);
echo "</pre>";*/

/*$string = "bat cat mat rat";

$exp = preg_match_all("/[^bc]at/",$string,$array);  //Returns the number of times the pattern was found in the string, which may also be 0

echo "<pre>";
print_r($array);
echo "</pre>";*/

$string = "bat cat mat rat 521 _";

$exp = preg_match_all("/\w/i",$string,$array);  //Returns the number of times the pattern was found in the string, which may also be 0

echo "<pre>";
print_r($array);
echo "</pre>";
?>
