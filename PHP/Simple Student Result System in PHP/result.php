<?php

//error_reporting(0); // Turn off error reporting

// Define a class named Result
class Result
{
	public $id;
	public $name;
	public $batch;

	// Constructor that runs when an object of this class is created
	public function __construct($id, $name, $batch)
	{
		$this->id = $_POST['id']; // Get the ID from the submitted form
		$this->name = $name; // Assign the name
		$this->batch = $batch; // Assign the batch number
		$this->result($this->id); // Call the result function with the ID
	}

	// Function to fetch and show the result
	public function result($id)
	{
		$file = fopen('result.txt', 'r'); // Open the result.txt file in read mode

		// Loop until the end of the file
		while(!feof($file))
		{
			$data = fgets($file); // Read one line from the file
			$marks = explode("=", $data); // Split the line using '=' delimiter

			// If the input ID matches the ID from file
			if ($id == $marks[0]) 
			{
				// Display the result
				echo "Name: ".$marks[1]." "."ID: ".$this->id.", Batch: ".$this->batch." has got ".$marks[2]." marks";
			}
		}
	}
}

?>
 
<!-- HTML Part Starts -->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Result</title>
	<style type="text/css">
		body
		{
			text-align: center; /* Align all text to the center */
		}
	</style>
</head>
<body>

	<!-- Create a form to input student ID -->
	<form method="post" action="">
		Enter ID <input type="text" name="id"><br><br>	
		<input type="submit" name="submit" value="Show Result">
	</form>

	<?php
		// Only create the object when the form is submitted
		if (isset($_POST['submit'])) {
			$id = $_POST['id']; // Get ID from form
			$name = ""; // Name is empty for now, could be set from file if needed
			$obj = new Result($id, $name, 64); // Create object with given values
		}
	?>
</body>
</html>
