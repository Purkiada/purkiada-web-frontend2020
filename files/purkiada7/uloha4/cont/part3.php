<?php
	require_once("../scripts/core.php");
	zabPodvod(2)
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
		<section id="worktable">
			<article id="story">
				<p>Jelikož James Bond neumí s počítači, budete mu muset pomoct si jeden postavit. </p>
				<p id="zadani">Klikněte na místo kde by měl být processor </p>
			</article>
			<article id="workspace">
				<img src="../graph/img/sel_mot.png" alt="Základní deska" usemap="#map"/>
				<map name="Map" id="Map">
					<area alt="Obrázek k třetí úloze" NOHREF shape="rect" coords="377,184,511,304" id="first"/>
					<area alt="Obrázek k třetí úloze" NOHREF shape="rect" coords="212,370,517,393" id="second"/>
					<area alt="Obrázek k třetí úloze" NOHREF shape="rect" coords="178,157,200,322" id="third"/>
					<area alt="Obrázek k třetí úloze" NOHREF shape="rect" coords="47,106,161,293" id="fourth"/>
				</map>
			</article>
			<script type="text/javascript" src="../scripts/jquery-2.2.0.min.js"></script>
			<script type="text/javascript" src="../scripts/main.js"></script>
			<script type="text/javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
			<script type="text/javascript" src="../scripts/game.js"></script>
		</section>
	</body>
</html>