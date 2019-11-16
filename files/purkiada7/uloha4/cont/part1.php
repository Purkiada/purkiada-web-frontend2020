<?php
	require_once("../scripts/core.php");
	zabPodvod(0)
?>
<!doctype html>
<html lang="cs" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<title>Hardware - Sestavení­</title>
		<link rel="stylesheet" type="text/css" href="../graph/css/design.css">
	</head>
	<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
		<aside id="loading">Prosím, počkejte než se stránka načte ...</aside>
		<section id="worktable">
			<article id="story">
				<p>Jelikož James Bond neumí s počítači, budeš mu muset pomoct si jeden postavit</p>
				<p id="zadani">Přetáhni ikonu dlaně na processor</p>
			</article>
			<article id="workspace">
				<table align="center">
					<tr>
						<td><img src="../graph/img/ukazovatko.png" class="task-img" id="draggable" alt="Ukazovátko"></td>
						<td class="droppable ui-widget-header" id="1"><img src="../graph/img/hdmi.png" id="first" alt="Obrázek k úloze 1"></td>
						<td class="droppable ui-widget-header" id="2"><img src="../graph/img/cpu.png" id="second" alt="Obrázek k úloze 1"></td>
						<td class="droppable ui-widget-header" id="3"><img src="../graph/img/jack.png" id="third"  alt="Obrázek k úloze 1"></td>
						<td class="droppable ui-widget-header" id="4"><img src="../graph/img/graph.png" id="fourth" alt="Obrázek k úloze 1"></td>
					</tr>
				</table>	
			</article>
			<script type="text/javascript" src="../scripts/jquery-2.2.0.min.js"></script>
			<script type="text/javascript" src="../scripts/main.js"></script>
			<script type="text/javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
			<script type="text/javascript" src="../scripts/game.js"></script>
		</section>
	</body>
</html>