<?php
// 🔗 Database Connection
include 'dbConfig.php';

$cat_err = '';
$cat_success = '';

// ====================
// Add Category
// ====================
if (isset($_POST['add_category'])) { // If the form is submitted and add_category is set
    $category_name = trim($_POST['category_name']); // Trim the category name from input

    if (empty($category_name)) { // If the category name is empty
        $cat_err = "Please provide a category name."; // Set error message
    } else { // If the category name is not empty
        $stmt = $DB_con->prepare("INSERT INTO categories (category_name) VALUES (:cname)"); // Prepare SQL statement to add category
        $stmt->bindParam(':cname', $category_name); // Bind category name parameter
        if ($stmt->execute()) { // Execute SQL statement
            $cat_success = "Category successfully added!"; // Set success message
        } else { // If execution fails
            $cat_err = "There was a problem with the database."; // Set error message
        }
    }
}

// ====================
// Delete Category
// ====================
if (isset($_GET['delete'])) {
    
    $del_id = $_GET['delete']; // Get category ID parameter for deletion
    $stmt = $DB_con->prepare("DELETE FROM categories WHERE id = :id"); // Prepare SQL statement for deletion
    $stmt->bindParam(':id', $del_id); // Bind category ID parameter
    $stmt->execute(); // Execute deletion
    $cat_success = "Category successfully deleted!"; // Show success message after deletion
    header("Location: product_category_manage.php"); // Refresh the page after deletion
    exit;
}

// ====================
// Edit Category
// ====================
$edit_id = ''; // Initialize category ID for editing
$edit_name = ''; // Initialize category name for editing
if (isset($_GET['edit'])) { // If edit parameter is set
    $edit_id = $_GET['edit']; // Get category ID from edit parameter
    $stmt = $DB_con->prepare("SELECT * FROM categories WHERE id = :id"); // Prepare SQL statement to fetch category data
    $stmt->bindParam(':id', $edit_id); // Bind category ID parameter
    $stmt->execute(); // Execute SQL statement
    $category = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch category data from database
    $edit_name = $category['category_name']; // Set category name
}

if (isset($_POST['update_category'])) { // If update category form is submitted
    $new_name = $_POST['category_name']; // Get new category name from input
    $id = $_POST['edit_id']; // Get edit ID from input

    $stmt = $DB_con->prepare("UPDATE categories SET category_name = :name WHERE id = :id"); // Prepare SQL statement to update category
    $stmt->bindParam(':name', $new_name); // Bind new category name parameter
    $stmt->bindParam(':id', $id); // Bind category ID parameter
    $stmt->execute(); // Execute SQL statement
    header("Location: product_category_manage.php"); // Redirect to refresh the page
    exit; // Stop script execution
}

// ====================
// Fetch Category List
// ====================

$cat_stmt = $DB_con->prepare("SELECT * FROM categories"); // Prepare SQL statement to fetch category list
$cat_stmt->execute(); // Execute SQL statement
$categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all category data from database
?>

<!DOCTYPE html>
<html>
<head>
    <title>Category & Product Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css"/>
</head>
<body>

<div class="container mt-5">
    <h3>Category Management</h3>

    <?php if(!empty($cat_err)) echo "<div class='alert alert-danger'>$cat_err</div>"; ?>
    <?php if(!empty($cat_success)) echo "<div class='alert alert-success'>$cat_success</div>"; ?>

    <!-- Category Input Form -->
    <form method="post" class="mb-4">
        <div class="form-group">
            <label>Category Name:</label>
            <input type="text" name="category_name" class="form-control" value="<?= htmlspecialchars($edit_name) ?>" required>
            <?php if ($edit_id): ?>
                <input type="hidden" name="edit_id" value="<?= $edit_id ?>"><br>
                <button type="submit" name="update_category" class="btn btn-warning mt-2">Update Category</button>
                <a href="product_category_manage.php" class="btn btn-secondary mt-2">Cancel</a>
            <?php else: ?>
                <br><button type="submit" name="add_category" class="btn btn-primary mt-2">Add Category</button>
            <?php endif; ?>
        </div>
    </form>

    <!-- Category List -->
    <h4>All Categories</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categories as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= htmlspecialchars($cat['category_name']) ?></td>
                    <td>
                        <a href="?edit=<?= $cat['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                        <a href="?delete=<?= $cat['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    
</div>

</body>
</html>
