<?php

$user = "purkiada";
$psw = "3wMe4iuFgb4eg7";

try {
    $conn = new PDO("mysql:host=localhost;dbname=purkiada", $user, $psw);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
} catch(PDOException $ex) {
    echo "CHYBA: " . $ex->getMessage();
}

?>
