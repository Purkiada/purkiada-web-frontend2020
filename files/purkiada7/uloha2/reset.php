<?php
include("include/header.php");

if(isset($_POST["email"]) and $_POST["email"] == "admin@codesec.xyz") {
	file_put_contents("files/" . $_SESSION["firstuser"] . "/log/passwordreset.log", "Ucastnik odeslal heslo admina na email (reset hesla)");
}

include("include/navigation.php");
?>
<html>
	<body>
		<form class="form" action="reset.php" method="POST">
			<h2>Obnovení hesla</h2>
			<input name="email" class="textbox" type="text" placeholder="Email uživatele">
			<input class="button" type="submit" value="Odeslat">
			<?php
			if(isset($_POST["email"])) {
				if($_POST["email"] == "admin@codesec.xyz") {
					echo "<h2 style=\"margin-top: 20px;\">Email obsahující heslo byl odeslán</h2>";
				} else {
					echo "<h2 style=\"margin-top: 20px;\">Uživatel s tímto emailem nebyl nalezen</h2>";
				}
			}
			?>
		</form>
	</body>
</html>
