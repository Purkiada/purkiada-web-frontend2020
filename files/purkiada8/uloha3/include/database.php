<?php

$host = "localhost";
$dbName = "purkiada";
$user = "purkiada";
$psw = "3wMe4iuFgb4eg7";

$conn = null;
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbName", $user, $psw);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $ex) {
    add_to_log("Database ERROR: " . $ex->__toString());
}
