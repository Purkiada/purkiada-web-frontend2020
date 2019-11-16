<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Purkiáda 2015 - Soutěž v informačních a komunikačních technologiích</title>
    <link rel="stylesheet" type="text/css" href="http://purkiada.sspbrno.cz/css/main.css" media="screen">
    
</head>

  <body>
  <div id="hlavicka">
	<div>
    	<a href="/"><h1 title="Purkiáda 2015 - Soutěž v informačních a komunikačních technologiích">
        <strong>Purkiáda 2015 - Soutěž v informačních a komunikačních technologiích</strong></h1></a>               
	</div>
    <hr>
</div>

<div id="telo">
    <h2>5 Omalovánky</h2>
    <h3>Podklad pro úlohu:</h3>
    <p>Podklad pro úlohu stáhněte do své složky, kterou si vytvoříte v dokumentech.<br>
    <a href="omalovanky.png" download>Stáhnout</a></p>

    <h3>Zadání:</h3>
    Podklad pro úlohu si otevřete v programu malování. Níže naleznete všechny informace k správnému vybarvení obrázku. Obrázek nemusíte vybarvovat ve stejném pořadí. Za každou správně vybarvenou plochu jsou body, nahrávejte i rozdělané práce. Soubor ukládejte ve formátu .png!

    <ol>
	    <li>
		    <strong>Omítka školy:</strong><br>
			Začneme jednoduše, stačí zapnout malování a vybarvit fasádu naší školy...<br>
			Barvu jsem zapsal v modelu RGB, tady jsou její barevné složky:
			<ul>
				<li>Red: 172</li>
				<li>Green: 213</li>
				<li>Blue: 235</li>
			</ul>
		</li>
		<li>
			<strong>Cedule s názvem školy nad vchodem:</strong><br>
			Na webu jsou většinou barvy zapsané v šestnáctkové soustavě, kdy černá vypadá takto #<span style="color:red">00</span><span style="color:green">00</span><span style="color:blue">00</span> a například bílá vypadá takto #<span style="color:red">FF</span><span style="color:green">FF</span><span style="color:blue">FF</span>. Tady je zrovna jedna, s ní je potřeba vybarvit ceduli s názvem naší školy nad vchodem:
			<ul>
				<li>#<span style="color:red">E6</span><span style="color:green">E3</span><span style="color:blue">DF</span></li>
			</ul>
		</li>
		<li>
			<strong>Sloupky mezi okny:</strong><br>
			Možná jste si všimli, že některé sloupky mezi okny jsou barevné. Některé modré, některé zelené. Teď přišla řada na ně, můžete použít předlohu níže, abyste barvy nepopletli. Barvy získáte na následujících odkazech.
			<ul>
				<li>Zelené sloupky:<br><a href="http://purkiada.sspbrno.cz/rocnik2015/uloha5/barva">http://purkiada.sspbrno.cz/rocnik2015/uloha5/barva</a></li>
				<li>Modré sloupky:<br><a href="http://purkiada.sspbrno.cz/rocnik2015/uloha5/negativ">http://purkiada.sspbrno.cz/rocnik2015/uloha5/negativ</a></li>
			</ul>	
		</li>
		<li>
			<strong>Obloha:</strong><br>
			Barva může mít i svůj název. Pokud vyluštíte křížovku v záznamovém archu, vyjde vám název barvy. Barvu z křížovky použijte k vybarvení nebe.
		</li>
	</ol>

	<h3>Předloha:</h3>
	<img src="skola.jpg" width="750" height="500" alt="Pokud nevidíte obrázek, nahlašte nám to">
	<br><br>

	<A id="upload"></a>
    <?php 
      include ("./nahravani/VstupniForm.php"); 
      if (isset($_GET['stav'])) VstupniForm::$stav = $_GET['stav'];
      VstupniForm::zobrazInfo(VstupniForm::$stav);       
      VstupniForm::zobrazFormular();      
    ?>    
      <p>
    <ul>
      <li>Soubor nahrávejte ve formátu .png.</li>
      <li>Po nahrání ponechte soubory v PC pro případné dohledání.</li>
      <li>Pokud nahrajete jednu úlohu vícekrát, nepřepíše se, ale uloží se všechny verze s číslem verze.</li>
      <li>Nahrajte i soubor, který není dokončený, můžete dostat alespoň část bodů.</li>
      <li>Zkontrolujte si, zda byl soubor úspěšně nahrán</li>
    </ul>    
      
    <div>
        <p><a href="./../"><strong>Zpět na rozcestník</strong></a></p>
  </div>
  
    <br>
      
</div>
<div id="konec">
	<div>
    <a href="http://www.sspbrno.cz/" title="Stránky školy" target="_blank"><img src="http://purkiada.sspbrno.cz/obrazky/logo_spseit.png" title="Logo školy" alt="SPSEIT" height="40" style="float: left;"></a>
    <p>&copy; Střední průmyslová škola elektrotechnická a informačních technologií Brno</p>
  </div>
</div> 
    
  </body>
</html>