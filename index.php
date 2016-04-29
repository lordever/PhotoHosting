<? ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hosting</title>
	<script type="text/javascript" src="lib/jquery-2.1.4.min.js"></script>
	<link re="stylesheet" type="text/css" href="styles/index.css" />
	<style>
		
		.description{
			margin:0 auto;
			border:3px solid black;
			border-radius: 10px 10px;
			width:1000px;
			height:300px;
			position:relative;
			text-align: center;
		}

		.loading{
			display:block;
			background-color: white;
			border:3px solid black;
			border-radius: 30px 30px;
			width:314px;
			height:100px;
			text-align: center;
			line-height: 100px; 
			position:absolute;
			top:237px;
			right:0px;
			text-decoration: none;
			color:black;
			font-size:32px;
		}
	</style>
</head>
<body>
	<div class="description">
		<h1>Описание</h1>
		<div>
                    <a href="view/Main.php" class="loading">Загрузка</a>
		</div>
	</div>
</body>
</html>