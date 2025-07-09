<?php
require_once __DIR__ . '/../class.user.php';

session_start(); // ✅ Required to access $_SESSION['csrf_token']

// CSRF token validation
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo "Invalid CSRF token.";
    exit;
}

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo "Invalid message ID.";
    exit;
}

$id = (int) $_POST['id'];

try {
    $user = new USER();
    $pdo = $user->getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("DELETE FROM message WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount()) {
        echo "success"; // ✅ This must exactly match the JS condition
    } else {
        echo "Message not found or already deleted.";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
