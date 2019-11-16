<?php
session_start();

if(isset($_POST["username"])) {
	include("include/database.php");
	$username = $_POST["username"];
	$stmt = $conn->prepare("SELECT * FROM `purkiada` WHERE `login` = ?");
    $stmt->execute(array($username));
    
    if(count($stmt->fetchAll()) == 1) {
    	$userpath = "files/" . $username;
		if (!is_dir($userpath)) {
			mkdir($userpath);
			mkdir($userpath . "/texts");
			mkdir($userpath . "/log");
			foreach(glob("texts/*.txt") as $file) {
				copy($file, $userpath . "/" . $file);
			}
		}
		$_SESSION["firstuser"] = $username;
	 } elseif($username == "test") {
	 	$userpath = "files/" . $username;
		if (!is_dir($userpath)) {
			mkdir($userpath);
			mkdir($userpath . "/texts");
			mkdir($userpath . "/log");
			foreach(glob("texts/*.txt") as $file) {
				copy($file, $userpath . "/" . $file);
			}
		}
		$_SESSION["firstuser"] = $username;
	 } else {
		$incorrect = true;
	}
}

if(isset($_SESSION["firstuser"]) and !is_file("files/" . $_SESSION["firstuser"] . "/log/edited.log")) {
	header("Location: index.php");
	exit();
}

include("include/header.php");
?>

<html>
	<body style="background-color: green;">
		<div class="purkiadalogin">
			<form style="margin: 0px auto; text-align: center; padding-bottom: 10px;" action="purkiada.php" method="POST">
				<h2 style="font-size: 72px; margin-bottom: 20px; color: white;">Purkiáda</h2>
				<input name="username" type="text" placeholder="Uživatelské jméno" class="textbox">
				<br>
				<?php 
				if(isset($incorrect)) {
					echo "<br><h3 style=\"color: cyan;\">Špatné přihlašovací údaje!</h3>";
				}
				?>
				<input type="submit" value="Pokračovat" class="buttonAnimated">
				<br><br><br>
				<h2 style="font-size: 24px; margin-bottom: 10px; color: white;">Vaším úkolem bude získat přihlašovací údaje účtu admin a upravit článek</h2>
			</form>
			<?php 
			if(isset($_SESSION["firstuser"]) and is_file("files/" . $_SESSION["firstuser"] . "/log/edited.log")) {
				echo "<script>$(\"form\").hide();</script>";
				echo "<div style=\"margin: 0px auto; text-align: center; padding-bottom: 10px;\">" .
					"<h2 style=\"font-size: 64px; margin-bottom: 20px; color: white;\">Výborně, dokončil jsi tento úkol...</h2>" .
					"<span style=\"font-size: 32px; color: white;\">a získal jsi <span style=\"color: gold;\">10 bodů</span>!</span>" .
					"</div>";
			}
			?>
			
		</div>
	</body>
</html>
