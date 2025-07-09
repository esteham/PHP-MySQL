<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();
session_start();

header('Content-Type: application/json; charset=UTF-8');

// CSRF validation
if (empty($_GET['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_GET['csrf_token'])) {
    echo json_encode(['error' => ['message' => 'Invalid CSRF token']]);
    exit;
}

// Check upload error
if (!isset($_FILES['upload']) || $_FILES['upload']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => ['message' => 'File upload error: ' . $_FILES['upload']['error']]]);
    exit;
}

$uploadDir = __DIR__ . '/../../images/uploads/';
if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
    echo json_encode(['error' => ['message' => 'Failed to create upload directory']]);
    exit;
}

$file = $_FILES['upload'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

if (!in_array($ext, $allowed)) {
    echo json_encode(['error' => ['message' => 'Invalid file type']]);
    exit;
}

$filename = uniqid('blog_img_') . '.' . $ext;
$destination = $uploadDir . $filename;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    echo json_encode(['error' => ['message' => 'Failed to save file']]);
    exit;
}

// Generate correct URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$basePath = $protocol . $_SERVER['HTTP_HOST'] . dirname(dirname(dirname($_SERVER['SCRIPT_NAME'])));
$url = $basePath . '/images/uploads/' . $filename;

echo json_encode([
    'uploaded' => 1,
    'url' => $url,
    'fileName' => $filename
]);
exit;
?>