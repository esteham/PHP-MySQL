<?php
//error_reporting(0);

require_once __DIR__ .'/../config/dbCon.php';

class USER
{
	private $conn;

	public function __construct()
	{
		$database = new Confi();
		$db = $database->dbConnection();
		$this->conn = $db;
	}
	public function getConnection() {
		return $this->conn;
	}
}
?>