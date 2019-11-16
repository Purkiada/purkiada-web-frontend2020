<?php
  header("Pragma: no-cache");
  header("Content-type: text/html; charset=utf-8");  
 
  include ("./VstupniForm.php"); 
   
  VstupniForm::$stav = VstupniForm::kontrola();      
    
  if (VstupniForm::$stav < 5) {
    header("Location: ../index.php?stav=".VstupniForm::$stav."#upload");
    exit();
  }
  
  if (VstupniForm::$stav == 5) { 
    $stary = VstupniForm::oldSoubor();
    $novy = VstupniForm::newSoubor(); 
    echo $stary,"-",$novy;
    VstupniForm::$stav = VstupniForm::presun($stary, $novy);
    echo VstupniForm::$stav;
  }  
    
  unset($_POST);
  if (VstupniForm::$stav) header("Location: ./nahrano.php");
  else header("Location: ./nenahrano.php");
  exit();
       
?>
