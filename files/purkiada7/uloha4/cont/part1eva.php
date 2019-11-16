<?php
	require_once("../scripts/core.php");
	$actPoints = @$_GET["reqPage"];
	xmlPoints($actPoints);
	xmlProgress(1);
	header("location:part2.php");
?>