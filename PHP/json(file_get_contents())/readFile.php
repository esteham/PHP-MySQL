<?php
// Set the filename where the JSON data is stored
$filename = "data.json";

// Read the contents of the JSON file into a string
$data = file_get_contents($filename);

// Decode the JSON data into a PHP object
$users = json_decode($data);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Show Users Information from JSON Object</title>
	<style>
		/* Center the body content */
		body {
			text-align: center;
		}

		/* Style the table with borders and spacing */
		table {
			border: 1px solid #ddd;
			border-collapse: collapse;
			text-align: center;
		}

		/* Style for table header and data cells */
		th, td {
			padding: 8px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}

		/* Background color for header row */
		th {
			background-color: #f2f2f2;
		}

		/* Hover effect for table rows */
		tr:hover {
			background-color: #f5f5f5;
		}
	</style>
</head>
<body>

	<!-- Create a table to display user information -->
	<table>
		<tbody>
			<!-- Table header row -->
			<tr>
				<th>Name</th>
				<th>Age</th>
				<th>Occupation</th>
				<th>City</th>
				<th>Country</th>
			</tr>

			<?php
				// Loop through each user in the decoded JSON object
				foreach ($users as $user)
				{
			?>

			<!-- Display a table row for each user -->
			<tr>
				<td>
					<!-- Display the user's name -->
					<?= $user->name; ?>
				</td>
				<td>
					<!-- Display the user's age -->
					<?= $user->age; ?>
				</td>
				<td>
					<!-- Display the user's occupation -->
					<?= $user->occupation; ?>
				</td>
				<td>
					<!-- Display the user's city -->
					<?= $user->city; ?>
				</td>
				<td>
					<!-- Display the user's country -->
					<?= $user->country; ?>
				</td>
			</tr>

			<?php
				// End of foreach loop
				}
			?>

		</tbody>
	</table>

</body>
</html>
