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

    <p>Calter: Dobře, myslím že jsem připraven vyrazit
    <br>Adama: Úžasný. Zbraň je ve skladišti který je za támhletěma dveřma, ale jestli se nemýlím, pořád tam okouní jeden Vor‘Gan. 
    <br>A jelikož ty máš akorát plasmovou pistolku, budem na něho muset jít oba. Nechal jsem si u sebe jeden vulkanický granát, kdyby mě náhodou jedna z těch sviní našla.
    <br>To na něho použijem.</p>
  <form method="post">
    <input type="submit" name="konc" value="Rozevřít Dveře">
  </form>
  <?php
  if(isset($_POST['konc'])){
  echo "<p>Strčil jsi obě ruce do dveří, zabral co nejsilněji umíš a dveře si rozevřel. 
        <br>Naneštěstí to tvá pravá ruka nevydržela a ty sis vykloubil rameno. 
        <br>Na druhé straně je postava vypadající jako přerostlý ještěr v mechanickém obleku.</p>
        <p>Adama: Měl sem pravdu, je to jeden z nich! Ty se do něho pokus zavrtat pár střel a já mu mezi tím hodím pod nohy překvápko.</p>
        <p>Vytáhl sis pistoli a začal do ještěra pálit. Kvůli vykloubenému ramenu jsi se netrefil ani jednou a vystřílel sis celý zásobník.
        <br>Naštěstí to trvalo akorát tak dlouho na to, aby mu Jarret hodil k nohám granát, který ještěrovi roztrhl brnění a odhodil jej mrtvého 5 metrů dozadu.</p>        
        <p>Adama: Výborně, to by bylo. Toho slizouna ani nemá cenu prohledávat. Vidím, že sis pěkně vyhodil rameno, to ti budu muset nejdřív nasadit. 
        <br>Nebudu ti mazat med kolem huby, tohle bude bolet.</p>
        <p>Jarret ti co nejrychleji nahazuje rameno, a i když se snažíš co můžeš, vykřikneš bolestí tak, že to musel slyšet celý zbytek lodi.</p> 
        <p>Tak, tohle by bylo. Pokud u sebe cokoliv měl, tak jsem to vyhodil do vzduchu společně s ním, takže ani nemá cenu ho prohledávat. 
        <br>Někde na týhle stěně by mělo být skrytý tlačítko, najdi ho.</p>".
        '<br><a href="../skladiste/index5.php"><button type=button>Hledat tlačítko</button></a>'; 
  }?>
  
  </body>
</html>