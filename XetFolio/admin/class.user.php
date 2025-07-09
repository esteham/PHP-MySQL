<?php
//error_reporting(0);

require_once __DIR__ . '/../config/dbCon.php';

class USER
{
	private $conn;

	public function __construct()
	{
		$database = new Confi();
		$db = $database->dbConnection();
		$this->conn = $db;
	}

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	public function lastID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}

	public function admninlogin($username, $password)
	{
		try 
		{
			$stmt = $this->conn->prepare("SELECT * FROM admin WHERE username = :user or email = :user LIMIT 1");
			$stmt->execute([':user'=>$username]);
			$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

			if($stmt->rowCount() > 0)
			{
				if(password_verify($password, $userRow['pass']))
				{
					$_SESSION['userSession'] = $userRow['id'];
					$_SESSION['status'] = $userRow['status'];
					return true;
				}
			}

			return false;
		} 
		catch (PDOException $e) 
		{
			echo "DB Error:".$e->getMessage();
			return false;
		}
	}	

	public function adminlogout() {
		session_unset();
		session_destroy();
		return true;
	}

	public function is_logged_in()
	{
		if(isset($_SESSION['userSession']) && $_SESSION['userSession'])
		{
			return true;
		}
	}

	public function logout()
	{
		session_destroy();
		$_SESSION['userSession'] = false;
	}

	public function getConnection() {
		return $this->conn;
	}	
	
	 public function sendMail($toEmail, $htmlMessage, $subject)
    {
		require_once __DIR__ . '/mailer/PHPMailer.php';
		require_once __DIR__ . '/mailer/SMTP.php';
		require_once __DIR__ . '/mailer/Exception.php';
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        //$mail->SMTPDebug  = 3;
        $mail->isSMTP();
        $mail->Host       = 'mail.Esteham H. Zihad Ansari.xyz';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mail@Esteham H. Zihad Ansari.xyz';
        $mail->Password   = 'SomeOsthirPassword';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('mail@Esteham H. Zihad Ansari.xyz', 'Esteham H. Zihad Ansari');
        $mail->addAddress($toEmail);
        $mail->addReplyTo('mail@Esteham H. Zihad Ansari.xyz', 'Esteham H. Zihad Ansari');
        $mail->isHTML(true);
        $mail->Subject = htmlspecialchars($subject);
        $mail->Body    = $htmlMessage;

        if (!$mail->send()) {
            $_SESSION['mailError'] = $mail->ErrorInfo;
            return false;
        }
        return true;
    }

}


?>