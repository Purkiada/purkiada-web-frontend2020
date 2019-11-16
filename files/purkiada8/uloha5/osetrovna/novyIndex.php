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
  <br>Můžeš se pokusit uhádnout kombinaci ze série indicií, které se nacházejí na lístečku,
  <br>který jsi našel u mrtvého vojáka, nebo můžeš rozstřelit zámek pistolí, ale vyplýtváš si tak jeden náboj do ní.</p>
  <p>Co chceš udělat dále?</p>
  <form method="GET">
    <input type="submit" value="Podivat se na indicie" name="indicie">
  </form>
 
  <?php
  if(isset($_GET["indicie"])){
  echo "<p>Kombinace se skládá ze čtyř číslic. Samotné číslice nevíš, ale víš toto z papírku od vojáka:
        <br>1. číslice se nachází na číselné ose mezi 8 a 10 
        <br>2. číslice se rovná druhé odmocnině z 256-ti dělené čtyřmi
        <br>3. číslice se nachází na číselné ose mezi 2. a 1. číslicí a je sudá
        <br>4. číslice po otočení hlavou dolů má hodnotu vyšší o 3 
        <br>Žádná číslice se neopakuje</p>".'<form method="post">
        Zadej kód:<input type="text" name="kod" style=" margin: auto; border-color:green; width: 15%; margin-left:37.37%;">
        <br><input type="submit" name="Zadat">
        </form>';
  if(isset($_POST['Zadat'])){
    if($_POST['kod']==9486){
      echo "Výborně, otevřel jsi dveře ven. Jak jimi vyjdeš, už se nebudeš moci vrátit, neboť dveře v nouzovém stavu povolují pouze jeden průchod, než se uzamknou.
            <br>Jsi si jistý, že chceš vyjít? ".'<br><a href="../chodba/index2.php"><button type="button">Projít dveřmi</button></a>';
    }
    else{
    echo "<p>Zkus to znovu</p>";
    }
  }
  }
  ?>
  </body>
</html>
