<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title></title>
  <link rel="StyleSheet" type="text/css" href="../purk.css">
  </head>
  <body>
  <?php
  session_start();
  ?>
  
  <?php
  echo '<form method="post">
    <input type="submit" value="Podívat se ke dveřím vedoucím ven" name="ven">
    <input type="submit" value="Hledat tlačítko na stěně" name="hled">
      </form>';
  if(isset($_POST['ven'])){
    echo "<p>Dveře jsou zamčeny a hned vedle nich je čtečka čipů zaměstnanců. 
          <br>Jarretovi by se možná mohlo povést je otevřít.</p>".
          ' <form method="post">
            <input type="submit" value="Hledat tlačítko na stěně" name="hled">
          </form>';}
  elseif(isset($_POST['hled'])){
  echo "<p>Po chvíli slepého tápání po stěně jsi nahmatal na stěně malé tlačítko. Po jeho stisknutí se otevřela přihrádka, ve které leží Tajfun. 
        <br>Zbraň má zhruba metr na délku, je mohutná a přímo v jejím srdci se nachází velký, zeleně svítící generátor ve kterém vznikají víry, které po tom zbraň vypouští. 
        <br>Na vrchu a na straně má zbraň držadla. Dá se sice držet jediným člověkem, ale primárně je určena k použití v lodích.</p> 
        <p>Addama: Výborně Dexi, to je ono! Popadni to a padáme odsud.</p> 
        <p>Bereš si do rukou zbraň a pod její tíhou se zakymácíš. Když se opět zmátoříš, přesouváš se pomalu ke dveřím. 
        <br>Dveře jsou zamčeny a hned vedle nich je čtečka čipů zaměstnanců. Jarretovi by se možná mohlo povést je otevřít.</p>
        <p>Calter: Jarrete, můžeš tyhle dveře otevřít? 
        <br>Addama: Samozřejmě. A sakra, zdá se že se do dveří někdo naboural, karta už mi nestačí. Myslíš že se s tím vypořádáš? </p>
        <br>Po bližším prohlédnutí displeje vidíš jakousi hádanku nutnou k vyřešení zámku. Co uděláš?".
        '<form method="post">
              <input type="submit" value="Vyřešit hádanku" name="had">
        </form>';}
  elseif(isset($_POST['had'])){
    echo "<p>Na obejití tohoto zámku budeš muset odpovědět na 5 otázek. 
          <br>Odpovědi na každou otázku jsou maximálně dvojslovné a jsou všechny psány velkým písmem bez diakritiky. 
          <br>První písmeno každé odpovědi si zapiš.</p>".
          '<form method="post">
              <p>1. Jak se jmenovala planeta, na které Yoda cvičil Luka Skywalkera?</p> : <input type="text" name="dag" style="border-color:green; width: 15%; margin-left:37.37%;">
              <input type="submit" value="Poslat" name="pos">
          </form>';}
          if(isset($_POST['pos']) && $_POST['dag']=="DAGOBAH"){
          echo '<form method="post">
              <p>2. Jaké je křestní jméno slavného Jedie a otce Luka Skywalkera?:</p> <input type="text" name="ana" style="border-color:green; width: 15%; margin-left:37.37%;">
              <input type="submit" value="Poslat" name="pos2">
          </form>';
          }
          if(isset($_POST['pos2']) && $_POST['ana']=="ANAKIN"){
          echo '<form method="post">
              <p>3. Jak se jmenovali vojáci, kteří bojovali v odboji proti Impériu?</p> : <input type="text" name="reb" style="border-color:green; width: 15%; margin-left:37.37%;">
              <input type="submit" value="Poslat" name="pos3">
          </form>';
          }
          if(isset($_POST['pos3']) && $_POST['reb']=="REBELOVE"){
          echo '<form method="post">
              <p>4. Jak se nazývá planeta, na které vyrůstal Luke Skywalker?</p> : <input type="text" name="tat" style="border-color:green; width: 15%; margin-left:37.37%;">
              <input type="submit" value="Poslat" name="pos4">
          </form>';
          }
          if(isset($_POST['pos4']) && $_POST['tat']=="TATOOINE"){
          echo'<form method="post">
              <p>5. Jaké je křestní jméno pašeráka, jemuž patří loď Millenium Falcon?</p> : <input type="text" name="han" style="border-color:green; width: 15%; margin-left:37.37%;">
              <input type="submit" value="Poslat" name="pos5">
          </form>';
          }
          if(isset($_POST['pos5']) && $_POST['han']=="HAN"){
          echo '<form method="post">
              <p>Výborně, všechny otázky jsi vyřešil. Nyní vepiš do terminálu slovo, které ti vzniklo spojením prvních písmen všech odpovědí.</p> : <input type="text" name="dar" style="border-color:green; width: 15%; margin-left:37.37%;">
              <input type="submit" value="Poslat" name="pos6">
          </form>';                      
          }
          if(isset($_POST['pos6']) && $_POST['dar']=="DARTH"){
          echo "<p> Slovo, co jsi právé zadal, napiš do záznamového archu</p>".'<a href="../nouz/indexH.php"><button type=button>Jít Dál</button></a>';
          } 
           

  
  
  
  ?>
  
  </body>
</html>