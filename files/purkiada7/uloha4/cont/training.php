<!doctype html>
<html lang="cs" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<title>Hardware - Sestavení­</title>
		<style>
			body{
				background-image:url("../graph/img/design.jpg");
				background-position:center;
			}
			#story{
				background-color:#C0C0C0;
				text-align:center;
			}
			#draggable{
				width:250px;
				height:250px;
				background-color:#FFFFFF;
				float:right;
			}
			#droppable{
				width:500px;
				height:500px;
				background-color:#000000;
			}
			#loading {
    			display: block;
    			position: absolute;
    			top: 0;
    			left: 0;
    			z-index: 100;
    			width: 100vw;
    			height: 100vh;
    			background-color:#C0C0C0;
    			background-image: url("../graph/img/preloading.gif");
    			background-repeat: no-repeat;
    			background-position: center;
    			text-align:center;
		}
		a{
			text-decoration:none;
		}
		</style>
	</head>
	<body>
		<aside id="loading">Prosím, počkejte než se stránka načte ...</aside>
		<section id="worktable">
			<article id="story">
				<p>Na tomto úkolu si vyzkoušejte ovládání aplikace</p>
				<p id="zadani">
					Typ úkolu - Přetahování na cíl<br>
					Přetáhněte bílý čtverec do černého čtverce
				</p>
			</article>
			<p id="draggable">
			<article id="workspace">
				<table>
					<tr>
						<td class="droppable ui-widget-header"><p id="droppable"></p></td>
					</tr>
				</table>
			</article>
			<script type="text/javascript" src="../scripts/jquery-2.2.0.min.js"></script>
			<script type="text/javascript" src="../scripts/main.js"></script>
			<script type="text/javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
			<script type="text/javascript">
				$(function() {
					$("#draggable").draggable();
					$("#droppable").droppable({
						drop: function(event, ui) {
							$(this).addClass("ui-state-highlight");
								if(this.id == "droppable"){
									alert("Všímejte si změny zadání");
									$("#zadani").html("U každé úlohy si pečlivě přečtěte zadání, jak jste viděli, po splnění se může změnit. Nyní přejdeme na plnění opravdových úloh. <a href='part1.php'>ROZUMÍM</a>");
								}
							}
					});
				});
			</script>
		</section>
	</body>
</html>