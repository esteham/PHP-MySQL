<?php

$user = new USER();

$dir = __DIR__ . "/../assets/images/";
$dir = realpath($dir) . "/";
// fetch old image
$st = "select user_pic from tbl_user where id = :id";
$st = $user->runQuery($st);
$st->execute([':id' => $_SESSION['userSession']]);
$row = $st->fetch(PDO::FETCH_ASSOC);
if ($row) {
  $old_dir = "assets/images/";
  $old_pic_name = $row['user_pic'];
  $old_img = $old_dir . $old_pic_name;
  $dump_dir = __DIR__ . "/../assets/images/dump/";
  $dump_img = $dump_dir . $old_pic_name;
}

$new_img = 'img_input';
$allow_img_type = [
  "jpeg",
  "png",
  "jpg",
  "gif"
];

function upload($input_name, $dir, $allow_type, $maxsize = 20000000, $minsize = 1000)
{
  global $error, $success;
  if (isset($_FILES[$input_name])) {
    $file = $_FILES[$input_name];
    $fname = $file['name'];
    $ftemp = $file['tmp_name'];
    $ftype = strtolower(pathinfo($fname, PATHINFO_EXTENSION));
    $fsize = $file['size'];
    if ($fsize > $maxsize || $fsize < $minsize) {
      $error = "Size is larger or smaller.allowe size is betwene $maxsize and $minsize";
      return false;
    }
    if (!in_array($ftype, $allow_type)) {
      $error = "file type not allowed.";
      return false;
    }
    $random_num = rand(10000, 1000000000);
    $new_name = $random_num . "." . $ftype;
    $new_file = $dir . $new_name;
    if (!move_uploaded_file($ftemp, $new_file)) {
      $error = "upload failed.";
      return false;
    }
    return $new_name;
  }
}


if (isset($_POST['add_img_submit'])) {
  if ($name = upload("add_img_input", $dir, $allow_img_type)) {
    $new_img = $dir . $name;
    try {
      $stmt = "UPDATE `tbl_user` SET `user_pic` = :pic WHERE `tbl_user`.`id` = :id";
      $stmt = $user->runQuery($stmt);
      $is_run = $stmt->execute([':pic' => $name, ':id' => $_SESSION['userSession']]);
      if ($is_run) {
        $success = "Photo Uploded Succesfully.";
        if (file_exists($old_img)) {
          copy($old_img, $dump_img);
          unlink($old_img);
        }
        header('location: index.php?page=profile');
        exit;
      } else {
        if (file_exists($new_img)) {
          unlink($new_img);
        }
      }
    } catch (PDOException $ex) {
      if (file_exists($new_img)) {
        unlink($new_img);
      }
      $error = $ex->getMessage();
    }
  }
}

?>

<div class="p-4">
  <div class="row">
    <div class="col-4"><img class="rounded-circle" height="250" width="250" src='<?= $old_img ?>'></div>
    <div class="col-8">
      <form name="add_category_form" method="POST" enctype="multipart/form-data" class="form-control m-5 p-5">
        <?php
        if (isset($success)) {
          echo '<div class="message bg-success p-2 text-white">' . htmlspecialchars($success) . '</div>';
        }
        if (isset($error)) {
          echo '<div class="message bg-danger p-2 text-white">' . htmlspecialchars($error) . '</div>';
        }
        ?>
        <label for="img_input" class="text-center">Upload / change Image:</label>
        <input name="add_img_input" type="file" id="img_input" class="text-dark mb-4" required>
        <input name="add_img_submit" type="submit" class="btn btn-dark text-white" value="Upload">
      </form>
    </div>
  </div>
</div>