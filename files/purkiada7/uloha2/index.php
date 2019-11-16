<?php 
include("include/header.php"); 
include("include/navigation.php"); 
?>
<html>
	<body>
		<?php
		if(isset($_SESSION["firstuser"])) {
			foreach(glob("./files/" . $_SESSION["firstuser"] . "/texts/*.txt") as $file) {
				echo "<div class=\"text\">";
				echo nl2br(htmlspecialchars(file_get_contents($file)));
				echo "<br><br><span class=\"textAuthor\">Autor článku: admin</span>";
				if(isset($_SESSION["user"]) and $_SESSION["user"] == "admin") {
					echo "<a href=\"edit.php?id=" . basename($file) . "\" style=\"float: right;\">Upravit článek</a>";
				}
				echo "</div>";
			}
		} else {
			foreach(glob("./texts/*.txt") as $file) {
				echo "<div class=\"text\">";
				echo nl2br(htmlspecialchars(file_get_contents($file)));
				echo "<br><br><span class=\"textAuthor\">Autor článku: admin</span></div>";
			}
		}
		?>
	</body>
</html>
