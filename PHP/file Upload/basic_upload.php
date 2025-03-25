<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <h2 style="text-align:center;">Select Your Photograph</h2>

    <?php

$upload_dir = "upload";
if(isset($_FILES['file']))
{
    $file_name = $_FILES['file']['name'];
    $file_type = $_FILES['file']['type'];
    $file_size = $_FILES['file']['size'];
    $file_tmp_name = $_FILES['file']['tmp_name'];
   

    if($file_type == "image/jpeg" || $file_type == "image/png" || $file_type == "image/jpg" || $file_type == "image/gif"){
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        move_uploaded_file($file_tmp_name, $upload_dir . "/" . $file_name);
        echo"<p style=text-align:center>";
        echo "File uploaded successfully";
        echo "<br>";

        print"<img src='upload/$file_name' height='200' width='200'>";
        echo "<br>";
        echo "File Name: ".$file_name."<br>";
        echo "File Type: ".$file_type."<br>";
        echo "File Size: ".$file_size."<br>";
        echo"</p>";
    }else{
        echo "<p style='color:red; text-align:center;'>";
        echo "File type should be jpeg, jpg, png or gif";
        echo"</p>";
    }
}

?>

    <form style="text-align:center" action="" method="post" enctype="multipart/form-data">
        Choose your file :<input type="file" name="file" id="file"><br>
        <input type="submit" value="Upload" name="submit">
    </form>
</body>
</html>

 