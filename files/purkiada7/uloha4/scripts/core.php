<?php
	session_start();
	$id=$_SESSION["id"];	
	function xmlProgress($cislo){
		$id=$_SESSION["id"];
		$xmlTree = simplexml_load_file("../users/".$id.".xml");
		$xmlTree->progress = $cislo;
		$xmlTree->saveXML("../users/".$id.".xml");
	}
	function xmlPoints($number){
		$id=$_SESSION["id"];
		$xmlTree = simplexml_load_file("../users/".$id.".xml");
		$pointsNow = $xmlTree-> points;
		$xmlTree->points = $pointsNow + $number;	
		$xmlTree->saveXML("../users/".$id.".xml");		
	}		
	function zabraneniPodvadeni($actPoints){
		if($actPoints > 1) {
			header("location:podvod.php");
		}
	}
	function zabPodvod($predaneCislo){
		require_once("../scripts/core.php");
		$id=$_SESSION["id"];
		$xmlTree = simplexml_load_file("../users/".$id.".xml");
		$prog = $xmlTree-> progress;
		if($prog != $predaneCislo){
			header("location:podvod.php");
		}
	}
?>
<?php
