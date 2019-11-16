<?php

if (isset($terminal) && isset($_SESSION['controlPanelTerminal'])) {
    $terminal->getDevices()->saveChanges();
    $_SESSION['controlPanelTerminal'] = serialize($terminal);
    unset($terminal);
}

if (!TEST_MODE_ENABLED) restoreErrorHandler();
