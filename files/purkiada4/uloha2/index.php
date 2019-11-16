<?php  
  header("Content-type: text/html; charset=utf-8");  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Purkiáda 2013 - Soutěž v informačních a komunikačních technologiích</title>
    <link rel="stylesheet" type="text/css" href="http://purkiada.sspbrno.cz/css/main.css" media="screen" />
</head>

  <body>
  <div id="hlavicka">
	<div>
    	<a href="/"><h1 title="Purkiáda 2013 - Soutěž v informačních a komunikačních technologiích">
        <strong>Purkiáda 2013 - Soutěž v informačních a komunikačních technologiích</strong></h1></a>              
	</div>
    <hr />
</div>

<div id="telo">
    <h2>2 Programování</h2>    
 
<?php
  function formular($user="", $hvezda="", $schody="", $kriz="")  {
  echo "<p>Do jednotlivých oken zkopíruj tvůj odladěný zdrojový kód z Tutora</p>";
?>   
    <form method="POST">
      <p>Tvůj login: <input type="text" name="user" size="6" value="<?=$user?>" /></p>
      <h3>Hvězdice</h3>
      <textarea name="hvezda" rows="20" cols="60"><?=$hvezda?></textarea>
      <h3>Schody</h3>
      <textarea name="schody" rows="20" cols="60"><?=$schody?></textarea>
      <h3>Kříž</h3>
      <textarea name="kriz" rows="20" cols="60"><?=$kriz?></textarea>
      <p><input type="submit" name="ulozeno" value="Uložit"></p>
    </form>
 <?php
  }     
   
	if(empty($_POST["ulozeno"])) {     
    formular(); 
  }
  else {  
      $user = (isset($_POST['user'])?$_POST['user']:"");			
      $hvezda = (isset($_POST['hvezda'])?$_POST['hvezda']:"");
      $schody = $_POST['schody'];
      $kriz = $_POST['kriz'];
      if ($user !=="") {	
        $text=$user."\n---------\n";
        $text.="*** hvezdice\n".$hvezda."\n";
        $text.="*** schody\n".$schody."\n";
        $text.="*** kriz\n".$kriz."\n";
  
        chdir("./nahrano");  
        $nazevSouboru = $_POST['user'].".txt";    
        $soub = fopen($nazevSouboru, "a+");
          fwrite($soub, $text);
        fclose($soub);
        echo "<h3>Kód byl uložen do souboru</h3>";
        echo "<form action=\"./../\"><input type=\"submit\" value=\"Zpět na rozcestník\"></form>" ; 
      }
      else {             
		    echo "<h3>Login i heslo musí být vyplněno!</h3>";		    
        formular($user, $hvezda, $schody, $kriz);
      }
   }
 ?>
      
</div>
<div id="konec">
	<div>
    <a href="http://www.sspbrno.cz/" title="Stránky školy" target="_blank"><img src="http://purkiada.sspbrno.cz/obrazky/logo_spseit.png" title="Logo školy" height="40" style="float: left;" /></a>
    <p>&copy; Střední průmyslová škola elektrotechnická a informačních technologií Brno</p>
  </div>
</div> 
    
  </body>
</html>
