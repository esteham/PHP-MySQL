<?php
// Include the database connection file
include 'dbConfig.php';

$errorMessage = '';
$successMessage = '';

// If the form is submitted
if (isset($_POST['submit'])) {
    $category_name = trim($_POST['category_name']); // Trim the category name from input

    // Set error message if the category name is empty
    if (empty($category_name)) {
        $errorMessage = "Please enter the category name.";
    } else {
        // Prepare the SQL statement to insert the category
        $stmt = $DB_con->prepare("INSERT INTO categories (category_name) VALUES (:cname)");
        $stmt->bindParam(':cname', $category_name); // Bind the category name parameter

        if ($stmt->execute()) {
            $successMessage = "Category has been added successfully!";
        } else {
            $errorMessage = "There was a problem with the database.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" />
</head>
<body>
<div class="container mt-5">
    <h2>Add New Category</h2>

    <!-- Display success or error messages -->
    <?php if(!empty($errorMessage)) echo "<div class='alert alert-danger'>$errorMessage</div>"; ?>
    <?php if(!empty($successMessage)) echo "<div class='alert alert-success'>$successMessage</div>"; ?>

    <!-- Category input form -->
    <form method="post">
        <div class="form-group">
            <label>Category Name:</label>
            <input type="text" name="category_name" class="form-control" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add Category</button>
    </form>
</div>
</body>
</html>