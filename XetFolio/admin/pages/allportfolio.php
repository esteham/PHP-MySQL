<?php
$success_add   = $update_port = null;
try {
    $db  = new USER();
    $pdo = $db->getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'success') {
        $success_add = 'Portfolio Added successfully';
    } elseif ($_GET['msg'] === 'updated') {
        $update_port = 'Portfolio updated successfully.';
    }
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];


// Display delete success message if exists
if (isset($_SESSION['delete_msg'])) {
    $delete_success = $_SESSION['delete_msg'];
    unset($_SESSION['delete_msg']);
}

$perPage   = 6;
$page      = isset($_GET['pg']) && is_numeric($_GET['pg']) ? (int)$_GET['pg'] : 1;
$offset    = ($page - 1) * $perPage;
$totalStmt = $pdo->query("SELECT COUNT(*) FROM portfolio");
$totalPorts = (int)$totalStmt->fetchColumn();
$totalPages = ceil($totalPorts / $perPage);

$sql = "SELECT id, port_name AS title, port_desc AS description, port_cat AS categories, port_uploaded_name
        FROM portfolio
        ORDER BY id DESC
        LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit',  $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset,  PDO::PARAM_INT);
$stmt->execute();
$portfolios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="col-10 bg-white rounded shadow mt-4 p-4">
    <h2 class="mb-4">All Portfolio Items</h2>
    <div class="mb-3">
        <a href="index.php?page=addportfolio" class="btn btn-success">Add New Portfolio</a>
    </div>

    <?php if ($success_add || $update_port || isset($delete_success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success_add ?? $update_port ?? $delete_success ?? '') ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Categories</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($portfolios)): ?>
                    <tr>
                        <td colspan="5" class="text-center">No portfolio items found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($portfolios as $p): ?>
                        <tr id="row-<?= $p['id'] ?>">
                            <td><?= $p['id'] ?></td>
                            <td><?= htmlspecialchars($p['title']) ?></td>
                            <td><?= htmlspecialchars(mb_strlen($p['description']) > 50
                                    ? mb_substr($p['description'], 0, 50) . '...'
                                    : $p['description']) ?>
                            </td>
                            <td><?= htmlspecialchars($p['categories']) ?></td>
                            <td>
                                <a href="index.php?page=modify_portfolio&id=<?= $p['id'] ?>&pg=<?= $page ?>"
                                    class="btn btn-sm btn-warning me-1">Modify</a>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $p['id'] ?>">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?page=allportfolio&pg=<?= max(1, $page - 1) ?>">
                        Previous
                    </a>
                </li>
                <?php
                $startPage = max(1, $page - 2);
                $endPage   = min($totalPages, $page + 2);
                if ($startPage > 1): ?>
                    <li class="page-item"><a class="page-link"
                            href="index.php?page=allportfolio&pg=1">1</a></li>
                    <?php if ($startPage > 2): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for ($p = $startPage; $p <= $endPage; $p++): ?>
                    <li class="page-item <?= $p === $page ? 'active' : '' ?>">
                        <a class="page-link"
                            href="index.php?page=allportfolio&pg=<?= $p ?>"><?= $p ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($endPage < $totalPages): ?>
                    <?php if ($endPage < $totalPages - 1): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                    <li class="page-item"><a class="page-link"
                            href="index.php?page=allportfolio&pg=<?= $totalPages ?>">
                            <?= $totalPages ?></a></li>
                <?php endif; ?>

                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link"
                        href="index.php?page=allportfolio&pg=<?= min($totalPages, $page + 1) ?>">
                        Next
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<script>
    $(document).ready(function() {
        $('.btn-delete').on('click', function() {
            if (!confirm('Are you sure you want to delete this portfolio item? This action cannot be undone.')) {
                return;
            }

            var portId = $(this).data('id');
            var csrfToken = '<?= $csrf_token ?>';

            $.ajax({
                url: 'pages/deleteportfolio.php',
                method: 'POST',
                data: {
                    action: 'delete',
                    port_id: portId,
                    csrf_token: csrfToken
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('An error occurred while deleting the portfolio item.');
                }
            });
        });
    });
</script>