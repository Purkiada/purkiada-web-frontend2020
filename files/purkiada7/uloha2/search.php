<?php
include("include/header.php"); 
include("include/navigation.php");
?>
<html>
	<body>
		<form class="form" action="search.php" method="POST">
			<h2>Vyhledávání uživatele</h2>
			<input class="textbox" type="text" name="search" placeholder="Uživatelské jméno">
			<input class="button" type="submit" value="Hledat">
		</form>
		<div style="text-align: center; margin-top: 40px;">
			<?php
			if(isset($_POST["search"]) and $_POST["search"] == "admin") {
				echo "<h2>Informace o uživateli admin</h2>";
				echo "<div style=\"width: 400px; text-align: left; margin: 20px auto; font-size: 18px; line-height: 25px;\">";
				echo "Věk: neuvedeno</span><br>";
				echo "Bydliště: neuvedeno</span><br>";
				echo "Email: admin@codesec.xyz";
				echo "</div>";
				file_put_contents("files/" . $_SESSION["firstuser"] . "/log/adminsearched.log", "Ucastnik vyhledal uzivatele admin");
			} else if(isset($_POST["search"])) {
				echo "<h2>Tento uživatel nebyl nalezen</h2>";
			}
			?>
		</div>
	</body>
</html>
