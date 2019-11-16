<?php
	require_once("../scripts/core.php");
	zabPodvod(1)
?>
<!doctype html>
<html lang="cs" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<title>Hardware - Definice</title>
		<link rel="stylesheet" type="text/css" href="../graph/css/design.css">
		<style>
			td:nth-child(odd) {
				background: #33CC99;
			}
			td:nth-child(even) {
				background: #EEE8AA;
			}
		</style>
	</head>
	<body id="page">
		<section id='loading'>Prosím, počkejte než se stránka načte ...</section>
		<section id="game">
			<article id="story">
				<p>Výborně, pomohl jsi Bondovi poskládat počítač. Nyní je potřeba získat nějaké základní informace. </p>
				<p>Kliknutím na ikonku otazníku budete souhlasit či nesouhlasit s daným tvrzením, jakmile si budete všude jisti, klikněte na zkontrolovat.</p>
			</article>
			<section id="workspace">
				<table align="center">
					<tr>
						<td>Hardware je nehmotná část počítače</td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="prv"></td>
						<td>1 Palec má délku 2,54 cm</td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="dru"></td>
					</tr>
					<tr>
						<td>Průměr CD je 14 cm</td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="tre"></td>
						<td>CPU je jinak řečeno GPU</td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="ctv"></td>
					</tr>
					<tr>
						<td>RAM se používá pro operační paměť</td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="pat"></td>
						<td>Tiskárna je vstupní zařízení</td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="ses"></td>
					</tr>
					<tr>
						<td>1 Bajt =  8 bitů</td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="sed"></td>
						<td>Externí zařízení je pevnou součástí počítače</td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="osm"></td>
					</tr>
					<tr>
						<td>BIOS nenajdeme na základní desce</td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="dev"></td>
						<td>Na napsání čísel potřebujeme numerickou klávesnici</td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="des"></td>
					</tr>
					<tr>
						<td>1 Terabajt je 1000000 kB</td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="jed"></td>
						<td>USB 2.0 je rychlejší než USB 3.0</td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="dva"></td>
					</tr>
					<tr>
						<td>Zdroj nepatří mezi základní potřeby počítače</td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="tri"></td>
						<td>Purkiáda je na téma 007 </td><td><img src="../graph/img/otaznik.png" class="ico-decision" id="ctr"></td>
						<td onclick="CheckOut()" style="background-color:#C0C0C0"><b>Zkontrolovat</b></td>
					</tr>
				</table>
			</section>
		</section>
	<script type="text/javascript" src="../scripts/jquery-2.2.0.min.js"></script>
	<script type="text/javascript" src="../scripts/main.js"></script>
	<script type="text/javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type="text/javascript" src="../scripts/game.js"></script>
	</body>
</html>