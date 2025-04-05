<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Sets character encoding to UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Makes the page responsive -->
    <title>File Upload</title> <!-- Title of the page -->
</head>
<body>
    <h2 style="text-align:center;">Select Your Photograph</h2> <!-- Page heading -->

    <?php

    // Set the directory where uploaded files will be stored
    $upload_dir = "upload";

    // Check if a file has been uploaded using the form
    if(isset($_FILES['file']))
    {
        // Get file details
        $file_name = $_FILES['file']['name'];       // Original name of the file
        $file_type = $_FILES['file']['type'];       // MIME type of the file
        $file_size = $_FILES['file']['size'];       // Size of the file in bytes
        $file_tmp_name = $_FILES['file']['tmp_name']; // Temporary name of the file stored on the server

        // Check if the file type is an accepted image format
        if($file_type == "image/jpeg" || $file_type == "image/png" || $file_type == "image/jpg" || $file_type == "image/gif"){

            // Create the upload directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); // 0777 allows full read/write/execute permissions
            }

            // Move the uploaded file from temporary location to the upload directory
            move_uploaded_file($file_tmp_name, $upload_dir . "/" . $file_name);

            // Display a success message and show the uploaded image and its details
            echo"<p style=text-align:center>";
            echo "File uploaded successfully";
            echo "<br>";

            // Display the uploaded image (resized to 200x200 pixels)
            print"<img src='upload/$file_name' height='200' width='200'>";
            echo "<br>";

            // Show file details
            echo "File Name: ".$file_name."<br>";
            echo "File Type: ".$file_type."<br>";
            echo "File Size: ".$file_size."<br>";
            echo"</p>";
        } else {
            // Display an error if the file type is not supported
            echo "<p style='color:red; text-align:center;'>";
            echo "File type should be jpeg, jpg, png or gif";
            echo"</p>";
        }
    }

    ?>

    <!-- File upload form -->
    <form style="text-align:center" action="" method="post" enctype="multipart/form-data">
        Choose your file :<input type="file" name="file" id="file"><br> <!-- File input field -->
        <input type="submit" value="Upload" name="submit"> <!-- Submit button -->
    </form>
</body>
</html>
