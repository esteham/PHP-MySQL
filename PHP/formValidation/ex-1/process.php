<?php


	// চেক করা হচ্ছে যে ফর্মটি POST মেথড ব্যবহার করে সাবমিট করা হয়েছে কিনা
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		// ইউজারের ইনপুট সংগ্রহ করা হচ্ছে এবং XSS (Cross-Site Scripting) থেকে বাঁচতে `htmlspecialchars()` ব্যবহার করা হচ্ছে
		$name = htmlspecialchars($_POST["name"]);  
		$email = htmlspecialchars($_POST["email"]);  
		$message = htmlspecialchars($_POST["message"]);  

		// ইউজারের দেওয়া ইনপুট ব্রাউজারে দেখানো হচ্ছে
		echo "<h2>Submitted Information:</h2>";
		echo "Name: " . $name . "<br>";  
		echo "Email: " . $email . "<br>";  
		echo "Message: " . $message . "<br>";  

	} 
	else 
	{
		// যদি কেউ ফর্ম সাবমিট না করে, তাহলে এই বার্তাটি দেখানো হবে
		echo "Please fill out the form!";
	}
	
	
?>
