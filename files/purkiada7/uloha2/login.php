<?php
session_start();


if(isset($_POST["username"]) and isset($_POST["password"])) {
	$username = $_POST["username"];
	$password = $_POST["password"];
	if($username == "admin" and $password == "adminCodeSec258") {
		$_SESSION["user"] = $username;
		file_put_contents("files/" . $_SESSION["firstuser"] . "/log/loggedadmin.log", "Ucastnik se prihlasil jako admin");
	} else {
		$incorrect = true;
	}
}

if(isset($_SESSION["user"])) {
	header("Location: index.php");
	exit();
}

include("include/header.php");
include("include/navigation.php");
?>

<html>
	<body>
		<form class="form" action="login.php" method="POST">
			<h2 style="margin-top: 20px; margin-bottom: 20px;">Přihlášení do administrace</h2>
			<input name="username" type="text" placeholder="Uživatelské jméno" class="textbox">
			<br>
			<input name="password" type="password" placeholder="Heslo" class="textbox" style="margin-top: 10px;">
			<br>
			<?php 
			if(isset($incorrect)) {
				echo "<br><h3 style=\"color: red;\">Špatné přihlašovací údaje!</h3>";
			}
			?>
			<a href="index.php"><input type="button" value="Zrušit" class="button"></a>
			<input type="submit" value="Přihlásit" class="button">
			<br><br>
			<a href="reset.php">Zapomněli jste heslo?</a>
		</form>
	</body>
</html>
