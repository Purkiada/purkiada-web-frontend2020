<?php 
	session_start();
	$id = @$_POST["id"];
	$pass = @$_POST["pass"];
	if(isset($id)){	
		if(!empty($id)){
			if(($id == "adm1n1str8t0r")){
				header("location:cont/adm_and_results.php");
			}
			else{
				if(file_exists("users/".$id.".xml")){
					$_SESSION["id"] = $id;
					$xml = simplexml_load_file("users/".$id.'.xml');
					$GetProgress = $xml-> progress or die ("Chyba ! Nenašel jsem progress uživatele !");
					if($GetProgress == 0){
						header("location:cont/part1.php");
					}
					else if($GetProgress == 1){
						header("location:cont/part2.php");
					}
					else if($GetProgress == 2){
						header("location:cont/part3.php");
					}
					else if($GetProgress == 3){
						header("location:cont/done.php");
					}
				}
				else{
                    $_SESSION["id"] = $id;
					$dom = new DOMDocument("1.0","UTF-8");
					$xmlRoot = $dom->createElement("xml");
					$xmlRoot = $dom->appendChild($xmlRoot);
					$fieldPOINTS = $dom->createElement("points");
					$fieldPOINTS = $xmlRoot->appendChild($fieldPOINTS);
					$fieldPROGRESS = $dom->createElement("progress");
					$fieldPROGRESS = $xmlRoot->appendChild($fieldPROGRESS);
					$fieldPOINTS->appendChild($dom->createTextNode(0));
					$fieldPROGRESS->appendChild($dom->createTextNode(0));
					$dom->save("users/".$id.".xml") or die("Uživatelský účet nešel vytvořit");
					header("location:cont/training.php");
				}
			}
		}
			else{
				echo("
					<script type='text/javascript'>
						alert('Nezadal/a jste ID');
					</script>
				");
			}
		}
?>
<!doctype html>
<html lang="cs" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<title>Hardware - Přihlášení</title>
		<link rel="stylesheet" type="text/css" href="graph/css/default.css">
	</head>
	<body>
		<section id="login">
			<form method="POST">
				<table>
					<tr>
						<td>
							<p>
								<b>
									James Bond si musí sestavit vlastní pc,<br>
									dokážeš mu s tím pomoct ?<br>
								</b>
							</p>
						</td><tr>
						<td><input type="text" name="id" placeholder="Zadejte vaše ID"></td><tr>
						<td><input type="submit" value="Přihlásit"></td><tr>
						</tr>
				</table>
			</form>
		</section>
	</body>
</html>