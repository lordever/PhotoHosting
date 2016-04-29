<?php
session_start();
$_SESSION["s_id"] = 3;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Succes load of image</title>
	<style>
		#wrapper{
			margin:20px auto;
			outline:2px solid red;
			width:600px;
			height:100px;
			text-align:center;
		}
	</style>
</head>
<body>
	<div id="wrapper">
		<h1>
			Изображения успешно загружены!
		</h2>
		<p><a href="Main.php">Return to main</a></p>
	</div>
</body>
</html>


