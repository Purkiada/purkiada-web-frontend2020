<?php
	require_once("../scripts/core.php");
	$xmlTree = simplexml_load_file("../users/".$id.".xml");
	$GetPoints = $xmlTree-> points or die ("Chyba ! Nenašel jsem body uživatele !");
?>
<!doctype html>
<html lang="cs" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<title>Hardware - Sestavení­</title>
		<link rel="stylesheet" type="text/css" href="../graph/css/design.css">
	</head>
	<body>
		<aside id="loading">Prosím, počkejte než se stránka načte ...</aside>
			<section id="story">
				<p>Tuto úlohu jste už dokončil/a. Váš počet bodů je <?php echo($GetPoints);?></p>
			</section>
			<script type="text/javascript" src="../scripts/jquery-2.2.0.min.js"></script>
			<script type="text/javascript" src="../scripts/main.js"></script>
	</body>
</html>