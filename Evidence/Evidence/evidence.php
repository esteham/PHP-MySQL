<?php
$host = "localhost";
$dbname = "crud_db";
$dbuser = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$emailError = $phoneError = '';
$username = $email = $phone = '';

$editData = null;

// Add
if (isset($_POST['add'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $valid = true;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Please enter a valid email address.";
        $valid = false;
    }
    if (!preg_match("/^01[0-9]{9}$/", $phone)) {
        $phoneError = "Phone number must start with 01 and be exactly 11 digits.";
        $valid = false;
    }

    if ($valid) {
        $stmt = $pdo->prepare("INSERT INTO cruds (username, email, phone) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $phone]);
        $username = $email = $phone = '';
    }
}

// Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $valid = true;

   if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) 
    {
	    $emailError = "Please enter a valid email useing @";
        $valid = false;
	}

    if (!preg_match("/^01[0-9]{9}$/", $phone)) {
        $phoneError = "Phone number must start with 01 and be exactly 11 digits.";
        $valid = false;
    }

    if ($valid) {
        $stmt = $pdo->prepare("UPDATE cruds SET username=?, email=?, phone=? WHERE id=?");
        $stmt->execute([$username, $email, $phone, $id]);
        exit;
    } else {
        $editData = ['id' => $id, 'username' => $username, 'email' => $email, 'phone' => $phone];
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM cruds WHERE id=?");
    $stmt->execute([$id]);
}

// Edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM cruds WHERE id=?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get all records
$stmt = $pdo->query("SELECT * FROM cruds ORDER BY id DESC");
$cruds = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Management System</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial;
            margin: 30px;
            background: #f4f4f4;
        }
        form, table {
            width: 50%;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type=text], input[type=email] {
            padding: 8px;
            width: 90%;
            margin: 8px 0 4px 0;
        }
        input[type=submit] {
            padding: 10px 20px;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 8px;
        }
        table {
            border-radius: 8px;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        a {
            text-decoration: none;
            margin: 0 5px;
            color: blue;
        }
    </style>
</head>
<body>

<h2>CRUD</h2>

<!-- Form -->
<form method="post">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>"><br>

    <label>Username:</label><br>
    <input type="text" name="username" required value="<?= $editData['username'] ?? $username ?>"><br>

    <label>Email:</label><br>
    <input type="text" name="email" required value="<?= $editData['email'] ?? $email ?>"><br>
    <?php if ($emailError): ?><div class="error"><?= $emailError ?></div><?php endif; ?>

    <label>Phone:</label><br>
    <input type="text" name="phone" required value="<?= $editData['phone'] ?? $phone ?>"><br>
    <?php if ($phoneError): ?><div class="error"><?= $phoneError ?></div><?php endif; ?>

    <?php if ($editData): ?><br>
        <input type="submit" name="update" value="Update">
        <a href="crud.php">Cancel</a>
    <?php else: ?>
        <input type="submit" name="add" value="Add">
    <?php endif; ?>
</form>

<!-- Table -->
<table>
    <tr>

        <th>Username</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th>
    </tr>
    <?php foreach ($cruds as $stu): ?>
    <tr>
        <td><?= $stu['username'] ?></td>
        <td><?= $stu['email'] ?></td>
        <td><?= $stu['phone'] ?></td>
        <td>
            <a href="?edit=<?= $stu['id'] ?>">Edit</a>
            <a href="?delete=<?= $stu['id'] ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
