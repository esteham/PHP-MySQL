<?php
// Including the database configuration file - this file sets up the PDO connection
include 'dbConfig.php';

// Defining variables to display messages
$errmsg = '';       // For error messages
$successmsg = '';   // For success messages

// Fetching all categories from the database - this data will be used in the HTML select options
$cat_stmt = $DB_con->prepare("SELECT * FROM categories"); // Query to fetch all categories from the categories table
$cat_stmt->execute();
$categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);

/***********************************************************
 * Form submission handling - this block executes when the form is submitted
 ***********************************************************/
if(isset($_POST['btnsave'])) 
{
    // Collecting data from the form
    $productname = $_POST['product_name'];    // Product name
    $description = $_POST['description'];     // Description
    $productstock = $_POST['product_stock'];  // Stock amount
    $category_id = $_POST['category_id'];     // Category ID
    
    // Data related to attributes
    $has_attributes = isset($_POST['has_attributes']) ? 1 : 0; // Whether attributes exist
    $sizes = isset($_POST['sizes']) ? implode(',', $_POST['sizes']) : ''; // Sizes as a comma-separated string
    $colors = isset($_POST['colors']) ? $_POST['colors'] : ''; // Colors

    /***********************************************************
     * Image upload handling - this section manages file uploads
     ***********************************************************/
    $imgfile = $_FILES['product_image']['name'];     // File name
    $tmp_dir = $_FILES['product_image']['tmp_name']; // Temporary location
    $imgsize = $_FILES['product_image']['size'];     // File size

    // Form validation check - ensuring all fields are filled
    if(empty($productname) || empty($description) || empty($imgfile) || empty($productstock)) 
    {
        $errmsg = "All fields are required!";
    }
    else 
    {
        $upload_dir = "uploads/"; // Upload directory
        $imgext = strtolower(pathinfo($imgfile, PATHINFO_EXTENSION)); // File extension
        $valid_extensions = ['jpg','jpeg','png','gif']; // Allowed extensions
        $productpic = rand(1000, 1000000000).".".$imgext; // Generating a random filename

        // Image validation check
        if(in_array($imgext, $valid_extensions) && $imgsize < 5000000) 
        {
            move_uploaded_file($tmp_dir, $upload_dir.$productpic); // Uploading the file
        }
        else 
        {
            $errmsg = "Invalid image file or size too large";
        }
    }

    // If there are no errors, save the data to the database
    if(empty($errmsg)) 
    {
        /***********************************************************
         * Insert data into the products table - this code saves data to the products table
         ***********************************************************/
        $stmt = $DB_con->prepare("INSERT INTO products (product_name,description,product_image,stock_amount,has_attributes,category_id) VALUES (:pname,:pdesc,:ppic,:pstock,:hasattr,:cat_id)");

        // Parameter binding - to prevent SQL injection
        $stmt->bindParam(':pname',$productname); // Binding product name parameter
        $stmt->bindParam(':pdesc',$description); // Binding description parameter
        $stmt->bindParam(':ppic',$productpic); // Binding product image parameter
        $stmt->bindParam(':pstock',$productstock); // Binding stock amount parameter
        $stmt->bindParam(':hasattr',$has_attributes); // Binding attributes parameter
        $stmt->bindParam(':cat_id',$category_id); // Binding category ID parameter

        // Executing the query
        if($stmt->execute()) 
        {
            $lastProductId = $DB_con->lastInsertId(); // Getting the last inserted ID

            /***********************************************************
             * If the product has attributes, save data to the attributes table
             * This section only executes if $has_attributes = 1
             ***********************************************************/
            if($has_attributes) 
            {
                $attr_stmt = $DB_con->prepare("INSERT INTO attributes (product_id,sizes,colors) VALUES (:pid,:sizes,:colors)");

                $attr_stmt->bindParam(':pid',$lastProductId); // Binding product ID parameter
                // Binding sizes and colors parameters - sizes will be inserted as a comma-separated string
                $attr_stmt->bindParam(':sizes',$sizes);
                $attr_stmt->bindParam(':colors',$colors); // Binding colors parameter - colors will be inserted as a comma-separated string
                $attr_stmt->execute();
            }

            $successmsg = "New product has been successfully saved.";
        }
        else 
        {
            $errmsg = "Failed to save the product.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Product</title>
    <!-- Linking Bootstrap CSS - this stylesheet is for form design -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" />
</head>
<body>

<div class="container mt-5">
    <h3 class="mb-4">Add New Product</h3>

    <!-- Displaying error or success messages -->
    <?php if(!empty($errmsg)) echo "<div class='alert alert-danger'>$errmsg</div>"; ?>
    <?php if(!empty($successmsg)) echo "<div class='alert alert-success'>$successmsg</div>"; ?>

    <!-- Main form - this form's data is processed by the PHP code above -->
    <form method="post" enctype="multipart/form-data">
        <!-- Product name input -->
        <div class="form-group">
            <label>Product Name:</label>
            <input type="text" name="product_name" class="form-control" required>
        </div>

        <!-- Description text area -->
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <!-- Image upload field - this file's data is accessed in PHP using $_FILES -->
        <div class="form-group">
            <label>Product Image:</label>
            <input type="file" name="product_image" class="form-control" required>
        </div>

        <!-- Stock amount -->
        <div class="form-group">
            <label>Stock Amount:</label>
            <input type="number" name="product_stock" class="form-control" required>
        </div>

        <!-- Category select - options are displayed by looping through $categories fetched in PHP -->
        <div class="form-group">
            <label>Category:</label>
            <select name="category_id" class="form-control" required>
                <option value="">Select a Category</option>
                <?php foreach ($categories as $cat) : ?>
                    <option value="<?= $cat['id']; ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Attributes checkbox - checking this will display the attributes section below -->
        <div class="form-check mb-3">
            <input type="checkbox" name="has_attributes" class="form-check-input" id="hasAttributes" onchange="toggleAttributes()">
            <label class="form-check-label">Has Attributes?</label>
        </div>

        <!-- Attributes section - hidden by default, shown when the checkbox is checked -->
        <div id="attributeSection" style="display: none;">
            <!-- Size checkboxes -->
            <div class="form-group">
                <label>Size:</label>
                <label class="checkbox-inline mr-2"><input type="checkbox" name="sizes[]" value="L">L</label>
                <label class="checkbox-inline mr-2"><input type="checkbox" name="sizes[]" value="XL">XL</label>
                <label class="checkbox-inline mr-2"><input type="checkbox" name="sizes[]" value="XXL">XXL</label>
            </div>

            <!-- Color picker - managed with JavaScript -->
            <div class="form-group">
                <label>Color:</label>
                <input type="color" class="color-input">
                <button type="button" class="btn btn-sm btn-secondary" onclick="addColor()">Add Color</button>
                <!-- Selected colors will be displayed here -->
                <div id="colorList" class="mt-2"></div>
                <!-- This hidden field will actually be posted -->
                <input type="hidden" name="colors" id="colors">
            </div>
        </div>
        <!-- Submit button - clicking this button posts the form data to the server -->
        <button type="submit" name="btnsave" class="btn btn-success">Save</button><br><br>

        <!-- Button to navigate to the category management page -->
        <button  class="btn btn-danger"> <a href="product_category_manage.php">Manage Product & Category</a></button>

    </form>
</div>

<!-- JavaScript functionality -->
<script type="text/javascript">
    // Array to store selected colors
    let selectedColors = [];

    // Function to toggle the attributes section
    // This function is called on the onChange event of the hasAttributes checkbox
    function toggleAttributes() 
    {
        const attrSection = document.getElementById('attributeSection');
        // Show if the checkbox is checked, otherwise hide
        attrSection.style.display = document.getElementById('hasAttributes').checked ? 'block' : 'none';
    }

    // Function to add a color - takes the color from the color picker
    function addColor() 
    {
        const colorInput = document.querySelector('.color-input');
        const color = colorInput.value;

        // Checking if the color is already selected
        if(!selectedColors.includes(color)) 
        {
            selectedColors.push(color); // Adding the color to the array
            updateColorList(); // Updating the color list
        }
    }

    // Function to update the color list
    function updateColorList() 
    {
        const colorList = document.getElementById('colorList');
        const colorInput = document.getElementById('colors');
        colorList.innerHTML = ''; // Clearing the list

        // Creating a div element for each color
        selectedColors.forEach((color, index) => {
            const colorBox = document.createElement('div');
            colorBox.style.display = 'inline-block';
            colorBox.style.backgroundColor = color;
            colorBox.style.width = '30px';
            colorBox.style.height = '30px';
            colorBox.style.marginRight = '5px';
            colorBox.style.border = '1px solid #000';
            colorBox.title = color;
            
            // Clicking on the color box will remove the color
            colorBox.onclick = () => {
                selectedColors.splice(index, 1); // Removing the color from the array
                updateColorList(); // Updating the list
            };

            colorList.appendChild(colorBox); // Adding the color box
        });

        // Setting the colors as a comma-separated string in the hidden input
        // This value will be available in PHP as $_POST['colors']
        colorInput.value = selectedColors.join(',');
    }
</script>
</body>
</html>