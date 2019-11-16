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
  <p>Na dveřích je malá klávesnice s čísly a zdají se být zamčené.
  <br>Můžeš se pokusit uhádnout kombinaci čísel nebo můžeš prohledávat dál</p>
  <p>Co chceš udělat dále?</p>
  <form method="GET">
    <input type="submit" value="Hádat kombinaci" name="hadat">
    <a href="index.php"><button type="button">Jít zpět</button></a>
  </form>
  
  <?php
  if(isset($_GET["hadat"])){
  echo '<form method="post">Zadej kód:<input type="text" name="kod">
        <br><input type="submit" name="Zadat">
        </form>';
  if(isset($_POST['Zadat'])){
    if($_POST['kod']==9486){
      echo "<p>Výborně, otevřel jsi dveře ven. Jak jimi vyjdeš, už se nebudeš moci vrátit, neboť dveře v nouzovém stavu povolují pouze jeden průchod, než se uzamknou.
            <br> Jsi si jistý, že chceš vyjít. Do záznamového archu napiš kombinaci potřebnou k otevření dveří</p>".'<br><a href="../chodba/index2.php"><button type="button">Projít dveřma</button></a>';
    }
    else{
    echo "<p>Zkus znova</p>";
    }
  }
  }
  ?>
  </body>
</html>
