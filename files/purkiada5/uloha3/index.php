<?php
	include_once("Session.class.php");
	$session = new Session();
	$autor = "Martin Kolacek";
	
	if(!isset($_SESSION['level'])) {
		$session->setLevel("home");
	}
	
	if(isset($_GET['level']) && !empty($_GET['level']))
	{
		if(file_exists("./levels/".$_GET['level'].".php")) 
		{
			$session->setLevel($_GET['level']);
			include("levels/" . $session->getLevel() . ".php");
		}
		else {
			include("levels/" . $session->getLevel() . ".php");
		}
	}
	else {
		include("levels/" . $session->getLevel() . ".php");
	}
?>