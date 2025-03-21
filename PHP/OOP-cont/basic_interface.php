<?php

interface WebApp
{
	public function login($email, $password);
	public function register($email, $username, $password);
	public function logout();
}

class MyClass implements WebApp
{
	public function login($email, $password)
	{
		echo "Logged in user with"." ".$email."<br>";
	}

	public function register($email, $username, $password)
	{
		echo "user registration successfull with"." ".$email." "."and username"." ".$username."<br>";
	}

	public function logout()
	{
		echo "User logged out";
	}
}

$user = new MyClass();
$user->register("araman666@gmail.com","araman","araman123");
//$user->login("araman666@gmail.com","araman123");
//$user->logout();
?>

<script type="text/javascript">
	setTimeout(()=>{

		document.write('<?php $user->login("araman666@gmail.com","araman123"); ?>');

	}, 5000);
</script>