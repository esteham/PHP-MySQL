<?php

trait Subscriber
{
	 function subscriberlogin()
	{
		echo "You are logged in as Subscriber<br>";
	}
}

trait Contributor
{
	 function contributorlogin()
	{
		echo "You are logged in as Contributor<br>";
	}
}

trait Author
{
	 function authorlogin()
	{
		echo "You are logged in as Author<br>";
	}
}

trait Administrator
{
	 function administratorlogin()
	{
		echo "You are logged in as Administrator<br>";
	}
}

class Member
{
	use Subscriber, Contributor, Author, Administrator;

	public function run()
	{
		$this->subscriberlogin();
		$this->contributorlogin();
		$this->authorlogin();
		$this->administratorlogin();

		echo "All member login done!";
	} 
}

$mylogin = new Member();
$mylogin->run();
//Member::run();

?>