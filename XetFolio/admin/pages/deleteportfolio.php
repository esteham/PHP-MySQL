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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    header('Content-Type: application/json; charset=UTF-8');

    // Validate CSRF token
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        exit;
    }

    // Cast portfolio ID to integer and validate
    $portId = (int)($_POST['port_id'] ?? 0);
    if ($portId <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Portfolio ID']);
        exit;
    }

    try {
        // Fetch the filename
        $stmt = $pdo->prepare("SELECT port_uploaded_name FROM portfolio WHERE id = :id");
        $stmt->execute([':id' => $portId]);
        $port_img = $stmt->fetchColumn();

        // Delete DB record
        $stmt = $pdo->prepare("DELETE FROM portfolio WHERE id = :id");
        $stmt->execute([':id' => $portId]);

        // Rename the file with "deleted_" prefix
        $date    = strtolower(date('F')) . '_' . date('d_Y_H_i');
        $oldName = __DIR__ . "/../../images/portfolio/{$port_img}";
        $newName = __DIR__ . "/../../images/portfolio/deleted_{$date}_{$port_img}";

        if (file_exists($oldName)) {
            if (rename($oldName, $newName)) {
                echo json_encode(['status' => 'success', 'message' => 'Portfolio deleted successfully']);
            } else {
                echo json_encode(['status' => 'success', 'message' => "Portfolio deleted, but couldn't rename image."]);
            }
        } else {
            echo json_encode(['status' => 'success', 'message' => "Portfolio deleted, but image not found."]);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Deletion failed']);
    }
    exit;
}

?>