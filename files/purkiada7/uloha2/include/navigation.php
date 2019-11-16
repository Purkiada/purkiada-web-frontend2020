<html>
	<head>
		<script src="js/terminal.js"></script>
		<style>
			#command {
				color: white;
				background-color: black;
				border: none;
				font-size: 20px;
				font-family: "Consolas", sans-serif;
				flex-grow: 1;
			}
			#command:focus {
				outline: 0;
			}
			.terminal-wrapper {
				display: none;
				position: absolute;
				top: 30px;
				right: 0px;
				bottom: 0px;
				left: 0px;
				background-color: rgba(0,0,0,0.9);
			}
			.terminal-input {
				display: flex;
			}
			.terminal {
				position: absolute;
				top: 40px;
				right: 40px;
				left: 40px;
				bottom: 40px;
				border: 5px solid grey;
				background-color: black;
				color: white;
				font-family: "Consolas", sans-serif;
				font-size: 20px;
				padding: 5px;
				overflow: auto;
			}
		</style>
	</head>
	<body>
	    <?php
	    if(is_file("files/" . $_SESSION["firstuser"] . "/log/passwordreset.log")) {
	        echo "<div class=\"toolbar\">" .
	            "<span class=\"toolbar-text\">Nástroje:</span>" .
	            "<button class=\"toolbar-button\" onclick=\"showTerminal();\">Terminál</button>" .
	            "<span class=\"toolbar-text\">Obnovení webové stránky resetuje terminál! Agentský server: 128.0.0.1</span>" .
	            "</div>";
	        echo "<div class=\"nav\" style=\"margin-top: 30px;\">";
		} else {
		    echo "<div class=\"nav\">";
		}
		?>
			<h1>CodeSec</h1>
			<ul>
				<li><a href="index.php">Domů</a></li>
				<li><a href="search.php">Vyhledat uživatele</a></li>
				<?php
				if(isset($_SESSION["user"])) {
					echo "<li><a href=\"logout.php\">Odhlásit se (". $_SESSION["user"] . ")</a></li>";
				} else {
					echo "<li><a href=\"login.php\">Přihlásit se</a></li>";
				}
				?>
			</ul>
		</div>
		<div class="terminal-wrapper">
			<div class="terminal">
				<div class="terminal-input">
				    <span id="commandText">agent010@AgentPC:~$&nbsp;</span>
					<input type="text" id="command" spellcheck="false" autofocus>
				</div>
			</div>
		</div>
		<br><br><br><br><br>
	</body>
</html>
