<?php
//session_start();

// Database connection using USER class
try {
  $db = new USER();
  $pdo = $db->getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  echo "Database connection failed: " . $e->getMessage();
  exit;
}

// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Fetch categories for dropdown
$cats = [];
try {
  $stmt = $pdo->query("SELECT id, cat_name FROM category ORDER BY cat_name ASC");
  $cats = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  // ignore or log
}

// Handle form submission
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
  // CSRF check
  if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $errors[] = 'Invalid request';
  }

  // Validate inputs
  $title = trim($_POST['blog_title'] ?? '');
  $cat_id = (int)($_POST['blog_cat_id'] ?? 0);
  $short_desc = trim($_POST['short_description'] ?? '');
  $content = trim($_POST['blog_content'] ?? '');

  if ($title === '') {
    $errors[] = 'Title is required';
  }
  if ($cat_id <= 0) {
    $errors[] = 'Please select a category';
  }
  if ($short_desc === '' && !($content == '')) {
    $length = 60;
    $full_content = trim($_POST['blog_content'] ?? '');
    $clean_content = strip_tags($full_content);
    if (strlen($clean_content) > $length) {
      $short_desc = substr($clean_content, 0, $length,  'UTF-8') . '...';
    } else {
      $short_desc = $clean_content;
    }
  }

  if ($content === '') {
    $errors[] = 'Content is required';
  }

  // Handle thumbnail upload
  $thumbnailName = null;
  if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] !== UPLOAD_ERR_NO_FILE) {
    $dir = __DIR__ . '/../../images/blog/';
    if (!is_dir($dir)) {
      mkdir($dir, 0755, true);
    }
    $file = $_FILES['thumbnail'];
    if ($file['error'] === UPLOAD_ERR_OK) {
      $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
      $thumbnailName = uniqid('thumb_') . '.' . $ext;
      $file_name = $file['name'];
      if (!move_uploaded_file($file['tmp_name'], $dir . $thumbnailName)) {
        $errors[] = 'Thumbnail upload failed';
      }
    } else {
      $errors[] = 'Thumbnail file issue';
    }
  }

  // If no errors, insert
  if (empty($errors)) {
    try {
      // Insert into blog table
      $stmt = $pdo->prepare("INSERT INTO blog (blog_title, blog_cat_id, created_date,
              created_by_admin) VALUES (:title, :cat, NOW(), :admin)");
      $stmt->execute([
        ':title' => $title,
        ':cat' => $cat_id,
        ':admin' => $_SESSION['userSession']
      ]);
      $blogId = $pdo->lastInsertId();

      // Insert blog description
      $stmt = $pdo->prepare("INSERT INTO blog_description (blog_id, short_description, full_description) VALUES (:id, :short, :full)");
      $stmt->execute([
        ':id' => $blogId,
        ':short' => $short_desc,
        ':full' => $content
      ]);

      // Insert thumbnail record
      if ($thumbnailName) {
        $stmt = $pdo->prepare("INSERT INTO thumbnail (blog_id, thumb_name,  thumb_uploaded_name) VALUES (:id, :imgname, :img)");
        $stmt->execute([
          ':id' => $blogId,
          ':imgname' => $file_name,
          ':img' => $thumbnailName
        ]);
      }

      // Insert initial random views
      $random_view = rand(113, 866);
      $stmt = $pdo->prepare("INSERT INTO views (blog_id, total_view) VALUES (:id, :rand)");
      $stmt->execute([':id' => $blogId, 'rand' => $random_view]);

      echo '<script>window.location.href = "index.php?page=allblog&msg=success";</script>';
      exit;
    } catch (Exception $e) {
      $errors[] = 'Database error: ' . $e->getMessage();
    }
  }
}
?>

  <!-- Latest CKEditor 5 Classic build -->
  <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
  <style>
    .ck-editor__editable[role="textbox"] {
      /* editing area */
      min-height: 300px;
    }
  </style>

  <div class="col-10">
    <h2>Add New Blog</h2> <?php if (!empty($errors)): ?><div class="alert alert-danger">
        <ul>
          <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
          <?php endforeach; ?>
        </ul>
      </div> <?php endif; ?> <form method="POST" enctype="multipart/form-data"><input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <input type="hidden" name="action" value="add">
      <div class="mb-3">

        <label class="form-label">Title</label> <input type="text" name="blog_title" class="form-control" value="<?= htmlspecialchars($_POST['blog_title'] ?? '') ?>">

      </div>
      <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="blog_cat_id" class="form-select">
          <option value="">-- Select --</option>
          <?php foreach ($cats as $c): ?>
            <option value="<?= $c['id'] ?>" <?php if (($c['id']) == ($_POST['blog_cat_id'] ?? '')) echo 'selected'; ?>>
              <?= htmlspecialchars($c['cat_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Short Description</label>
        <textarea name="short_description" class="form-control" rows="3"><?= htmlspecialchars($_POST['short_description'] ?? '') ?></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Full Blog Content</label>
        <textarea name="blog_content" id="editor"><?= htmlspecialchars($_POST['blog_content'] ?? '') ?></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Thumbnail (Optional)</label>
        <input type="file" name="thumbnail" class="form-control">
      </div><button type="submit" class="btn btn-primary">Save</button> <button type="button" onclick="window.history.back()" class="btn btn-warning">Go Back</button>

    </form>
  </div>
  <script>
    ClassicEditor
      .create(document.querySelector('#editor'), {
        ckfinder: {
          uploadUrl: 'pages/upload.php?csrf_token=<?= $csrf_token ?>' // Correct path
        }
      })
      .catch(error => {
        console.error(error);
      });
  </script>
