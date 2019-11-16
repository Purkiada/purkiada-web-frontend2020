<?php
	require_once("../scripts/core.php");
	$actPoints = @$_GET["reqPage"];
	xmlPoints($actPoints);
	xmlProgress(3);
	header("location:done.php");
?>	