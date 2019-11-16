<?php

if (isset($_POST['content'])) {
    include(__DIR__ . '/../include/openTerminal.php');
    $terminal->backupContent($_POST['content']);
    include(__DIR__ . '/../include/closeTerminal.php');
}
