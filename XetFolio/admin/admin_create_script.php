<?php

try 
{
	$conn = new PDO("mysql:host=0.0.0.0;dbname=portfolio","root","root");
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$password = password_hash('09876543', PASSWORD_DEFAULT);

	$sql = "INSERT INTO admin (username, email, pass, status) VALUES (:uname, :email, :pass, 'active')";

	$stmt = $conn->prepare($sql);
	$stmt->execute([

		':uname' => 'admin',
		':email' => 'eshasan1287005@gmail.com',
		':pass' => $password
	]);

	echo "Admin user created successfully";
} 
catch (PDOException $e) 
{
	echo "DB Error:".$e->getMessage();
}

?>