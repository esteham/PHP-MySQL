<?php
// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["uploadedFile"]["name"]);
    $uploadOk = 1;

    // List of allowed file types
    $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'doc', 'docx'];
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // If file size is greater than 400KB, cancel the upload
    if ($_FILES["uploadedFile"]["size"] > 400 * 1024) {
        echo "<p style='text-align: center; color: red;'>File size must be less than 400KB.</p>";
        $uploadOk = 0;
    }

    // If the file type is not allowed
    if (!in_array($fileType, $allowedTypes)) {
        echo "<p style='text-align: center; color: red;'>Only PDF, Image, and Document files are allowed.</p>";
        $uploadOk = 0;
    }

    // If everything is okay, upload the file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $targetFile)) {
            echo "<p style='text-align: center; color: green;'>File has been uploaded: " . htmlspecialchars(basename($_FILES["uploadedFile"]["name"])) . "</p>";
        
        } else {
            // If there is an issue with the upload, show an error message
            echo "<p style='text-align: center; color: red;'>There was an error uploading your file.</p>";
        }
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
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
    <h2>File Upload Form</h2>
<form action="" method="post" enctype="multipart/form-data">
    <label>Select a file to upload (PDF/Image/DOC):</label><br><br>
    <input type="file" name="uploadedFile" required>
    <br><br>
    <input type="submit" value="Upload">
</form>
</body>
</html>
