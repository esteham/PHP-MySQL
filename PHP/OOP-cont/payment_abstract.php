<?php

abstract class PaymentGateway
{
	protected $amount;

	public function __construct($amount)
	{
		$this->amount = $amount;
	}

	abstract public function processPayment();

	public function paymentSuccess()
	{
		return "Payment of {$this->amount} BDT is successfull";
	}
}

class BkashPayment extends PaymentGateway
{
	public function processPayment()
	{
		return "Processing bkash payment of {$this->amount} BDT...";
	}
}

class NagadPayment extends PaymentGateway
{
	public function processPayment()
	{
		return "Processing Nagad payment of {$this->amount} BDT...";
	}
}


class RocketPayment extends PaymentGateway
{
	public function processPayment()
	{
		return "Processing Rocket payment of {$this->amount} BDT...";
	}
}

$bkash = new BkashPayment(1000);
echo $bkash->processPayment(). "<br>";
echo $bkash->paymentSuccess()."<br>";

$nagad = new NagadPayment(500);
echo $nagad->processPayment(). "<br>";
echo $nagad->paymentSuccess()."<br>";

$rocket = new RocketPayment(2000);
echo $rocket->processPayment(). "<br>";
echo $rocket->paymentSuccess()."<br>";
?>