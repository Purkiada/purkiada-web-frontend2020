<?php
error_reporting(0);
//load HTML file
$html = file_get_contents("./html.html");

//pre_define some replacments   
$head = '';
$title = "Levely 2015";
$form = '
    <form action="./index.php" method="GET">
      <input type="text" name="lvl"><br />
	<br>
      <input type="submit" value="Další level">
    </form>';

switch($_GET['lvl']){
  case 'http://www.sspbrno.cz':
  case 'http://sspbrno.cz':
  case 'sspbrno.cz':
  case 'sspbrno':
  case 'www.sspbrno.cz':
  $head = '';
  $title = "Levely 2015<!--  --!>";
  $level = "LEVEL 7";
   $form = '';
  $content = 'Gratuluji, úspěšně jsi ukončil všechny levely.</br>Do záznamového archu si napiš: ez.levely_done';
  $citat = '';
  break;

  case 'IBM':
  case 'ibm':
  $head = '';
  $title = "Levely 2015<!--  --!>";
  $level = "LEVEL 6";
  $content = 'Není černá jako černá';
  $citat = '<center><img src="background.jpg"></center>';
  break;

  case 'rgb(0,0,0)':
  $head = '';
  $title = "Levely 2015";
  $level = "LEVEL 5";
  $content = "Nemůžeš to vidět, ale můžeš si to upravit...";
  $citat = "If at first you don't succeed; call it version 1.0";
  $citator = '<div id="divCheckbox" style="visibility: hidden; display:inline;"><script type="text/javascript" src="http://www.webestools.com/google_map_gen.js?lati=49.225479&long=16.57757079999999&zoom=17&width=675&height=400&mapType=normal&map_btn_normal=yes&map_btn_satelite=yes&map_btn_mixte=yes&map_small=yes&marqueur=yes&info_bulle="></script><br /></div>';
  break;

  case 'string':
  $head = '<link rel="stylesheet" type="text/css" href="glopal_graphic.css">';
  $title = "Levely 2015";
  $level = "LEVEL 4";
  $content = "Co se změnilo?...";
  $citat = "";
  
  break;

  case 'error':
		$content = '<script type="text/javascript" language="JavaScript">
		  {
		  var b="string";
		  function check()
		  {
		  if (document.pass_form.lvl.value == b)
		  {
		  document.location.href="./index.php?hrle="+document.pass_form.hrle.value;
		  }
		  else
		  {
		  window.alert("Chyba, zkus to znovu");
		  }
		  }
		  }
		  </script>
		Admin úspěšně nahrál soubor s heslem, ale odesílací tlačítko nefunguje, poradíš si i s tím?';
  $form = '
		<form action="javascript:check()" name="pass_form" method="GET">
		  <input type="text" name="lvl"><br />
			<br />
		  <input type="submit" value="Další level">
		</form>';		
    $level="LEVEL 3";
		$citat = "There is no place like 127.0.0.1";
   		$citator = "";
    
  break;

  case 'e1337e':
  $title = "Levely 2015";
  $level = "LEVEL 2";
  $citat = "There are 10 types of people in the world: Those who understand binary, and those who don't.";
  $content = '<script type="text/javascript" language="JavaScript">
		  {
		  var a="HESLO_JE_DESNE_JEDNODUCHE";
		  function check()
		  {
		  if (document.pass_form.lvl.value == "")
		  {
		  document.location.href="./index.php?lvl=error";
		  }
		  else
		  {
		  window.alert("Chyba, zkus to znovu");
		  }
		  }
		  }
		  </script>        
		Admin udělal chybu při nahrávání souboru s heslem, objevíš jakou?';
   $form = '
		<form action="javascript:check()" name="pass_form" method="GET">
		  <input type="text" name="lvl"><br /> <br />
		  <input type="submit" value="Další level">
		</form>';
   $citat = "Existuje 10 typů lidí. Ti co rozumí binárce a ti, kteří ne.";
   $citator = "";
   break;


  default:
  $head = '';
  $title = "Levely 2015";
  $level = "LEVEL 1";
  $content = "Hledej první heslo, zadej ho do formuláře a odešli<br /> <!-- Hh, našels to. Heslo je e1337e --!>";
  $citat = "But we are hackers and hackers have black terminals with green font colors!";
  $citator = "(Johne Nunemaker)";
  break;
  
}
//replace
$html = str_replace("[HEAD]",$head,$html);
$html = str_replace("[TITLE]",$title,$html);
$html = str_replace("[LEVEL]",$level,$html);
$html = str_replace("[CONTENT]",$content,$html);
$html = str_replace("[FORM]",$form,$html);
$html = str_replace("[CITAT]",$citat,$html);
$html = str_replace("[CITATOR]",$citator,$html);

//render page
echo $html;


?>
