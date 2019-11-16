<?php 
    session_start();
    $usr = $_SESSION['usr'];
    $action = @$_POST['action'];
    if(isset($action) && !empty($action)) {
        $mf = fopen("../entrant/".$usr.".txt", "a");
        fwrite($mf,$action.gethostname().date(" Y/m/d h:i:s")."\n");
        fclose($mf);
    }
?>
<!DOCTYPE html>
<html lang='cs' dir='ltr'>
    <head>
        <meta charset="UTF-8">
        <title>Advetury</title>
        <link rel="stylesheet" type="text/css" href="../css/template.css">
    </head>
    <body>
        <section id='info'>
            <h1>Uživatel</h1>
            <h3>Nebojte se, že zde nevidíte své body! Vše je monitorováno a zaznamenáváno</h3>
            <table>
                <tr>
                    <td>Jméno: </td>
                    <td><?php echo $usr;?></td>
                </tr>
            </table>
            <h1>Úlohy</h1>
            <table>
                <tr>
                    <th>Souřadnice </th>
                    <td><a href='../quests/xy.php'>Přejít na úlohu</a></td>
                </tr>
                <tr>
                    <th>Sbírání</th>
                    <td><a href='../quests/sbirani.php'>Přejít na úlohu</a></td>
                </tr>
            </table>
            
        </section> 
    </body>
</html>
