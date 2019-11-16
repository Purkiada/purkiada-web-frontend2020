<?php  
  header("Content-type: text/html; charset=utf-8");  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Purkiáda 2014 - Soutěž v informačních a komunikačních technologiích</title>
<link rel="stylesheet" type="text/css" href="./../../css/main.css" media="screen" />
<link rel="Stylesheet" type="text/css" href="css/jpicker-1.1.6.min.css" />
  <script src="js/jquery-1.4.4.min.js" type="text/javascript"></script>
  <script src="js/jpicker-1.1.6.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(function()
      {
        $.fn.jPicker.defaults.images.clientPath='images/';
        
        $('#picker').jPicker({window:{title:'Barvy'}});
        
      });
  </script>
</head>

<body>
  <div id="hlavicka">
	   <div>
    	     <a href="/"><h1 title="Purkiáda 2014 - Soutěž v informačních a komunikačních technologiích">
        <strong>Purkiáda 2014 - Soutěž v informačních a komunikačních technologiích</strong></h1></a>
	   </div>
      <hr />
    </div>
    
  <div id="telo"> 
    <h2>1 Barevný generátor</h2>
    <p>Vaším úkolem je projít všemi kroky zadání. Budete k tomu potřebovat základní znalosti o zpracování barev v počítači. Existuje několik způsobů zápisu barvy, barva se většinou skládá ze 3 složek: 
      <ul>
        <li>Barevný model RGB se skládá ze tří základních barev: červená, zelená, modrá, každá z těchto barev může nabývat 256 hodnot (0-255). Například červená barva může být zapsána takovýmto způsobem: rgb(255, 0, 0).</li>
        <li>Další možný způsob zápisu RGB modelu je v šestnáctkové soustavě. Každá složka se převede do šestnáctkové soustavy, před barvu se vloží #, zápis červené barvy vypadá takto: #FF0000.</li>
        <li>Barevný model HSV, někdy také HSB se skládá ze složek Hue (převládající barevný tón, název odstínu barvy, hodnoty: 0-360°), Saturation (saturace, sytost barvy, odstín šedá-plně sytá, hodnoty: 0-100%), Value (hodnota jasu, přidávání černé do základní barvy, hodnoty: 0-100%). Tento model se nezapisuje do HEX čísla, ale lze jej převést pomocí vzorce do modelu RGB.</li>
      </ul>
    </p>  
    <div id="picker"></div>
    <p>
      <ol>
        <li>Výchozí barvou je zelená barva použitá v logu Purkiády. Barvu zjistěte pomocí nějakého grafického programu, zapište do generátoru barev připraveném na stránkách a do odpovědního archu zapište číslo v HEXa čísle. 1 bod</li>
        <li>Modrou složku barvy zaokrouhlete na celé stovky. 1 bod</li>
        <li>Barevnou složku Hue nastavte podle vzorce H = (S*V)/G, kde každé písmeno znamená počáteční písmeno označení barvy a desetinná místa zaokrouhlete na celá čísla. 1 bod</li>
        <li>Proveďte bitovou inverzi barvy. (Např. u každé složky RGB modelu odečtěte od 255 aktuální hodnotu) 1 bod</li>
        <li>První bajt barvy přepište nulami. (RGB model se skládá ze třech bajtů) 1 bod</li>
        <li>Přičtěte barvu v RGB: R: +30 G: -27 B:0. 1 bod</li>
        <li>Na internetu najděte podle výsledného HEXa čísla tuto barvu a její název opište. 1 bod</li>
      </ol>
      Celkem 7 bodů.
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
