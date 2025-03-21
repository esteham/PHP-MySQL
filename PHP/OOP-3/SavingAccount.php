<?php

class BankAccount
{
	private $balance;

	public function getBalance()
	{
		return $this->balance;
	}

	public function deposit($amount)
	{
		if($amount > 0)
		{
			$this->balance += $amount;
		}

		return $this;
	}

	public function isGreaterThanOneYear()
	{
		$givenDateTime = new DateTime($this->givenDate);
		$currentDateTime = new DateTime();

		$interval = $currentDateTime->diff($givenDateTime);

		if($interval->y > 1 || ($interval->y == 1 && $interval->m > 0) || ($interval->y ==1 && $interval->m == 0 && $interval->d > 0))
		{
			return true;
		}

		else
		{
			return false;
		}
	}
}

class SavingAccount extends BankAccount
{
	private $interestRate;
	public $givenDate = "2024-02-18";

	public function calcAnualFee()
	{
		if($this->isGreaterThanOneYear())
		{
			if($this->getBalance() > 200 )
			{
				echo "Your Anual Fee of BDT.200 has been adjusted from your account";
				$newBalance = ($this->getBalance() - 200);
				echo "Your C/B is: ".$newBalance;
			}

			else
			{

			}
		}
	}

	public function setInterestRate($interestRate)
	{
		$this->interestRate = $interestRate;
	}

	public function addInterest()
	{
		$interest = $this->interestRate * $this->getBalance();
		$this->deposit($interest);
	}
}


?>