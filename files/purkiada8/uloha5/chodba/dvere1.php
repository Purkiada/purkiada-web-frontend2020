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

    <p>Přiložíš ucho ke dveřím a slyšíš slabé ale zřetelné bouchání na dveře z druhé strany. 
    <br>Dveře se zdají být na obyčejný zámek, který se otevírá stisknutím tlačítka na boku.</p>
    <p>Co uděláš? </p>
  <form method="post">
    <input type="submit" name="klep" value="Stisknout tlačítko na intercommu">
    <a href="index2.php"><button type=button>Jít jinam</button></a>
  </form>
  <?php
  if(isset($_POST['klep'])){
    echo '<form method="post">
            <input type="submit" name="pred" value="Stisknout tlačítko na otevírání dveří">
            <input type="submit" name="nepred" value="Zeptat se: Kdo tam je?">
            <a href="index2.php"><button type=button>Jít jinam</button></a>
          </form>';}
  elseif(isset($_POST['pred'])){
    echo "<p>Zdravím vojíne, jsem rád že jste tu! Sám bych se odsud asi nedostal!
          <br> Jmenuji se Jarret Adama a velím téhle kocábce. Tedy velel jsem, než z ní zbylo jen tohle.
          <br> Jak se jmenuješ a co tu děláš?</p>".
          '<form method="post">
              <input type="submit" name="preds" value="Představit se">
              <input type="submit" name="pock" value="Ať počká">
          </form>';          }
          if(isset($_POST['preds'])){
            echo "<p>Jmenuji se Dex Calter, probudil jsem se v ošetřovně a nepamatuju si nic z toho, co se stalo. 
                <br>Adama: Tak to ti rád osvětlím situaci. Naši loď přepadla skvadra Vor‘Ganské říše.
                <br>Ti slizký parchanti tu všechny zabili a loď oholili až na kost. Podle všeho tu hledali Tajfun.“ 
                <br>Calter: „Tajfun? Co to je?“ 
                <br>Adama: „Je to experimentální zbraň která by teoreticky měla bejt schopná na dálku přetížit cortelové jádro jakékoliv lodi, i těch největších křižníků.
                <br> Naštěstí jsme ji před těmi bastardy dobře schovali. Teď se odsud musíme my dva dostat pryč a tu zbraň vzít s sebou.</p>".
                 '<a href="index4.php"><button type=button>Jít jinam</button></a>';
          }
          elseif(isset($_POST['pock'])){
            echo "Dex Calter: To je jedno, přijdu později<br> 
                  Adama: Dobře, až se ti bude chtít, vrať se sem".
                  '<br><a href="index4.php"><button type=button>Jít jinam</button></a>';
              }


  elseif(isset($_POST['nepred'])){
    echo "<p>Haló? Tady kapitán Jarret Adama! Ti šmejdi mě tu odřízli a nemůžu se dostat ven! Pomůžeš mi?“ 
          <br>Co chceš dělat dál?</p>".
          '<form method="post">
              <input type="submit" name="preds" value="Stisknout tlačítko na otevírání dveří">
              <a href="index2.php"><button type=button>Jít jinam</button></a>
          </form>';
           if(isset($_POST['preds'])){
            echo "<p>Adama: Zdravím vojíne, jsem rád že jste tu! Sám bych se odsud asi nedostal! 
                <br>Já jsem velitel téhleté lodi, tedy když se ještě dala lodí nazývat. Jak se jmenuješ a co tu děláš?
                <br>Calter: Jmenuji se Dex Calter, probudil jsem se v ošetřovně a nepamatuju si nic z toho, co se stalo. 
                <br>Adama : Tak to ti rád osvětlím situaci. Naši loď přepadla skvadra Vor‘Ganské říše.
                <br> Ti slizký parchanti tu všechny zabili a loď oholili až na kost. Podle všeho tu hledali Tajfun.“ 
                <br>Calter: „Tajfun? Co to je?“ 
                <br>Adama: „Je to experimentální zbraň která by teoreticky měla bejt schopná na dálku přetížit cortelové jádro jakékoliv lodi, i těch největších křižníků.
                <br> Naštěstí jsme ji před těmi bastardy dobře schovali. Teď se odsud musíme my dva dostat pryč a tu zbraň vzít s sebou.</p>".
                '<br><a href="index4.php"><button type=button>Jít jinam</button></a>';
          }
           
  }
  ?>
  </body>
</html>