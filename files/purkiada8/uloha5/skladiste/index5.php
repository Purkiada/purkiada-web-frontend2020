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
    <input type="submit" value="Pod�vat se ke dve��m vedouc�m ven" name="ven">
    <input type="submit" value="Hledat tla��tko na st�n�" name="hled">
      </form>';
  if(isset($_POST['ven'])){
    echo "<p>Dve�e jsou zam�eny a hned vedle nich je �te�ka �ip� zam�stnanc�. 
          <br>Jarretovi by se mo�n� mohlo pov�st je otev��t.</p>".
          ' <form method="post">
            <input type="submit" value="Hledat tla��tko na st�n�" name="hled">
          </form>';}
  elseif(isset($_POST['hled'])){
  echo "<p>Po chv�li slep�ho t�p�n� po st�n� jsi nahmatal na st�n� mal� tla��tko. Po jeho stisknut� se otev�ela p�ihr�dka, ve kter� le�� Tajfun. 
        <br>Zbra� m� zhruba metr na d�lku, je mohutn� a p��mo v jej�m srdci se nach�z� velk�, zelen� sv�t�c� gener�tor ve kter�m vznikaj� v�ry, kter� po tom zbra� vypou�t�. 
        <br>Na vrchu a na stran� m� zbra� dr�adla. D� se sice dr�et jedin�m �lov�kem, ale prim�rn� je ur�ena k pou�it� v lod�ch.</p> 
        <p>Addama: V�born� Dexi, to je ono! Popadni to a pad�me odsud.</p> 
        <p>Bere� si do rukou zbra� a pod jej� t�hou se zakym�c�. Kdy� se op�t zm�to��, p�esouv� se pomalu ke dve��m. 
        <br>Dve�e jsou zam�eny a hned vedle nich je �te�ka �ip� zam�stnanc�. Jarretovi by se mo�n� mohlo pov�st je otev��t.</p>
        <p>Calter: Jarrete, m��e� tyhle dve�e otev��t? 
        <br>Addama: Samoz�ejm�. A sakra, zd� se �e se do dve�� n�kdo naboural, karta u� mi nesta��. Mysl� �e se s t�m vypo��d�? </p>
        <br>Po bli���m prohl�dnut� displeje vid� jakousi h�danku nutnou k vy�e�en� z�mku. Co ud�l�?".
        '<form method="post">
              <input type="submit" value="Vy�e�it h�danku" name="had">
        </form>';}
  elseif(isset($_POST['had'])){
    echo "<p>Na obejit� tohoto z�mku bude� muset odpov�d�t na 5 ot�zek. 
          <br>Odpov�di na ka�dou ot�zku jsou maxim�ln� dvojslovn� a jsou v�echny ps�ny velk�m p�smem bez diakritiky. 
          <br>Prvn� p�smeno ka�d� odpov�di si zapi�.</p>".
          '<form method="post">
              <p>1. Jak se jmenovala planeta, na kter� Yoda cvi�il Luka Skywalkera?</p> : <input type="text" name="dag" style="border-color:green; width: 15%; margin-left:37.37%;">
              <input type="submit" value="Poslat" name="pos">
          </form>';}
          if(isset($_POST['pos']) && $_POST['dag']=="DAGOBAH"){
          echo '<form method="post">
              <p>2. Jak� je k�estn� jm�no slavn�ho Jedie a otce Luka Skywalkera?:</p> <input type="text" name="ana" style="border-color:green; width: 15%; margin-left:37.37%;">
              <input type="submit" value="Poslat" name="pos2">
          </form>';
          }
          if(isset($_POST['pos2']) && $_POST['ana']=="ANAKIN"){
          echo '<form method="post">
              <p>3. Jak se jmenovali voj�ci, kte�� bojovali v odboji proti Imp�riu?</p> : <input type="text" name="reb" style="border-color:green; width: 15%; margin-left:37.37%;">
              <input type="submit" value="Poslat" name="pos3">
          </form>';
          }
          if(isset($_POST['pos3']) && $_POST['reb']=="REBELOVE"){
          echo '<form method="post">
              <p>4. Jak se naz�v� planeta, na kter� vyr�stal Luke Skywalker?</p> : <input type="text" name="tat" style="border-color:green; width: 15%; margin-left:37.37%;">
              <input type="submit" value="Poslat" name="pos4">
          </form>';
          }
          if(isset($_POST['pos4']) && $_POST['tat']=="TATOOINE"){
          echo'<form method="post">
              <p>5. Jak� je k�estn� jm�no pa�er�ka, jemu� pat�� lo� Millenium Falcon?</p> : <input type="text" name="han" style="border-color:green; width: 15%; margin-left:37.37%;">
              <input type="submit" value="Poslat" name="pos5">
          </form>';
          }
          if(isset($_POST['pos5']) && $_POST['han']=="HAN"){
          echo '<form method="post">
              <p>V�born�, v�echny ot�zky jsi vy�e�il. Nyn� vepi� do termin�lu slovo, kter� ti vzniklo spojen�m prvn�ch p�smen v�ech odpov�d�.</p> : <input type="text" name="dar" style="border-color:green; width: 15%; margin-left:37.37%;">
              <input type="submit" value="Poslat" name="pos6">
          </form>';                      
          }
          if(isset($_POST['pos6']) && $_POST['dar']=="DARTH"){
          echo "<p> Slovo, co jsi pr�v� zadal, napi� do z�znamov�ho archu</p>".'<a href="../nouz/indexH.php"><button type=button>J�t D�l</button></a>';
          } 
           

  
  
  
  ?>
  
  </body>
</html>