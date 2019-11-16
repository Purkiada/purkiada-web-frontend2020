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

<?php
  if(isset($_POST['nst'])){
     $_SESSION['stity']=5;
  }
  elseif(isset($_POST['ptzz'])){
      $_SESSION['stity']+=$_SESSION['zbrane'];
      $_SESSION['zbrane']-=$_SESSION['stity'];
      if($_SESSION['zbrane']<0){
          $_SESSION['zbrane']=0;
      }
      if($_SESSION['stity']>5){
          $_SESSION['zbrane']=$_SESSION['stity']-5;
          $_SESSION['stity']=5;
      }
  }
  elseif(isset($_POST['vs'])){
      $_SESSION['stity']=0;
  }
  elseif(isset($_POST['nz'])){
      $_SESSION['zbrane']+=3;
  }
  elseif(isset($_POST['ptzs'])){
      $_SESSION['zbrane']+=$_SESSION['stity'];
      $_SESSION['stity']-=$_SESSION['zbrane'];
      if($_SESSION['stity']<0){
        $_SESSION['stity']=0;
      }
      if($_SESSION['zbrane']>3){
          $_SESSION['stity']=$_SESSION['zbrane']-3;
          $_SESSION['zbrane']=3;
      }
  }
  elseif(isset($_POST['vz'])){
      $_SESSION['zbrane']=0;
  }
  echo "<p>Máš za úkol mít přesně 4 jednotky energie.
        <br>Zbraně spotřebují přesně 3 jednotky energie a štíty spotřebují zase přesně 5, ty však potřebuješ přesně 4 jednotky.
        <br>Ani víc, ani míň. Z hlavního generátoru můžeš převádět do štítů a do zbraní jednotky libovolně a libovolně je z nich zase můžeš vybít. </p>".
        "<p>Energie štítů: ".$_SESSION['stity']."</p>".
        '<form method="post">
                  <br><input type="submit" name="nst" value="Nabít štíty">
                  <br><input type="submit" name="ptzz" value="Převést do štítů energii ze zbraní" style="width:20%; margin-left: 39.7%";>
                  <br><input type="submit" name="vs" value="Vybít štíty">
                </form>'.
                "<p>Energie zbraní: ".$_SESSION['zbrane']."</p>".
                '<form method="post">
                    <br><input type="submit" name="nz" value="Nabít zbraně">
                    <br><input type="submit" name="ptzs" value="Převést do zbraní energii ze štítů " style="width:20%; margin-left: 39.7%;">
                    <br><input type="submit" name="vz" value="Vybít zbraně"></b>
                    </form>';
  if($_SESSION['stity'] == 4) {
    echo "<p>Výborně! Povedlo se ti nabít štíty na 4 jednotky a energie se automaticky převedla do terminálu. Co chceš udělat dál?</p>".
         '<form method="post">
          <br><input type="submit" name="jmv" value="Otevřít jeden modul" >
          <br><input type="submit" name="dmv" value="Otevřít oba moduly">
          </form>';
    if(isset($_POST['dmv'])) {
      echo "<p>Moduly se otevřely a dále už je budeš ovládat zevnitř.
            <br>Addama: Výborně! Pomoz mi tu věc hodit do modulu a zmizíme odsud.
            <br>Do jednoho modulu nakládáš zbraň, opíšeš si souřadnice dopadu a stiskneš tlačítko k odpalu.
            <br>Do druhého modulu si sedáš s Jarretem, jenže těsně před tím, než jsi stačil nastoupit tě za ruku popadl polomrtvý Vor'Gan a stáhl tě dozadu.
            <br>Jarret už bohužel stihl zavřít za sebou dveře a nevšiml si, že nejsi uvnitř.
            <br>Když mu to konečně dochází, otáčí se a buší na dveře.
            <br>Ty mu ovšem pokyneš aby odletěl, Vor'Ganovi aktivuješ sebedestrukční sekvenci jeho obleku a  umíráš v obrovské, velkolepé explozi společně s lodí.
            <br>Jarretovi se podařila najít zbraň a to nyní může znamenat důležitý zvrat v boji proti mocné Vor'Ganské Řísi.
            <br>Bitvu jsi možná prohrál, ale pomohl jsi vyhrát válku. Zrodila se legenda. <b><em>Dex Zachránce</em></b>.
            <br>Svůj titul zvýrazněný kurzívou si zapiš do záznamového archu.</p>";
    }
    elseif(isset($_POST['jmv'])) {
        echo  "<p>Otevřel se pouze jeden modul, akorát aby ses do něj vešel ty a zbraň.
              <br>Terminál se opět vybil a dále ovládat nepůjde.
              <br>Addama: Počkej, co to děláš? Pryč letíme přece oba!
              <br>Dex: Promiň Jarrete, ale nejsi součástí mého plánu.
              <br>Jarret se na tebe po uslyšení těchto slov vrhl a ty jsi ho jednoduše skolil k zemi a připoutal ho k terminálu.
              <br>Nakládáš do modulu zbraň, nastupuješ si k ní a odlátáš pryč, zatímco loď se kácí dolů k zemi.
              <br>Zbraň si necháváš pro vlastní účely a odlátáš vstříc budoucnosti plné ničení a zkázy. Zrodila se legenda.  <b><em>Dex Dobyvatel</em></b>.
              <br>Svůj titul zvýrazněný kurzívou si zapiš do záznamového archu.</p>";
    }

  }

  ?>
