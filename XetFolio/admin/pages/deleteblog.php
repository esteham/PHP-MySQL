<?php
session_start();
require_once __DIR__ . '/../class.user.php';
try {
    $db  = new USER();
    $pdo = $db->getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

// Handle AJAX delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    // Validate CSRF token
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        exit;
    }

    // Cast blog ID to integer and validate
    $blogId = (int)($_POST['blog_id'] ?? 0);
    if ($blogId <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid blog ID']);
        exit;
    }

    // Attempt to delete the blog entry
    try {
        $stmt = $pdo->prepare("SELECT thumb_uploaded_name
        FROM thumbnail
        WHERE blog_id = :id");
        $stmt->execute([':id' => $blogId]);
        $blog_img = $stmt->fetchColumn();

        $stmt = $pdo->prepare("DELETE FROM blog WHERE id = :id");
        $stmt->execute([':id' => $blogId]);

        $date = strtolower(date('F')) . '_' . date('d_Y_H_i');


        $oldName = __DIR__ . "/../../images/blog/" . $blog_img;
        $newName = __DIR__ . "/../../images/blog/deleted_" . $date . "_" . $blog_img;

        if (file_exists($oldName)) {
            if (rename($oldName, $newName)) {
                echo json_encode(['status' => 'success', 'message' => 'Blog deleted successfully']);
            } else {
                echo json_encode(['status' => 'success', 'message' => 'Blog deleted successfully but couldn\'t delete photo.']);
            }
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Blog deleted successfully but img couldn\'t found.']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Deletion failed']);
    }
    exit;
}
