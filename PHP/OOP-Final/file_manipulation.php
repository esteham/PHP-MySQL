<?php

/*$var = readfile("readme.txt");
echo $var."<br><br>";
*/

/*
$file = "readme.txt";

if(file_exists($file))
{
	copy($file, "readme2.txt");
}

else
{
	echo "File not found!";
}*/

/*$file = "readme2.txt";

if(file_exists($file))
{
	rename($file, "myfile.txt");
}

else
{
	echo "$file not found!";
}*/

/*$file = "myfile.txt";

if(file_exists($file))
{
	unlink($file);
	echo "File $file deleted successfully";
}

else
{
	echo "$file does not exists";
}*/

/*mkdir("includes");
echo "Folder created";*/

/*if(!file_exists("includes"))
{
	mkdir("includes");
	echo "Folder created";
}

else
{
	echo "Folder already exists";
}*/

/*$filename = "myfile.txt";

if(!file_exists($filename))
{
	fopen($filename, 'w');
}

else
{
	echo "File already openned";
}*/

/*$filename = "readme.txt";

$somecontent = "This file autometically created in server and it should contain user details information";

if(is_writable($filename))
{
	if(!$handle = fopen($filename , 'a'))
	{
		echo "cannot open the file";
		exit;
	}

	if(fwrite($handle, $somecontent) === FALSE)
	{
		echo "Cannot write in the file";
		exit;
	}

	echo "Wrote the content successfully";
	fclose($handle);

}

else
{
	echo "This file is not writable";
}*/

$file = "readme.txt";

echo filesize($file)."<br>";

echo filetype($file)."<br>";

echo filetype("includes")."<br>";

echo realpath($file)."<br>";

echo '<pre>';
print_r(pathinfo($file));
echo '</pre>';

echo "<br>";

echo pathinfo($file, PATHINFO_EXTENSION);

echo "<br>";

$path = realpath($file);
echo basename($path);
?>