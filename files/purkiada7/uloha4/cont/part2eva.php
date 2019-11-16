<?php
	require_once("../scripts/core.php");
	$actPoints = @$_GET["reqPage"];
	xmlPoints($actPoints);
	xmlProgress(2);
	header("location:part3.php");
?>