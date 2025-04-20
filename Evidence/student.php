<?php
// Declaring the Student class
class Student {
    public $id;
    public $name;
    public $batch;

    // Initializing data through the constructor
    public function __construct($id, $name, $batch) {
        $this->id = $id;
        $this->name = $name;
        $this->batch = $batch;
    }

    // Display student information
    public function displayInfo() {
        echo "<div style='text-align: center;'>";
        echo "Student Info:<br>";
        echo "ID: $this->id<br>";
        echo "Name: $this->name<br>";
        echo "Batch: $this->batch<br><br>";
        echo "</div>";
    }

    // Result method: Searches for the result by ID from a file
    public function result($searchId) {
        $filename = "result.txt";

        if (!file_exists($filename)) {
            echo "<div style='text-align: center; color: red;'>Result file not found.</div>";
            return;
        }

        $lines = file($filename);

        foreach ($lines as $line) {
            $parts = explode(":", trim($line));
            if ($parts[0] == $searchId) {
                echo "<div style='text-align: center; color: green;'>Result for ID $searchId: $parts[1]</div>";
                return;
            }
        }

        echo "<div style='text-align: center; color: red;'>Result not found for ID $searchId.</div>";
    }
}

// Adding an input form to search for student information
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $searchId = $_POST['search_id'];

    // Simulating a database of students
    $students = [
        101 => new Student(101, "Rahim", "Batch 2023"),
        102 => new Student(102, "Karim", "Batch 2022"),
        103 => new Student(103, "Jamal", "Batch 2021"),
        104 => new Student(104, "Sadia", "Batch 2020"),
        105 => new Student(105, "Fatema", "Batch 2019"),
    ];

    if (array_key_exists($searchId, $students)) {
        $student = $students[$searchId];
        $student->displayInfo();
        $student->result($searchId);
    } else {
        echo "<div style='text-align: center; color: red;'>Student not found for ID $searchId.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            background-color: #fff;
            width: 30%;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Search Student Information</h2>
<form method="post">
    <label for="search_id">Enter Student ID:</label>
    <input type="text" id="search_id" name="search_id" required>
    <button type="submit">Search</button>
</form>
</body>
</html>

