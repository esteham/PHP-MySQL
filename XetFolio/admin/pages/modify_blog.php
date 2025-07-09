<?php
header('Content-Type: text/html; charset=UTF-8');

function extractUploadImages(string $html): array
{
  $filenames = [];
  if (preg_match_all(
    '#<img[^>]+src=["\'][^"\']*/images/uploads/([^"\']+)["\']#i',
    $html,
    $m
  )) {
    $filenames = $m[1];
  }
  return array_unique($filenames);
}

try {
  $db  = new USER();
  $pdo = $db->getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  die("Database connection failed: " . $e->getMessage());
}

$blogId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($blogId <= 0) {
  header('Location: index.php?page=allblog');
  exit;
}

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

$stmt = $pdo->prepare("
    SELECT b.blog_title, b.blog_cat_id,
           d.short_description, d.full_description,
           i.thumb_uploaded_name, i.thumb_name
    FROM blog b
    LEFT JOIN blog_description d ON b.id = d.blog_id
    LEFT JOIN thumbnail i        ON b.id = i.blog_id
    WHERE b.id = :id
");
$stmt->execute([':id' => $blogId]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$blog) {
  die('Blog not found');
}

$originalImages = extractUploadImages($blog['full_description']);

$cats = $pdo
  ->query("SELECT id, cat_name FROM category ORDER BY cat_name ASC")
  ->fetchAll(PDO::FETCH_ASSOC);


$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
  if (empty($_POST['csrf_token']) || !hash_equals($csrf_token, $_POST['csrf_token'])) {
    $errors[] = 'Invalid CSRF token';
  }

  $title      = trim($_POST['blog_title'] ?? '');
  $cat_id     = (int) ($_POST['blog_cat_id'] ?? 0);
  $short_desc = trim($_POST['short_description'] ?? '');
  $content    = trim($_POST['blog_content'] ?? '');

  if ($title === '')   $errors[] = 'Title is required';
  if ($cat_id <= 0)    $errors[] = 'Please select a category';
  if ($content === '') $errors[] = 'Content is required';

  if ($short_desc === '' && $content !== '') {
    $clean = strip_tags($content);
    $short_desc = mb_strlen($clean) > 60
      ? mb_substr($clean, 0, 60) . '...'
      : $clean;
  }

  $newThumb = null;
  if (!empty($_FILES['thumbnail']['name']) && $_FILES['thumbnail']['error'] !== UPLOAD_ERR_NO_FILE) {
    $dir = __DIR__ . '/../../images/blog/';
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    $file = $_FILES['thumbnail'];
    if ($file['error'] === UPLOAD_ERR_OK) {
      $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
      $newThumb = uniqid('thumb_') . '.' . $ext;
      if (!move_uploaded_file($file['tmp_name'], $dir . $newThumb)) {
        $errors[] = 'Thumbnail upload failed';
      }
    } else {
      $errors[] = 'Thumbnail file issue';
    }
  }

  if (empty($errors)) {
    try {
      $origImages = json_decode($_POST['orig_images'] ?? '[]', true);
      $newImages  = extractUploadImages($content);
      $removed    = array_diff($origImages, $newImages);

      $uploadsDir = __DIR__ . '/../../images/uploads/';
      $dateStr    = date('Ymd_His');

      foreach ($removed as $oldName) {
        $oldPath = $uploadsDir . basename($oldName);
        if (file_exists($oldPath)) {
          $newName = "delete_{$dateStr}_" . basename($oldName);
          rename($oldPath, $uploadsDir . $newName);
        }
      }

      $pdo->prepare(
        "UPDATE blog
                    SET blog_title  = :title,
                        blog_cat_id = :cat
                  WHERE id = :id"
      )->execute([
        ':title' => $title,
        ':cat'   => $cat_id,
        ':id'    => $blogId
      ]);

      $pdo->prepare(
        "UPDATE blog_description
                    SET short_description = :short,
                        full_description  = :full
                  WHERE blog_id = :id"
      )->execute([
        ':short' => $short_desc,
        ':full'  => $content,
        ':id'    => $blogId
      ]);

      if ($newThumb) {
        $date = strtolower(date('F')) . '_' . date('d_Y_H_i');
        if (!empty($blog['thumb_uploaded_name'])) {
          $old = __DIR__ . '/../../images/blog/' . $blog['thumb_uploaded_name'];
          if (file_exists($old)) {
            $backup = __DIR__ . '/../../images/blog/backup_'
              . $date . '_' . $blog['thumb_uploaded_name'];
            rename($old, $backup);
          }
        }

        $exists = $pdo
          ->prepare("SELECT COUNT(*) FROM thumbnail WHERE blog_id = :id");
        $exists->execute([':id' => $blogId]);

        if ($exists->fetchColumn() > 0) {
          $pdo->prepare(
            "UPDATE thumbnail
                            SET thumb_name          = :orig,
                                thumb_uploaded_name = :new
                          WHERE blog_id = :id"
          )->execute([
            ':orig' => $blog['thumb_name'] ?? $_FILES['thumbnail']['name'],
            ':new'  => $newThumb,
            ':id'   => $blogId
          ]);
        } else {
          $pdo->prepare(
            "INSERT INTO thumbnail
                            (blog_id, thumb_name, thumb_uploaded_name)
                         VALUES
                            (:id, :orig, :new)"
          )->execute([
            ':id'   => $blogId,
            ':orig' => $_FILES['thumbnail']['name'],
            ':new'  => $newThumb
          ]);
        }
      }

      header('Location: index.php?page=allblog&msg=updated');
      exit;
    } catch (Exception $e) {
      $errors[] = 'Database error: ' . $e->getMessage();
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Modify Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
  <div class="container col-10">
    <h2 class="mb-4">Modify Blog</h2>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul>
          <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="orig_images"
        value="<?= htmlspecialchars(json_encode($originalImages), ENT_QUOTES) ?>">

      <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="blog_title" class="form-control"
          value="<?= htmlspecialchars($_POST['blog_title'] ?? $blog['blog_title']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="blog_cat_id" class="form-select">
          <option value="">-- Select --</option>
          <?php foreach ($cats as $c): ?>
            <option value="<?= $c['id'] ?>"

              <?= ((int)($_POST['blog_cat_id'] ?? $blog['blog_cat_id']) === $c['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($c['cat_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Short Description</label>
        <textarea name="short_description" class="form-control" rows="3"><?= htmlspecialchars($_POST['short_description'] ?? $blog['short_description']) ?></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Full Blog Content</label>
        <textarea name="blog_content" id="editor"><?= htmlspecialchars($_POST['blog_content'] ?? $blog['full_description']) ?></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Thumbnail (Optional)</label>
        <?php if (!empty($blog['thumb_uploaded_name'])): ?>
          <div class="mb-2">
            <img src="../../images/blog/<?= htmlspecialchars($blog['thumb_uploaded_name']) ?>"
              alt="Current thumbnail" style="max-width:150px;">
          </div>
        <?php endif; ?>
        <input type="file" name="thumbnail" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary">Update</button>
      <button type="button" onclick="history.back()" class="btn btn-secondary">Go Back</button>
    </form>
  </div>

  <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
  <script>
    ClassicEditor
      .create(document.querySelector('#editor'), {
        ckfinder: {
          uploadUrl: 'pages/upload.php?csrf_token=<?= $csrf_token ?>'
        }
      })
      .catch(error => console.error(error));
  </script>
</body>

</html>