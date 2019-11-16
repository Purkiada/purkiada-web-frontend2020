<?php
$users = [];
$objectivesUsers = [[], [], [], [], [], []];
$backupUsers = [];
$noObjectiveUsers = [];
$unfairUsers = [];


$accountsDir = __DIR__ . '/data/accounts';
foreach (scandir($accountsDir) as $accountFileName) {
    if ($accountFileName === '.' || $accountFileName === '..') continue;
    $accountDir = $accountsDir . '/' . $accountFileName;

    $users[] = $accountFileName;
    $hasBackups = in_array('backup0', scandir($accountDir));
    if ($hasBackups) $backupUsers[] = $accountFileName;

    $objectivesDir = $accountDir . '/source/objectives';
    if (file_exists($objectivesDir)) {
        $objective = [file_exists($objectivesDir . '/1ConnectToWifi'),
            file_exists($objectivesDir . '/2ConnectToRepeater'),
            file_exists($objectivesDir . '/3ConnectToRouter'),
            file_exists($objectivesDir . '/4ConnectToServer'),
            file_exists($objectivesDir . '/5LoginAsRootInServer'),
            file_exists($objectivesDir . '/6DisableSecuritySystemsOnDeathStar')];

        $noObjective = !$objective[0] && !$objective[1] && !$objective[2]
            && !$objective[3] && !$objective[4] && !$objective[5];

        $unfair = ($objective[1] && (!$objective[0]))
            || ($objective[2] && (!$objective[1] || !$objective[0]))
            || ($objective[3] && (!$objective[2] || !$objective[1] || !$objective[0]))
            || ($objective[4] && (!$objective[3] || !$objective[2] || !$objective[1] || !$objective[0]))
            || ($objective[5] && (!$objective[4] || !$objective[3] || !$objective[2] || !$objective[1] || !$objective[0]));


        if ($objective[0]) $objectivesUsers[0][] = $accountFileName;
        if ($objective[1]) $objectivesUsers[1][] = $accountFileName;
        if ($objective[2]) $objectivesUsers[2][] = $accountFileName;
        if ($objective[3]) $objectivesUsers[3][] = $accountFileName;
        if ($objective[4]) $objectivesUsers[4][] = $accountFileName;
        if ($objective[5]) $objectivesUsers[5][] = $accountFileName;

        if ($noObjective) $noObjectiveUsers[] = $accountFileName;
        if ($unfair) $unfairUsers[] = $accountFileName;
    } else {
        $noObjectiveUsers[] = $accountFileName;
    }
}

echo 'Users: ' . count($users) . "\n\n";

echo 'No objectives: ' . count($noObjectiveUsers) . "\n";
echo 'Objective-1: ' . count($objectivesUsers[0]) . ' (1ConnectToWifi)' . "\n";
echo 'Objective-2: ' . count($objectivesUsers[1]) . ' (2ConnectToRepeater)' . "\n";
echo 'Objective-3: ' . count($objectivesUsers[2]) . ' (3ConnectToRouter)' . "\n";
echo 'Objective-4: ' . count($objectivesUsers[3]) . ' (4ConnectToServer)' . "\n";
echo 'Objective-5: ' . count($objectivesUsers[4]) . ' (5LoginAsRootInServer)' . "\n";
echo 'Objective-6: ' . count($objectivesUsers[5]) . ' (6DisableSecuritySystemsOnDeathStar)' . "\n\n";

echo 'No objective users: ';
print_r($noObjectiveUsers);
echo "\n" . 'Objective-1 users: ';
print_r($objectivesUsers[0]);
echo "\n" . 'Objective-2 users: '
;print_r($objectivesUsers[1]);
echo "\n" . 'Objective-3 users: ';
print_r($objectivesUsers[2]);
echo "\n" . 'Objective-4 users: ';
print_r($objectivesUsers[3]);
echo "\n" . 'Objective-5 users: ';
print_r($objectivesUsers[4]);
echo "\n" . 'Objective-6 users: ';
print_r($objectivesUsers[5]);

echo "\n\n" . 'Unfair users: ';
print_r($unfairUsers);

echo "\n\n" . 'Results: ';
sort($users);
foreach ($users as $user) {
    echo "\n";
    $points = 0;
    if (in_array($user, $objectivesUsers[0])) { echo '2 '; $points += 2; } else { echo '0 '; }
    if (in_array($user, $objectivesUsers[1])) { echo '2 '; $points += 2; } else { echo '0 '; }
    if (in_array($user, $objectivesUsers[2])) { echo '3 '; $points += 3; } else { echo '0 '; }
    if (in_array($user, $objectivesUsers[3])) { echo '3 '; $points += 3; } else { echo '0 '; }
    if (in_array($user, $objectivesUsers[4])) { echo '4 '; $points += 4; } else { echo '0 '; }
    if (in_array($user, $objectivesUsers[5])) { echo '2 '; $points += 2; } else { echo '0 '; }
    echo "$user = $points points";

    //$noObjective = in_array($user, $noObjectiveUsers);
    //if ($noObjective) echo ', so nothing';

    $unfair = in_array($user, $unfairUsers);
    if ($unfair) echo ', but there is something wrong with it';

    $backup = in_array($user, $backupUsers);
    if ($backup) echo ', but some backup is there';

    echo '.';
}

echo "\n\n"  .  'Done!';
