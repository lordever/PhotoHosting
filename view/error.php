<? ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hosting</title>
	<style>
	h1, p{
		text-align:center;
	}

	table{
		margin:0 auto;
	}
	</style>
</head>
<body>
	<h1>Error at loading image</h1>
	<?php
		require_once "../constructor/show_error.php";
	?>
	<p>Code of error: <b><?=$code?></b></p>
	<p>Text of error: <b><?=$text?></b></p>
	<p>
            <a href="../view/Main.php">Return to main</a>
	</p>
</body>
</html>