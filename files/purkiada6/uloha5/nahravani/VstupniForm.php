<?php
class VstupniForm {   
  
  static $stav=0;
  static $info;
 
   static function kontrola() {            
    if (empty($_POST['kod'])) return 2;
    if (self::testZkratky() == false) return 1; 
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
        self::$info = "Zadaný účastnický kód nenalezen";
        unset($_POST['nahrano']);
        break;   
      case 2:
        self::$info = "Nejsou zadány všechny potřebné parametry, doplňte je a zkuste to znovu";
        unset($_POST['nahrano']);
        break;
      case 3:
        self::$info = "Soubor se nepodařilo nahrát. Nezapomněli jste jej přiložit?";
        unset($_POST['nahrano']);        
        break;
      case 4:
        self::$info = "Příliš velký soubor! Soubor se nepodařilo nahrát";
        unset($_POST['nahrano']);        
        break;          
    }  
    echo "<h3>".self::$info."</h3>"; 
  }
  
  static function testZkratky() {
    $kod = mysql_real_escape_string(trim($_POST['kod']));
    include('./dbtools.class.php');
    $db = new dbTools();
    $db->dbConnect('localhost', 'purkiada', '3wMe4iuFgb4eg7');
    $db->dbSelect('purkiada');
    $db->charSet('utf8', 0);     
    $query = $db->dbAssoc("SELECT zkratka FROM zkratky2015 WHERE zkratka = '".$kod."'",0);
    if($query == false) return false;
    else return true;
    $db->dbClose();
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
    define ("FILEREPOSITORY","../nahrano/");
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
    <form action="./nahravani/kontrola.php" method="post" enctype="multipart/form-data">
      <table>
    	 <tr><td>Váš účastnický kód: <input type="text" name="kod" maxlength="5"/></td></tr>
       <tr><td>Vyberte soubor: <input type="file" name="soubor" accept="image/x-png" />
       <input type="hidden" name="nahrano" value="ok" /> 
      </td></tr>           
      <tr><td><input type="submit" value="Nahrát" /></td></tr>
    </table>
    </form>
 
  <?php
  }  
}
?>
