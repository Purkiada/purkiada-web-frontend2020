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
  <p>Voják má na sobě mírně poničenou bojovou vestu a menší plazmovou pistoli se třema nábojema</p>
  <form method="GET">
    <input type="submit" value="Vzít vestu, zbraň a indície" name="indicie">
    <a href="index.php"><button type="button">Jít zpátky</button></a>
  </form>
  <?php
  if(isset($_GET['indicie'])){
   echo "Vzal jsi si vestu a pistol si zasunul do pouzdra. Indicie si schoval do kapsy".'<p><a href="novyIndex.php"><button type="button">Jít ke dveřím</button></a></p>';
  }
  ?>
  </body>
</html>