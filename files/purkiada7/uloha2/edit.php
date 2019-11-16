<?php
session_start();

$file = "files/" . $_SESSION["firstuser"] . "/texts/" . $_GET["id"];

if(isset($_POST["text"]) and is_file($file . $_POST["id"])) {
	file_put_contents($file . $_POST["id"], $_POST["text"]);
	if($_POST["id"] == "edit.txt" and strpos($_POST["text"], "15:00") == true) {
		file_put_contents("files/" . $_SESSION["firstuser"] . "/log/edited.log", "Ucastnik upravil clanek");
	}
	header("Location: index.php");
	exit();
}

include("include/header.php"); 
include("include/navigation.php");
?>
<html>
	<body>
		<?php
		if(!is_file($file)) {
			echo "<h2 style=\"text-align: center;\">Tento článek nebyl nalezen!</h2>";
			echo "</body></html>";
			exit();
		}
		?>
		<form class="form" action="edit.php" method="POST">
			<h2>Editor článku</h2>
			<br>
			<textarea class="textbox" style="width: 40%; height: 40%; white-space:nowrap; overflow:scroll;" name="text"><?php readfile($file); ?></textarea>
			<br>
			<input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
			<a href="index.php"><input type="button" value="Zrušit" class="button"></a>
			<input class="button" type="submit" value="Upravit">
		</form>
	</body>
</html>
