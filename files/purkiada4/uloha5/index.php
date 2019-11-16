<?php
//load HTML file
error_reporting(0);

$html = file_get_contents("./html.html");

//pre_define some replacments   
$head = '';
$title = "Purkiáda 2013 - Hack test";
$form = '
    <form action="./index.php" method="GET">
      <input type="text" name="hrle"><br />
      <input type="submit" value="Zkusím štěstí">
    </form>';
    
switch($_GET['hrle']){
  case 'hacked_101':
		$level = 'LEVEL 6';
		$content = 'Óká, hacknul jsi mě... Příště můžeš zkusit třeba Facebook nebo školní databázi.<br />
		Do papíru si napiš: OliveOil_5844';
		$form = '';
  break;
  case 'Diplodocus':
		$head = '<link rel="stylesheet" type="text/css" href="url.css">';
		$level = 'Level 5';
		$content = 'Tohle není poslední level!!!! Dostaneš se dál? Ne? Smůla... :(';
		$form = '';
  break;
	
 
  case 'cheese_pizza':
		$level = 'LEVEL a87ff679a2f3e71d9181a67b7542122c 
		<!-- Heslo? Jasný, to je přece c98d8230ab2f948422a219f1eca33658 !-->';
		$content = 'Tak jo. Najdeš heslo? A bude mít 10bytů?';
  break;
  case 'null':
		$content='<a href="./imgs/go_deeper_than_deeper.jpg">
		<img src="./imgs/go_deeper_than_deeper.jpg" height="400"></a>';
		$level="LEVEL 3";
    
  break;

  case 'leetspeakrullez':
  $title = "Purkiáda 2013 - Hack test";
  $level = "LEVEL 2";
  $content = '<script type="text/javascript" language="JavaScript">
		  {
		  var a="null";
		  function check()
		  {
		  if (document.pass_form.hrle.value == a)
		  {
		  document.location.href="./index.php?hrle="+document.pass_form.hrle.value;
		  }
		  else
		  {
		  alert ("Try again");
		  }
		  }
		  }
		  </script>
		Teď to bude trochu těžší.<br /><img src="./imgs/WE-NEED-TO-GO-DEEPER.jpg">';

	  $form = '
		<form action="javascript:check()" name="pass_form" method="GET">
		  <input type="text" name="hrle"><br />
		  <input type="submit" value="Zkusím štěstí">
		</form>'; 
	break;



  default:
  $head = "";
  $title = "Purkiáda 2013 - h4Ck T3\$t";
  $level = "LEVEL 1";
  $content = 'Princip je jednoduchý. Dostaň se do dalšího levelu. Jak? To už je tvoje věc.<br /> Při téhle úloze je povoleno a dokonce i doporučeno používat Google. <br />Heslo prvního levelu je jednoduchý: 1337$P34krULL3Z <br /> Rozluštíš ho?';
  break;
  
}
//replace
$html = str_replace("[HEAD]",$head,$html);
$html = str_replace("[TITLE]",$title,$html);
$html = str_replace("[LEVEL]",$level,$html);
$html = str_replace("[CONTENT]",$content,$html);
$html = str_replace("[FORM]",$form,$html);

//render page
echo $html;


?>
