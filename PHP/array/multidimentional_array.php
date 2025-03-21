<?php

$books = array(


		array(
			"name"=>"web Development",
			"edition"=> "2nd",
			"price"=>"BDT800"
		),
		array(

			"name"=>"Red Hat Linux",
			"edition"=> "2nd",
			"price"=>"BDT580"
		),
		array(

			"name"=>"C# Programming",
			"edition"=> "1st",
			"price"=>"BDT400"
		),
		array(

			"name"=>"Laravel 8",
			"edition"=> "1st",
			"price"=>"BDT500"
		),
		array(

			"name"=>"CPA marketing",
			"edition"=> "2nd",
			"price"=>"BDT350"
		)
);


foreach ($books as $value) 
{
	foreach ($value as $key => $new_val) 
	{
		print "$key:$new_val<br>";
	}

	print "<br>";
}

?>