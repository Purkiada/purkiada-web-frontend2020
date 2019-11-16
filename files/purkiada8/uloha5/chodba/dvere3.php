<?php
  session_start();
  ?>
  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title></title>
  <link rel="StyleSheet" type="text/css" href="../purk.css">
  </head>
  <body>

    <p>Tyto dveře jsou lehce pootevřené a zdá se, že by šly silou otevřít.
    <br> Vypadají sice těžkopádně, ale stačily by na to i ruce.
    <p>Co uděláš? </p>
  <form method="post">
    <input type="submit" value="Rozevřít dveře" name="rozv">
    <a href="index4.php"><button type=button>Jít jinam</button></a>
  </form>
  <?php
  if(isset($_POST['rozv'])){
  echo "<p>Strčil jsi obě ruce do dveří, zabral co nejsilněji umíš a dveře si rozevřel. 
        <br> Naneštěstí to tvá pravá ruka nevydržela a ty sis vykloubil rameno. 
        <br> Na druhé straně je postava vypadající jako přerostlý ještěr v mechanickém obleku.".
        '<form method="post">
            <input type="submit" value="Vytáhnout pistoli a zastřelit jej" name="pist">
            <input type="submit" value="Otočit se a utéct" name="utec">
          </form>';}
  elseif(isset($_POST['pist'])){
    echo "<p>Vytáhl jsi svou pistoli, vystřílel do něj zbytek své munice, jenže kvůli vykloubenému ramenu jsi každou střelu minul.
          <br>Ještěr ovšem vytáhl něco, co vypadá jako malé silové pole, všechny střely odrazil a pak tě rychlým pohybem srazil k zemi a probodl svým energokopím.
          <br>Zemřel jsi a vracíš se do nabídky výběru dveří. </p>".
          '<a href="index4.php"><button type=button>Vrátit se</button></a>';           
  }
  elseif(isset($_POST['utec'])){
    echo "<p>Ani ses nestačil otočit a cítíš v zádech palčivou, mrazivou bolest.
          <br>Z hrudi ti čouhá špička energokopí a umíráš. Vracíš se do nabídky výběru dveří.</p>".
          '<a href="index4.php"><button type=button>Vrátit se</button></a>';
           
  }

 
  ?>
  </body>
</html>