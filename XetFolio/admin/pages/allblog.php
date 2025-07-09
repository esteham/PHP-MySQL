<?php
// Start session to manage CSRF token and session data
//session_start();

$success_add = $update_blog = null;

// Database connection using the USER class
try {
  $db = new USER();
  $pdo = $db->getConnection();
  // Enable exceptions for PDO errors
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  // Return JSON error if the database connection fails
  echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
  exit;
}

if (isset($_GET['msg'])) {
  if ($_GET['msg'] == 'success') {
    $success_add = 'Blog Added successfully';
  }
  if ($_GET['msg'] == 'updated') {
    $update_blog = 'Blog updated successfully.';
  }
}

// Generate or retrieve CSRF token
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Pagination settings
$perPage = 6;
$page = isset($_GET['pg']) && is_numeric($_GET['pg']) ? (int)$_GET['pg'] : 1;
$offset = ($page - 1) * $perPage;

// Get total number of blogs for pagination
$totalStmt = $pdo->query("SELECT COUNT(*) FROM blog");
$totalBlogs = (int)$totalStmt->fetchColumn();
$totalPages = ceil($totalBlogs / $perPage);

// Fetch blog entries with related data and apply pagination
$sql = "SELECT 
            b.id, b.blog_title, b.created_date,
            c.cat_name,
            d.short_description,
            i.thumb_uploaded_name,
            v.total_view
        FROM blog b
        LEFT JOIN category c ON b.blog_cat_id = c.id
        LEFT JOIN blog_description d ON b.id = d.blog_id
        LEFT JOIN thumbnail i ON b.id = i.blog_id
        LEFT JOIN views v ON b.id = v.blog_id
        ORDER BY b.created_date DESC
        LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
  <h2>All Blogs</h2>
  <div class="btn btn-success"><a class="nav-link"
      href="index.php?page=addnewblog">Add New Blog</a></div>
  <?php if ($success_add || $update_blog): ?>
    <div class="alert alert-success" role="alert"> <?= $success_add ?? $update_blog ?> </div>
  <?php endif; ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Category</th>
        <th>Short Description</th>
        <th>Views</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($blogs as $b): ?>
        <tr id="row-<?= $b['id'] ?>">
          <td><?= $b['id'] ?></td>
          <td><?= htmlspecialchars($b['blog_title']) ?></td>
          <td><?= htmlspecialchars($b['cat_name'] ?? '---') ?></td>
          <td><?= htmlspecialchars($b['short_description'] ?? '') ?></td>
          <td><?= $b['total_view'] ?? 0 ?></td>
          <td><?= $b['created_date'] ?></td>
          <td>
            <!-- Link to modify the selected blog -->
            <a href="index.php?page=modify_blog&id=<?= $b['id'] ?>&pg=<?= $page ?>" class="btn btn-sm btn-warning me-1">Modify</a>
            <!-- Button to delete the selected blog via AJAX -->
            <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $b['id'] ?>">Delete</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table> <!-- Pagination navigation -->
  <nav aria-label="Page navigation">
    <ul class="pagination">
      <?php for ($p = 1; $p <= $totalPages; $p++): ?>
        <li class="page-item <?= $p === $page ? 'active' : '' ?>">
          <a class="page-link" href="index.php?page=allblog&pg=<?= $p ?>"><?= $p ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
</div>



<script>
$(function(){
  // Grab the CSRF token that you generated in PHP
  var csrfToken = '<?= $csrf_token ?>';

  // Delegate click handler for any delete button
  $('.btn-delete').on('click', function(){
    var $btn   = $(this);
    var blogId = $btn.data('id');

    if (!confirm('Are you sure you want to delete this blog? This cannot be undone.')) {
      return;
    }

    $.ajax({
      url: 'pages/deleteblog.php',    // ← make sure this path is correct
      method: 'POST',
      dataType: 'json',
      data: {
        action:     'delete',
        blog_id:    blogId,
        csrf_token: csrfToken
      },
      success: function(res) {
        if (res.status === 'success') {
          // Fade out & remove the table row
          $('#row-' + blogId).fadeOut(300, function(){
            $(this).remove();
          });
        } else {
          alert('Error: ' + res.message);
        }
      },
      error: function(xhr, status, error) {
        console.group('Blog Delete AJAX Error');
        console.error('Status:', status);
        console.error('Error thrown:', error);
        console.log('Response:', xhr.responseText);
        console.groupEnd();
        alert('Server error occurred. Check console for details.');
      }
    });
  });
});
</script>
