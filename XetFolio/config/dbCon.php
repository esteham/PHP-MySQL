<?php
class Confi 
{
	private $host =  "localhost";
	private $db_name = "portfolio";
	private $username = "root";
	private $password = "";

	public $conn;
	public $serverdown = false;

	public function dbConnection()
	{
		$this->conn = null;

		try 
		{
			$this->conn = new PDO(
    "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
    $this->username,
    $this->password
);

		} 
		catch (PDOException $exception) 
		{
			//echo "Connection Error:".$exception->getMessage();
			$this->serverdown = true;
			//exit;
		}

		return $this->conn;
	} 
}


?>