<?php

// এরর রিপোর্টিং বন্ধ করা হয়েছে যাতে ব্যবহারকারীর কাছে PHP এরর মেসেজ না দেখা যায়
error_reporting(0);

// আবহাওয়া এবং এরর মেসেজের জন্য দুইটি ফাঁকা ভেরিয়েবল তৈরি করা হয়েছে
$weather = "";
$error = "";

// বাংলাদেশ সময় অনুযায়ী বর্তমান সময় সেট করা হয়েছে
$dt = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

// যদি ইউজার city নামে একটি GET প্যারামিটার পাঠায়
if($_GET['city'])
{
	// API থেকে JSON ডেটা সংগ্রহ করা হচ্ছে, যেখানে ইউজার দ্বারা দেয়া সিটির নাম যুক্ত করা হয়েছে
	$urlContent = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".urlencode($_GET['city'])."&appid=e671e2ef52d67bcec7a25da21cbcfc77");

	// JSON ডেটাকে PHP অ্যারে তে কনভার্ট করা হচ্ছে
	$weatherArray = json_decode( $urlContent, true);

	// যদি API রেসপন্সের কোড 200 হয় (মানে ডেটা পাওয়া গেছে)
	if($weatherArray['cod'] == 200)
	{
		// সিটি ও বর্তমান আবহাওয়ার বর্ণনা যোগ করা হয়েছে
		$weather = "The weather in:".$_GET['city']."is currently'".$weatherArray['weather'][0]['description']."'.";

		// কেলভিন থেকে সেলসিয়াসে তাপমাত্রা রূপান্তর করা হয়েছে
		$tempInCelcius = intval($weatherArray['main']['temp'] - 273.15);

		// তাপমাত্রা ও বাতাসের গতি যোগ করে পূর্ণ মেসেজ তৈরি করা হয়েছে
		$weather.="The Temparature is:".$tempInCelcius."&deg;C and wind speed is:".$weatherArray['wind']['speed']."m/s.";
	}
	else
	{
		// যদি সিটি পাওয়া না যায় তবে এরর মেসেজ দেখানো হবে
		$error = "Couldn't find the city-Please try again";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Weather App</title>

	<!-- Bootstrap এর JS এবং CSS ফাইল সংযুক্ত করা হয়েছে -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" />

	<!-- jQuery সংযুক্ত করা হয়েছে -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

	<style type="text/css">
		/* পুরো HTML ব্যাকগ্রাউন্ডে একটি ছবি রাখা হয়েছে */
		html {
			background: url(weather_img.jpg) no-repeat center fixed;
			-webkit-background-size: cover ;
			background-size: cover;
		}

		/* বডির ব্যাকগ্রাউন্ডকে none করা হয়েছে যাতে html এর ব্যাকগ্রাউন্ড দেখা যায় */
		body {
			background: none;
		}

		/* হেডিং এর কালার সাদা করা হয়েছে */
		h1 {
			color: white;
		}

		/* কন্টেইনার ডিভকে কেন্দ্র করে স্টাইল করা হয়েছে */
		.container {
			text-align: center;
			margin-top: 100px;
			width: 450px;
		}

		/* ইনপুট ফিল্ডের মার্জিন ঠিক করা হয়েছে */
		input {
			margin: 15px, 0; /* এখানে কমা ভুল হয়েছে, সঠিক হবে: margin: 15px 0; */
		}

		/* আবহাওয়া তথ্য দেখানোর div এর টপ মার্জিন */
		#weather {
			margin-top: 15px;
		}
	</style>
</head>

<body>

	<div class="container">
		<!-- শিরোনাম -->
		<h1>What's Today Weather</h1>

		<!-- ফর্ম তৈরি করা হয়েছে সিটি ইনপুট নেওয়ার জন্য -->
		<form>
			<fieldset>
				<legend>Enter Your City Name</legend>
				<label style="font-size: 15px;">City Name:</label>
				<input type="text" name="city" class="form-control" id="city" placeholder="Eg. Dhaka, London">
			</fieldset><br>
			<input type="submit" name="submit" class="btn btn-primary" value="Check">
		</form>

		<!-- আবহাওয়া বা এরর মেসেজ দেখানোর জন্য -->
		<div id="weather">
			<?php
				// যদি আবহাওয়ার তথ্য পাওয়া যায় তবে সফল মেসেজ দেখানো হবে
				if($weather)
				{
					echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';
				}
				// নতুবা এরর মেসেজ দেখানো হবে
				elseif ($error) 
				{
					echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
				}
			?>
		</div>

		<!-- বর্তমান সময় দেখানো হবে -->
		<?php echo $dt->format('F j,Y,g:ia'); ?>
	</div>

</body>
</html>
