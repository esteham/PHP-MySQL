<?php
//session_start();

try {
    $pdo = new USER();
    $pdo = $pdo->getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed");
}

$errors = [];
$success = '';
$editMode = false;
$catName = '';
$catId = 0;

if (isset($_GET['edit'])) {
    $editMode = true;
    $catId = (int) $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM category WHERE id = :id");
    $stmt->execute([':id' => $catId]);
    $cat = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($cat) {
        $catName = $cat['cat_name'];
    } else {
        $errors[] = "Category not found.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catName = trim($_POST['cat_name']);
    if (strlen($catName) < 3) {
        $errors[] = "Category name must be at least 3 characters.";
    }

    if (empty($errors)) {
        if (isset($_POST['cat_id']) && $_POST['cat_id'] != '') {
            $stmt = $pdo->prepare("UPDATE category SET cat_name = :name WHERE id = :id");
            $stmt->execute([
                ':name' => $catName,
                ':id' => $_POST['cat_id']
            ]);
            $success = "Category updated successfully.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO category (cat_name) VALUES (:name)");
            $stmt->execute([':name' => $catName]);
            $success = "Category created successfully.";
        }
        $catName = '';
        $editMode = false;
    }
}

$categories = $pdo->query("SELECT * FROM category ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
    <div class="col-10">
        <h2><?= $editMode ? 'Update' : 'Create' ?> Category</h2><?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <?php if ($editMode): ?>
                <input type="hidden" name="cat_id" value="<?= htmlspecialchars($catId) ?>">
            <?php endif; ?>
            <div class="mb-3">
                <label for="cat_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" name="cat_name" id="cat_name" value="<?= htmlspecialchars($catName) ?>" required>
            </div>
            <button type="submit" class="btn btn-<?= $editMode ? 'warning' : 'primary' ?>">
                <?= $editMode ? 'Update' : 'Create' ?>
            </button>
            <?php if ($editMode): ?>
                <a href="category.php" class="btn btn-secondary ms-2">Cancel</a>
            <?php endif; ?>
        </form>

        <hr>
        <h4>All Categories</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= $cat['id'] ?></td>
                        <td><?= htmlspecialchars($cat['cat_name']) ?></td>
                        <td><?= $cat['created_at'] ?></td>
                        <td>
                            <a href="?edit=<?= $cat['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
