<?php
// Database connection
$host = "localhost";
$dbname = "student_db";
$username = "root";
$password = "";

try {
	$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	// Setting PDO error mode
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	die("Database connection failed: " . $e->getMessage());
}

//  Add new student
if (isset($_POST['add'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];

	$stmt = $pdo->prepare("INSERT INTO students (name, email, mobile) VALUES (?, ?, ?)");
	$stmt->execute([$name, $email, $mobile]);
}

// Update student
if (isset($_POST['update'])) {
	$id = $_POST['id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];

	$stmt = $pdo->prepare("UPDATE students SET name=?, email=?, mobile=? WHERE id=?");
	$stmt->execute([$name, $email, $mobile, $id]);
}

// Delete student
if (isset($_GET['delete'])) {
	$id = $_GET['delete'];
	$stmt = $pdo->prepare("DELETE FROM students WHERE id=?");
	$stmt->execute([$id]);
}

// Load student data for editing
$editData = null;
if (isset($_GET['edit'])) {
	$id = $_GET['edit'];
	$stmt = $pdo->prepare("SELECT * FROM students WHERE id=?");
	$stmt->execute([$id]);
	$editData = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Display all student records
$stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Simple CRUD System</title>
	<style>
		body 
		{ 
			display: flex; 
			flex-direction: column; 
			align-items: center;
			font-family: Arial; 
			margin: 30px; 
			background: #f4f4f4; 
		}
		form, table 
		{ 
			width: 50%;
			background: #fff; 
			padding: 20px; 
			border-radius: 8px; 
		}
		input[type=text], input[type=email] 
		{ 
			padding: 8px; 
			width: 50%; 
			margin: 8px 0; 
		}
		input[type=submit] 
		{ 
			padding: 10px 20px; 
		}
		table 
		{ 
			border-radius: 8px;
			width: 50%; 
			border-collapse: collapse; 
			margin-top: 20px; 
		}
		th, td 
		{ 
			
			padding: 10px; 
			border: 1px solid #ccc; 
			text-align: center; 
		}
		a 
		{ 
			text-decoration: none; margin: 0 5px; 
		}
	</style>
</head>
<body>

<h2> Student Management</h2>

<!-- Form: add or edit -->
<form method="post">
	<input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>"><br>
	<label>Name:</label><br>
	<input type="text" name="name" required value="<?= $editData['name'] ?? '' ?>"><br>
	
	<label>Email:</label><br>
	<input type="email" name="email" required value="<?= $editData['email'] ?? '' ?>"><br>
	
	<label>Mobile:</label><br>
	<input type="text" name="mobile" required value="<?= $editData['mobile'] ?? '' ?>"><br>

	<?php if ($editData): ?><br>
		<input type="submit" name="update" value="Update">
		<a href="#">Cancel</a>
	<?php else: ?>
		<input type="submit" name="add" value="Add">
	<?php endif; ?>
</form>

<!--  Data table -->
<table>
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Email</th>
		<th>Mobile</th>
		<th>Action</th>
	</tr>
	<?php foreach ($students as $stu): ?>
	<tr>
		<td><?= $stu['id'] ?></td>
		<td><?= $stu['name'] ?></td>
		<td><?= $stu['email'] ?></td>
		<td><?= $stu['mobile'] ?></td>
		<td>
			<a href="?edit=<?= $stu['id'] ?>"> Edit</a>
			<a href="?delete=<?= $stu['id'] ?>" onclick="return confirm('Are you sure you want to delete?')"> Delete</a>
		</td>
	</tr>
	<?php endforeach; ?>
</table>

</body>
</html>
