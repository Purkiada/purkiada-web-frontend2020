<?php

$accountsDir = __DIR__ . '/data/accounts';
$accountsBackupsDir = __DIR__ . '/data/backups';
if (!file_exists($accountsBackupsDir)) mkdir($accountsBackupsDir);

$index = 0;
while (file_exists($accountsBackupsDir . '/backup' . $index)) {
    $index++;
}

rename($accountsDir, $accountsBackupsDir . '/backup' . $index);
mkdir($accountsDir);

echo 'Done!';
