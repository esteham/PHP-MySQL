<?php
// admin_portfolio_upload.php

$user = new USER();

if (!$user->is_logged_in() || $_SESSION['status'] != 'active') {
  header('location: login.php');
  exit;
}

$errors = [];
if (isset($_GET['msg']) && $_GET['msg'] == 'success') {
  $success = true;
} else {
  $success = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $raw       = $_POST['port_cat'] ?? '[]';
  $tags      = json_decode($raw, true);
  
  $values = array_map(function($t) {
  return $t['value'];
}, $tags);
  $commaSeparated = implode(',', $values);

  $port_url   = $_POST['port_url'] ?? '';
  $port_name = trim($_POST['port_name'] ?? '');
  $port_desc = trim($_POST['port_desc']  ?? '');
  $port_cat  = $commaSeparated;

  
  if ($port_name === '') {
    $errors[] = "Portfolio name can’t be empty.";
  }
  if (empty($_FILES['port_file']) || $_FILES['port_file']['error'] !== UPLOAD_ERR_OK) {
    $errors[] = "Please choose an image to upload.";
  }

  // If no errors, process upload
  if (!$errors) {
    $file     = $_FILES['port_file'];
    $maxSize  = 20 * 1024 * 1024; // 20 MB
    $allowed  = ['jpg', 'jpeg', 'png', 'gif'];

    // Check size
    if ($file['size'] > $maxSize) {
      $errors[] = "Image must be under 15 MB.";
    }

    // Check extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) {
      $errors[] = "Only JPG, PNG, GIF files allowed.";
    }

    if (!$errors) {
      // Create a unique filename
      $newName = uniqid('port_', true) . '.' . $ext;
      $dest    = __DIR__ . "/../../images/portfolio/$newName";

      if (!move_uploaded_file($file['tmp_name'], $dest)) {
        $errors[] = "Failed to move uploaded file.";
      } else {
        // After moving the file successfully...
        $insert = $user->runQuery("
  INSERT INTO portfolio
    (port_url, port_name, port_desc, port_cat, port_uploaded_name)
  VALUES
    (:port_url, :port_name, :port_desc, :port_cat, :ufile)
");
        $insert->execute([
          ':port_url'   => $port_url,
          ':port_name' => $port_name,
          ':port_desc' => $port_desc,        // from your form
          ':port_cat'  => $port_cat,         // comma‑separated from Tagify
          ':ufile'     => $newName
        ]);


        $success = true;
        echo '<script>window.location.href = "index.php?page=allportfolio&msg=success";</script>';
        exit;
      }
    }
  }
}
?>

<div class="col-10">
  <h1 class="mb-4">Upload New Portfolio Item</h1>

  <?php if ($success): ?>
    <div class="alert alert-success">✅ Portfolio item added successfully.</div>
  <?php endif; ?>

  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
  <!-- Tagify core CSS -->
  <link rel="stylesheet" href="https://unpkg.com/@yaireo/tagify/dist/tagify.css">
  <!-- Tagify script -->
  <script src="https://unpkg.com/@yaireo/tagify"></script>


  <div class="alert alert-info" role="alert">Portfolio would look better when img dimension is 500x360 or 1000x720</div>

  <form method="post" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
    <div class="form-group">
      <label for="blog_id">Link to Blog Post</label>
      <input
        type="text"
        id="port_url"
        name="port_url"
        class="form-control"
        value="<?= htmlspecialchars($port_url ?? 'https://www.Esteham H. Zihad Ansari.xyz/') ?>"
        placeholder="e.g. https://www.Esteham H. Zihad Ansari.xyz/">
    </div>

    <div class="form-group">
      <label for="port_name">Portfolio Name</label>
      <input
        type="text"
        id="port_name"
        name="port_name"
        class="form-control"
        value="<?= htmlspecialchars($port_name ?? '') ?>"
        placeholder="e.g. hospital management"
        required>
    </div>

    <div class="form-group">
      <label for="port_name">Portfolio description</label>
      <input
        type="text"
        id="port_desc"
        name="port_desc"
        class="form-control"
        value="<?= htmlspecialchars($port_desc ?? '') ?>"
        placeholder="e.g. Not required.">
    </div>

    <div class="form-group">
      <label for="port_cat">Portfolio Category</label>
      <input
        type="text"
        id="port_cat"
        name="port_cat"
        class="form-control"
        placeholder="e.g. Java, HTML, JavaScript">
    </div>


    <div class="form-group">
      <label for="port_file">Image File</label>
      <input
        type="file"
        id="port_file"
        name="port_file"
        accept=".jpg,.jpeg,.png,.gif"
        class="form-control-file">
      <small class="form-text text-muted">
        Max size 2 MB. JPG/PNG/GIF only.
      </small>
    </div>

    <button type="submit" class="btn btn-primary">Upload</button>
    <button type="button" onclick="window.history.back()" class="btn btn-warning">Go Back</button>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // 1) your available categories
    const availableCategories = [
      "Bootstrap 5", "HTML", "JavaScript", "PHP", "CSS", "Jquery", "React"
    ];
    // 2) select the input
    const input = document.getElementById('port_cat');
    // 3) initialize Tagify
    const tagify = new Tagify(input, {
      whitelist: availableCategories,
      dropdown: {
        enabled: 1, // show suggestions after 1 character
        fuzzySearch: true, // match partial strings
        position: 'text', // place suggestions at typed position
      },
      delimiters: ",", // use comma to separate tags
      editTags: false // disable tag-editing after created
    });
  });
</script>