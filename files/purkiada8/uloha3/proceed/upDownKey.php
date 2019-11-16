<?php

if (isset($_GET['input']) && isset($_GET['offset'])) {
    include(__DIR__ . '/../include/openTerminal.php');
    echo json_encode($terminal->handleUpDown($_GET['input'], $_GET['offset']));
    include(__DIR__ . '/../include/closeTerminal.php');
}
