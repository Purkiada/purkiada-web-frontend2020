<?php
class VstupniForm {   
  
  static $stav=0;
  static $info;
 
   static function kontrola() {            
    if (!trim(strtolower($_POST["as"]))=="Praha")  return 1;
    if (empty($_POST['kod'])) return 2; 
    if ($_FILES["soubor"]["error"] == 1 || $_FILES["soubor"]["error"] == 2 ) return 4;
    if ($_FILES["soubor"]["error"] != 0) return 3;    
        
    else return 5;
  }
  
  static function zobrazInfo($stav) {     
    switch($stav) {
      case 0:
        self::$info = "Chci nahrát soubor";        
        break; 
      case 1:
        self::$info = "Spam od ".$_SERVER['REMOTE_ADDR'];
        unset($_POST['nahrano']);
        break;   
      case 2:
        self::$info = "Nejsou zadány všechny potřebné parametry, doplňte je a zkuste to znovu";
        unset($_POST['nahrano']);
        break;
      case 3:
        self::$info = "Soubor se nepodařilo dobře nahrát";
        unset($_POST['nahrano']);        
        break;
      case 4:
        self::$info = "Příliš velký soubor! Soubor se nepodařilo nahrát";
        unset($_POST['nahrano']);        
        break;      
    }  
    echo "<h3>".self::$info."</h3>"; 
  }
  
  /* dočasný soubor */
  static function oldSoubor() {    
    return $_FILES['soubor']['tmp_name'];
  }
  
  /* nastavení adresáře pro ukládání souborů */
  static function newSoubor() {
    $pathinfo = pathinfo($_FILES['soubor']['name']);
    $pripona = "txt";      
    if (isset($_FILES['soubor']['name'])) $pripona = $pathinfo["extension"];
    define ("FILEREPOSITORY","./nahrano/");
    $novy = FILEREPOSITORY.$_POST['kod'];   
    $pocet=0;  
      while (is_file($novy.".".$pripona)) {   // jestliže už soubor existuje, 
        $pocet++;                             // soubor stejného jména čísluje        
        $novy = FILEREPOSITORY.$_POST['kod'].$pocet;                    
      }           
    return $novy.".".$pripona;     
  }
  
  /* přesune soubor z dočasného adresáře do cílového a zkontroluje,
     zda byl soubor skutečně nahrán přes HTTP POST PHP, když ne, vrátí false */
  static function presun($stary, $novy) {  
    $result = move_uploaded_file($stary, $novy);    
    if ($result == 1) {
      chmod($novy, 0006);     
      return true;
    }
    else return false;         
  } 
 
 static function zobrazFormular() {
  ?>       
    <form action="./kontrola.php" method="post" enctype="multipart/form-data">
      <table>
    	 <tr><td>Váš účastnický kód: <input type="text" name="kod" size="10" /></td></tr>
       <tr><td>Vyberte soubor: <input type="file" name="soubor" value="" size="50" />
       <input type="hidden" name="MAX_FILE_SIZE" value="1024" /> 
       <input type="hidden" name="nahrano" value="ok" /> 
       <div id="ansm">
         Sem napište jméno hlavního město ČR:
         <input type="text" name="as" id="as" size="15" />
         <script type="text/javascript" language="JavaScript">
          document.forms[0].elements["as"].value="Praha";
          document.getElementById("ansm").style.display="none";
         </script>
       </div></td></tr>           
      <tr><td><input type="submit" value="Nahrát" /></td></tr>
    </table>
    </form>
 
  <?php
  }  
}
?>
