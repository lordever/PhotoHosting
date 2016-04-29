<?php
	require_once "../model/model.php";
	$code = $_GET["code"];
	$text = Image::getTextError($code);
?>