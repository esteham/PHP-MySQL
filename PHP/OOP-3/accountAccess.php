<?php
require 'SavingAccount.php';

$account = new SavingAccount();

$account->deposit(500);
$account->setInterestRate(0.05);
$account->addInterest();

echo "Account Balance with Interest rate is: ".$account->getBalance()."<br>";
$account->calcAnualFee();


?>