<?php

class BankAccount
{
	public $accountNumber;
	public $balance;

	public function deposit($accountNumber, $amount)
	{
		echo "For account number:$accountNumber"."<br>";

		if($amount > 0)
		{
			echo "The total amount is:".$this->balance+=$amount;
			echo "<br>";
		}
	}

	public function withdraw($amount)
	{
		if($amount <= $this->balance)
		{
			echo "Withdraw amount is:".$amount."<br>";
			echo "The remaining balance is:".$this->balance-=$amount;
			return true;
		}

		return false;
	}
}

$account = new BankAccount();
$account->balance = 100;
$account->deposit(1001,200);
$account->withdraw(150);

echo "<br>";
echo "<br>";
echo "<br>";

$account2 = new BankAccount();
$account2->balance = 500;
$account2->deposit(1002,1500);
$account2->withdraw(1000);

?>