<?php  
  header("Content-type: text/html; charset=utf-8");  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Purkiáda 2014 - Soutěž v informačních a komunikačních technologiích</title>
<link rel="stylesheet" type="text/css" href="./../../css/main.css" media="screen" />
</head>

<body>
  <div id="hlavicka">
	   <div>
    	<h1 title="Purkiáda 2014 - Soutěž v informačních a komunikačních technologiích">
        <strong>Purkiáda 2014 - Soutěž v informačních a komunikačních technologiích</strong></h1>
	   </div>
      <hr />
    </div>
    
  <div id="telo"> 
    <h2>6 Tangram</h2>
    <h3>Podklad pro tangram</h3>
    <p>Podklad stáhněte do své složky, kterou si vytvořte v v Dokumentech studenta, ve složce pojmenované jako váš účastnický kód<br>
    <a href="Podklad pro tangram.png" download="Podklad pro tangram">Stáhnout</a></p>

    <p>
    <?php 
      include ("./VstupniForm.php"); 
      if (isset($_GET['stav'])) VstupniForm::$stav = $_GET['stav'];
      VstupniForm::zobrazInfo(VstupniForm::$stav);       
      VstupniForm::zobrazFormular();      
    ?>    
    </p>
      <p>
    Nahrávání souborů již není možné.
    <ul>
      <li>Po nahrání ponechte soubory v PC pro případné dohledání.</li>
      <li>Pokud nahrajete jednu úlohu vícekrát, nepřepíše se, ale uloží se všechny verze s číslem verze.</li>
      <li>Nahrajte i soubor, který není dokončený, můžete dostat alespoň část bodů.</li>
      <li>Zkontrolujte si, zda byl soubor úspěšně nahrán (pozor na maximální velikost souboru).</li>
    </ul>
    </p> 
    <p><a href="./../"><strong>Zpět na rozcestník</strong></a></li></p>
  </div>
     
 <div id="konec">  
	<div>
    <a href="http://www.sspbrno.cz/" title="Stránky školy" target="_blank"><img src="../../obrazky/logo_spseit.png" title="Logo školy" height="40" style="float: left;" /></a>
    <p>&copy; Střední průmyslová škola elektrotechnická a informačních technologií Brno</p>
  </div>
  </div>   
</body>
</html>
