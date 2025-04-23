<!DOCTYPE html>
<html>
<head>
    <title>Username Validator</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #e3f2fd;
            display: flex;
            justify-content: center;

        }
        .form-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-box h3 {
            font-weight: 600;
        }
        .alert-success {
            background-color: #0a7d00 !important;
            color: #ffff;
        }
        .alert-danger {
            background-color: #b30000 !important;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h3 class="text-center mb-4">Username Validator</h3>
    <form method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Enter username:</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Check Username</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST["username"]);

        if (strpos($username, '@') === false) {
            echo '<div class="alert alert-danger mt-3"> Username must contain the "@" symbol.</div>';
        } else {
            $parts = explode('@', $username);
            $beforeAt = $parts[0];

            if (strlen($beforeAt) < 4 || strlen($beforeAt) > 8) {
                echo '<div class="alert alert-danger mt-3">The part before "@" must be 4 to 8 characters long.</div>';
            } else {
                echo '<div class="alert alert-success mt-3">Valid username: ' . htmlspecialchars($username) . '</div>';
            }
        }
    }
    ?>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
