<?php

if (isset($_GET['input'])) {
    include(__DIR__ . '/../include/openTerminal.php');
    echo json_encode($terminal->handleTab($_GET['input']));
    include(__DIR__ . '/../include/closeTerminal.php');
}
