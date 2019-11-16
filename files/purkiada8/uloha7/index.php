<?php 
    session_start();
    if((@$_POST['usr-sbmt']) && !empty($_POST['usr-lgn'])){
        $lgn = $_POST['usr-lgn'];
        if(!file_exists("entrant/".$lgn.".txt")){
            $myfile = fopen("entrant/".$lgn.".txt", "w") or die("Nebylo možné vytvořit soubor!");
            fclose($myfile);
            $_SESSION['usr'] = $lgn;
            header('Location: content/stats.php');
        } else {
            echo "<script>alert('Tento soubor již existuje!');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang='cs' dir='ltr'>
    <head>
        <meta charset="UTF-8">
        <title>Manévrování s lodí</title>
        <link rel="stylesheet" type="text/css" href="css/template.css">
    </head>
    <body>
        <form method='POST'>
            <table id='login-table'>
                <tr>
                    <td>
                        <p><b>
                        Úlohu nevypínejte, nelze se zpětně přihlásit!  <br>
                      Pokud jste ji vypnuli, tak se přihlaste znovu, ale za vaše jméno dejte libovolné číslo.<br>
                      Pokud si chcete úlohu zkusit znovu, tak za svoje jméno dejte také libovolné číslo<br>
                      ! Více pokusů neznamená více bodů !  <br></b>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                       <input type='text' name='usr-lgn' placeholder='Zadejte váš login'> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type='submit' name='usr-sbmt' value='Přihlásit se'>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>