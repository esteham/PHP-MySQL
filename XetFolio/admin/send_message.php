<?php
require_once __DIR__ . '/class.user.php';
session_start();

header('Content-Type: text/html; charset=UTF-8');

// Validate CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('<div class="alert alert-danger">Invalid CSRF token.</div>');
}

// Validate form input
$to      = filter_var(trim($_POST['to']), FILTER_VALIDATE_EMAIL);
$subject = trim($_POST['subject']);
$message = trim($_POST['message']);

if (!$to || empty($subject) || empty($message)) {
    die('<div class="alert alert-danger">All fields are required and must be valid.</div>');
}

// Wrap message in HTML (basic formatting)
$htmlMessage = "
    <html>
    <head><meta charset='UTF-8'></head>
    <body style='font-family: Arial, sans-serif;'>
        <h3>You've received a message</h3>
        <p><strong>Subject:</strong> " . htmlspecialchars($subject) . "</p>
        <p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
    </body>
    </html>
";

// Send mail
$user = new USER();
$success = $user->sendMail($to, $htmlMessage, $subject);

if ($success) {
    echo '<div class="alert alert-success">Message sent successfully!</div>';
} else {
    $error = $_SESSION['mailError'] ?? 'Unknown error occurred.';
    echo '<div class="alert alert-danger">Failed to send message. Error: ' . htmlspecialchars($error) . '</div>';
}
