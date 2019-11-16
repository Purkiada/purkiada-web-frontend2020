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
  
    <p>Dveřmi ses dostal do oblasti nouzového východu. Nacházejí se zde 2 únikové moduly. Vedle modulů je terminál sloužící k jejich vypouštění z lodi.   
    <br>Addama: Tak, a jsme u modulů. Do jednoho modulu naložíme nás dva a do druhýho strčíme tu zbraň.
    <br>Oba moduly pošleme jinam, aby nás nemohli sledovat a Tajfun si pak najdem podle souřadnic.</p>
    <p>Já to naložím a ty mezitím běž přijít na to, co s tím terminálem.</p>
  <form method="post">
    <input type="submit" name="ter" value="Podívat se na terminál">
  </form>
  <?php
    if(isset($_POST['ter'])) {
      echo "<p>Na terminálu je 6 ikon modulů, z něhož svítí už jen poslední dva které zbyly.
            <br>Po tom co se pokusíš kliknout na ikonku otevření, terminál ti oznámí, že pro operaci nemáš dostatek energie.
            <br>Budeě muset energii převést ze štítů a sekundárních zbraní.
            <br>Můžeš se pokusit převést energii manuálně vyřešením hádanky.</p>
            <p>Co chceš dělat dál?</p>".
              '<a href="hadanka3.php"><button type="button">Vyřešit hádanku</button></a>';
    }
  ?>

</body>
