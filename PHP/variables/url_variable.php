<!DOCTYPE html>
<html>
<head>
	<title>Parameter Passing in URL</title>
</head>
<body>

	<?php

		$cat = "Products";
		$subcat = "Cloths";
		$srch = "Shirts";
		$next = 10;

		echo "<a href='url_values.php?choice=search&cat=$cat&subcat=$subcat&srch=$srch&page=$next'>Click Here</a>";


	?>

</body>
</html>