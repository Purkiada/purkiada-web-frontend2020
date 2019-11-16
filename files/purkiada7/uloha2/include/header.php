<?php
if(session_id() == "") {
    session_start();
}

if(isset($_SESSION["firstuser"]) and is_file("files/" . $_SESSION["firstuser"] . "/log/edited.log") and basename($_SERVER["PHP_SELF"]) != "purkiada.php") {
	header("Location: purkiada.php");
	exit();
}

if(!isset($_SESSION["firstuser"]) and basename($_SERVER["PHP_SELF"]) != "purkiada.php") {
	header("Location: purkiada.php");
	exit();
}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>CodeSec</title>
		<link rel="shortcut icon" href="images/icon.png">
		<link rel="stylesheet" href="http://resources.codetopic.eu/web/css/custom.css">
		<link rel="stylesheet" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	</head>
</html>
