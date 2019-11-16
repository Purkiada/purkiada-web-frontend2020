<?php

interface TerminalCommand
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @return array string
     */
    public function doCommand($terminal, $environment, $input);
}

/**
 * @param $input string
 * @return array
 */
function explodeArgs($input)
{
    $args = [];
    preg_match_all('/"(?:\\\\.|[^\\\\"])*"|\S+/', trim($input), $args);
    $args = $args[0];

    foreach ($args as &$arg) {
        $argLen = strlen($arg);
        if ($argLen >= 2 && $arg[0] == '"' && $arg[$argLen - 1] == '"') {
            $argLen -= 2;
            $arg = substr($arg, 1, $argLen);
        }
    }

    return $args;
}

/**
 * @param $input string
 * @param $argsDictionary array
 * @param $hasTextArgs bool
 * @return array
 */
function resolveArgs($input, $argsDictionary, $hasTextArgs = true)
{
    $args = explodeArgs($input);

    $fail = false;
    $reason = "";

    $switchArgs = [];
    foreach ($argsDictionary as $switchArg) {
        $switchArgs[$switchArg] = false;
    }
    $textArgs = [];


    foreach ($args as $arg) {
        $argLen = strlen($arg);
        if ($argLen == 0) continue;

        if ($argLen >= 2 && $arg[0] == "-") {
            if ($argLen >= 3 && $arg[1] == "-") {
                if (isset($argsDictionary[$arg])) {
                    $switchArgs[$argsDictionary[$arg]] = true;
                } else {
                    $reason = htmlspecialchars($arg) . ": Neznámý přepínač";
                    $fail = true;
                    break;
                }
            } else {
                foreach (str_split(substr($arg, 1)) as $charArg) {
                    if (isset($argsDictionary['-' . $charArg])) {
                        $switchArgs[$argsDictionary['-' . $charArg]] = true;
                    } else {
                        $reason = "-" . htmlspecialchars($charArg) . ": Neznámý přepínač";
                        $fail = true;
                        break;
                    }
                }
                if ($fail) break;
            }
        } else {
            if (!$hasTextArgs) {
                $reason = htmlspecialchars($arg) . ": Neznámý argument";
                $fail = true;
                break;
            }
            $textArgs[] = $arg;
        }
    }

    $result = array("fail" => $fail, "reason" => $reason);
    if (!$fail) {
        $result['switchArgs'] = $switchArgs;
        if ($hasTextArgs) $result['textArgs'] = $textArgs;
    }
    return $result;
}

/**
 * @param $path string
 * @param $environment EnvironmentInfo
 * @param $allowResolvingFromWorkingDirectory bool
 * @param $requiresReadPermission bool
 * @param $requiresWritePermission bool
 * @param $allowedResultFileTypes array
 * @return array
 */
function resolvePath($path, $environment, $allowResolvingFromWorkingDirectory = true, $requiresReadPermission = true, $requiresWritePermission = false, $allowedResultFileTypes = ['d', 'l', '-'])
{
    if (!$environment->getDeviceInfo()->hasFiles) {
        return array('fail' => true, 'reason' => htmlspecialchars($path) . ": "
            . "Složka nebo soubor nenalezen: Zařízení nepodporuje práci se soubory");
    }

    $target = $path;
    switch (empty($target) ? ' ' : $target[0]) {
        case '/':
            break;
        case '~':
            if (strlen($target) < 2 || $target[1] == '/') {
                $target = $environment->getActualUserInfo()->homeDirectory . substr($target, 1);
                break;
            }
        default:
            if (!$allowResolvingFromWorkingDirectory) {
                return array('fail' => true, 'reason' => htmlspecialchars($path) . ": Špatný formát cesty");
            }
            $target = $environment->getWorkingDirectory() . '/' . $target;
            break;
    }

    {
        $targetLen = strlen($target);
        while ($targetLen > 1 && $target[$targetLen - 1] == '/') {
            $targetLen -= 1;
            $target = substr($target, 0, $targetLen);
        }
    }

    $pathTmp = [];
    $startPos = 1;
    while ($startPos < strlen($target)) {
        $endPos = strpos($target, '/', $startPos);
        if ($endPos == $startPos) {
            $target = substr($target, 0, $startPos - 1) . substr($target, $endPos);
            continue;
        }

        $last = false;
        if ($endPos == false) {
            $endPos = strlen($target);
            $last = true;
        }

        $fileName = substr($target, $startPos, $endPos - $startPos);
        switch ($fileName) {
            case '.':
                $target = substr($target, 0, $startPos - 1) . substr($target, $endPos);
                if ($target == '') $target = '/';
                $startPos -= 1;
                $endPos = $startPos;
                break;
            case '..':
                if (!empty($pathTmp)) {
                    $oldStartPos = array_pop($pathTmp)['startPos'];
                    $target = substr($target, 0, $oldStartPos - 1) . substr($target, $endPos);
                    if ($target == '') $target = '/';
                    $startPos = $oldStartPos - 1;
                    $endPos = $startPos;
                } else {
                    $target = substr($target, 0, $startPos - 1) . substr($target, $endPos);
                    if ($target == '') $target = '/';
                    $startPos -= 1;
                    $endPos = $startPos;
                }
                break;
            default:
                if (empty($pathTmp)) $source = &$environment->getDeviceInfo()->files;
                else $source = &$pathTmp[count($pathTmp) - 1]['content'];
                $nextFile = null;
                foreach ($source as $file) {
                    if ($file->name == $fileName) {
                        $nextFile = $file;
                        break;
                    }
                }
                if ($nextFile == null) {
                    return array('fail' => true, 'reason' => htmlspecialchars($path) . ": "
                        . htmlspecialchars($target) . ": " . htmlspecialchars($fileName) . ": Složka nebo soubor nenalezen");
                }

                $username = $environment->getActualUserName();
                $groups = $environment->getActualUserInfo()->groups;
                $permissions = resolveFilePermissions($nextFile);
                $accessAllowed = true;
                if (!$environment->getActualUserInfo()->admin) {
                    if (!$last) {
                        $accessAllowed &= hasPermission($username, $groups, 'read', $permissions);
                    } else {
                        if ($requiresReadPermission) {
                            $accessAllowed &= hasPermission($username, $groups, 'read', $permissions);
                        }
                        if ($requiresWritePermission) {
                            $accessAllowed &= hasPermission($username, $groups, 'write', $permissions);
                        }
                    }
                }
                if (!$accessAllowed) {
                    return array('fail' => true, 'reason' => htmlspecialchars($path) . ": "
                        . htmlspecialchars($target) . ": " . htmlspecialchars($fileName) . ": Přístup k souboru nebo složce odepřen");
                }

                $fileType = $nextFile->permissions[0];
                if ($fileType == 'l' && (!$last || !in_array('l', $allowedResultFileTypes))) {
                    $resolverResult = resolvePath(implode($nextFile->content), $environment,
                        false, ($last ? $requiresReadPermission : true), ($last ? $requiresWritePermission : false),
                        ($last ? $allowedResultFileTypes : ['d']));
                    if ($resolverResult['fail']) {
                        return array('fail' => true, 'reason' => htmlspecialchars($path) . ": "
                            . htmlspecialchars($target) . ": " . htmlspecialchars($fileName) . ": Zpracování linku: "
                            . $resolverResult['reason']);
                    }
                    $nextFile = $resolverResult['file'];
                    $nextContent = &$resolverResult['content'];
                    $fileType = $nextFile != null ? $nextFile->permissions[0] : 'd';
                } else {
                    $nextContent = &$nextFile->content;
                }

                if ($last) {
                    if (!in_array($fileType, $allowedResultFileTypes)) {
                        return array('fail' => true, 'reason' => htmlspecialchars($path) . ": "
                            . htmlspecialchars($target) . ": " . htmlspecialchars($fileName) . ": Nesplňuje požadovaný typ souboru: "
                            . "Je to '" . fileTypeToString($fileType) . "', vyžadováno '"
                            . fileTypesToString($allowedResultFileTypes) . "'");
                    }
                } else {
                    switch ($fileType) {
                        case 'd':
                            break;
                        case '-':
                            return array('fail' => true, 'reason' => htmlspecialchars($path) . ": "
                                . htmlspecialchars($target) . ": " . htmlspecialchars($fileName) . ": Je soubor");
                        default:
                            return array('fail' => true, 'reason' => htmlspecialchars($path) . ": "
                                . htmlspecialchars($target) . ": " . htmlspecialchars($fileName) . ": Neznámý typ souboru");
                    }
                }
                $pathTmp[] = ['startPos' => $startPos, 'endPos' => $endPos,
                    'filename' => $fileName, 'file' => $nextFile, 'content' => &$nextContent];
                break;
        }
        $startPos = $endPos + 1;
    }

    if (empty($pathTmp)) {
        if (!in_array('d', $allowedResultFileTypes)) {
            return array('fail' => true, 'reason' => htmlspecialchars($path) . ": "
                . htmlspecialchars($target) . ": Nesplňuje požadovaný typ souboru: "
                . "Je to '" . fileTypeToString('d') . "', vyžadováno '"
                . fileTypesToString($allowedResultFileTypes) . "'");
        }

        $accessAllowed = true;
        if (!$environment->getActualUserInfo()->admin) {
            /*if ($requiresReadPermission) {
                $accessAllowed &= true;
            }*/
            if ($requiresWritePermission) {
                $accessAllowed &=
                    in_array('root', $environment->getActualUserInfo()->groups)
                    || $environment->getActualUserName() == 'root';
            }
        }
        if (!$accessAllowed) {
            return array('fail' => true, 'reason' => htmlspecialchars($path) . ": "
                . htmlspecialchars($target) . ": Přístup k souboru nebo složce odepřen");
        }

        $filename = '';
        $targetFile = null;
        $targetContent = &$environment->getDeviceInfo()->files;
    } else {
        $lastTmpEntry = array_pop($pathTmp);
        $filename = $lastTmpEntry['filename'];
        $targetFile = $lastTmpEntry['file'];
        $targetContent = &$lastTmpEntry['content'];
    }

    $parents = [];
    foreach ($pathTmp as $parent) {
        $parents[] = ['file' => $parent['file'], 'content' => &$parent['content']];
    }
    $parents = array_merge([['file' => null, 'content' => &$environment->getDeviceInfo()->files]], $parents);

    return array('fail' => false, 'reason' => '', 'path' => $target, 'filename' => $filename,
        'file' => $targetFile, 'content' => &$targetContent, 'parents' => &$parents);
}

/**
 * @param $path string
 * @param $fileInfo array
 * @param $environment EnvironmentInfo
 * @param $allowResolvingFromWorkingDirectory bool
 * @param $requiresReadPermission bool
 * @param $requiresWritePermission bool
 * @param $onlyIfNotExists bool
 * @param $replaceContent bool
 * @return array
 */
function createFile($path, $fileInfo, $environment, $allowResolvingFromWorkingDirectory = true, $requiresReadPermission = true, $requiresWritePermission = true, $onlyIfNotExists = true, $replaceContent = false)
{
    if (!isset($fileInfo['owner'])) $fileInfo['owner'] = $environment->getActualUserName();
    if (!isset($fileInfo['group'])) $fileInfo['group'] = $environment->getActualUserName();
    if (!isset($fileInfo['permissions'])) $fileInfo['permissions'] = '-755';
    if (!isset($fileInfo['content'])) $fileInfo['content'] = [];

    if (isset($fileInfo['name'])) {
        $filename = $fileInfo['name'];
        $dirPath = $path;
    } else {
        $pathLen = strlen($path);
        while ($pathLen > 1 && $path[$pathLen - 1] == '/') {
            $path = substr($path, 0, --$pathLen);
        }
        $filename = array_values(array_slice(explode('/', $path), -1))[0];
        $dirPath = substr($path, 0, strlen($path) - strlen($filename));
        if (empty($dirPath)) $dirPath = '.';
    }

    if (empty($filename)) {
        return array('fail' => true, 'reason' => htmlspecialchars($dirPath) . ": "
            . htmlspecialchars($filename) . ": Nelze vytvořit soubor s prázdným jménem");
    }

    if (ctype_space($filename[0]) || ctype_space($filename[strlen($filename) - 1])) {
        return array('fail' => true, 'reason' => htmlspecialchars($dirPath) . ": "
            . htmlspecialchars($filename) . ": Název souboru nesmí končit ani začínat prázdným znakem");
    }

    if (strlen($filename) > 255) {
        return array('fail' => true, 'reason' => htmlspecialchars($dirPath) . ": "
            . htmlspecialchars($filename) . ": Název souboru je příliš dlouhý, maximum je 255 znaků");
    }

    if (containsAny($filename, ['/', '\\', '?', '%', '*', ':', '|', '"', '<', '>', "\n", "\r"])) {
        return array('fail' => true, 'reason' => htmlspecialchars($dirPath) . ": "
            . htmlspecialchars($filename) . ": Název souboru obsahuje nepovolené znaky");
    }

    $pathResult = resolvePath($dirPath . '/' . $filename, $environment, $allowResolvingFromWorkingDirectory,
        $requiresReadPermission, $requiresWritePermission);
    if (!$pathResult['fail']) {
        if ($onlyIfNotExists) {
            return array('fail' => true, 'reason' => htmlspecialchars($dirPath) . ": "
                . htmlspecialchars($filename) . ": Soubor již existuje");
        } elseif ($fileInfo['permissions'][0] != $pathResult['file']->permissions[0]) {
            return array('fail' => true, 'reason' => htmlspecialchars($dirPath) . ": "
                . htmlspecialchars($filename) . ": Nesplňuje požadovaný typ souboru: "
                . "Je to '" . fileTypeToString($pathResult['file']->permissions[0]) . "', vyžadováno '"
                . fileTypeToString($fileInfo['permissions'][0]) . "'");
        } else {
            if ($replaceContent) {
                $pathResult['file']->content = $fileInfo['content'];
            }
            return array('fail' => false, 'reason' => '', 'path' => $pathResult['path'], 'file' => $pathResult['file']);
        }
    } else {
        if ($requiresWritePermission || $requiresReadPermission) {
            $pathResult = resolvePath($dirPath . '/' . $filename, $environment, $allowResolvingFromWorkingDirectory, false, false);
            if (!$pathResult['fail']) {
                return array('fail' => true, 'reason' => htmlspecialchars($dirPath) . ": "
                    . htmlspecialchars($filename) . ": Přístup k souboru nebo složce odepřen");
            }
        }

        $dirPathResult = resolvePath($dirPath, $environment, $allowResolvingFromWorkingDirectory, true, true, ['d']);
        if ($dirPathResult['fail']) {
            return array('fail' => true, 'reason' => $dirPathResult['reason']);
        }

        $newFile = new stdClass();
        $newFile->name = $filename;
        $newFile->owner = $fileInfo['owner'];
        $newFile->group = $fileInfo['group'];
        $newFile->permissions = $fileInfo['permissions'];
        $newFile->content = &$fileInfo['content'];

        $dirPathResult['content'][] = $newFile;
        usort($dirPathResult['content'], function ($a, $b) {
            return strcmp(strtolower($a->name), strtolower($b->name));
        });

        return array('fail' => false, 'reason' => '', 'path' => $dirPathResult['path'] . '/' . $filename, 'file' => $newFile);
    }
}

/**
 * @param $dirContent array
 * @param $file object
 * @return bool
 */
function removeFile(&$dirContent, $file)
{
    if (($key = array_search($file, $dirContent, true)) === false) return false;

    array_splice($dirContent, $key, 1);
    return true;

}

/**
 * @param $fileType string
 * @return string
 */
function fileTypeToString($fileType)
{
    switch ($fileType) {
        case 'd':
            return 'Složka';
        case 'l':
            return 'Odkaz';
        case '-':
            return 'Soubor';
        default:
            return 'Neznámý typ souboru';
    }
}

/**
 * @param $fileTypes array string
 * @return string
 */
function fileTypesToString($fileTypes)
{
    if (count($fileTypes) == 1) return fileTypeToString($fileTypes[0]);

    $result = '';
    foreach ($fileTypes as $fileType) {
        $result .= '|' . fileTypeToString($fileType);
    }

    if (strlen($result) > 0) $result = substr($result, 1);

    return $result;
}

function containsAny($string, array $arr)
{
    foreach ($arr as $a) {
        if (stripos($string, $a) !== false) return true;
    }
    return false;
}

/**
 * @param $permissions string
 * @return bool
 */
function validateFilePermissions($permissions)
{
    if (strlen($permissions) != 4) return false;
    $allowedFileTypes = ['d', 'l', '-'];
    if (!in_array($permissions[0], $allowedFileTypes)) return false;

    if (((string) ((int) $permissions[1])) !== $permissions[1] || ((int)$permissions[1] != 0 && ((int)$permissions[1] < 4 || (int)$permissions[1] > 7))) return false;
    if (((string) ((int) $permissions[2])) !== $permissions[2] || ((int)$permissions[2] != 0 && ((int)$permissions[2] < 4 || (int)$permissions[2] > 7))) return false;
    if (((string) ((int) $permissions[3])) !== $permissions[3] || ((int)$permissions[3] != 0 && ((int)$permissions[3] < 4 || (int)$permissions[3] > 7))) return false;

    return true;
}

/**
 * @param $permissions string
 * @return bool
 */
function validateShortFilePermissions($permissions)
{
    if (strlen($permissions) != 3) return false;

    if (((string) ((int) $permissions[0])) !== $permissions[0] || ((int)$permissions[0] != 0 && ((int)$permissions[0] < 4 || (int)$permissions[0] > 7))) return false;
    if (((string) ((int) $permissions[1])) !== $permissions[1] || ((int)$permissions[1] != 0 && ((int)$permissions[1] < 4 || (int)$permissions[1] > 7))) return false;
    if (((string) ((int) $permissions[2])) !== $permissions[2] || ((int)$permissions[2] != 0 && ((int)$permissions[2] < 4 || (int)$permissions[2] > 7))) return false;

    return true;
}

/**
 * @param $file object
 * @return array
 */
function resolveFilePermissions($file)
{
    $result = [];
    $result['owner'] = ['name' => $file->owner];
    $result['group'] = ['name' => $file->group];
    $result['other'] = ['name' => 'other'];

    $permissions = str_split(substr($file->permissions, 1));
    $ownerBin = decbin($permissions[0]);
    while (strlen($ownerBin) < 3) {
        $ownerBin = '0' . $ownerBin;
    }
    $result['owner']['read'] = $ownerBin[0] === '1';
    $result['owner']['write'] = $ownerBin[1] === '1';
    $result['owner']['execute'] = $ownerBin[2] === '1';

    $groupBin = decbin($permissions[1]);
    while (strlen($groupBin) < 3) {
        $groupBin = '0' . $groupBin;
    }
    $result['group']['read'] = $groupBin[0] === '1';
    $result['group']['write'] = $groupBin[1] === '1';
    $result['group']['execute'] = $groupBin[2] === '1';

    $otherBin = decbin($permissions[2]);
    while (strlen($otherBin) < 3) {
        $otherBin = '0' . $otherBin;
    }
    $result['other']['read'] = $otherBin[0] === '1';
    $result['other']['write'] = $otherBin[1] === '1';
    $result['other']['execute'] = $otherBin[2] === '1';

    return $result;
}

/**
 * @param $userName string
 * @param $groups array string
 * @param $permissionName string
 * @param $permissions array
 * @return bool
 */
function hasPermission($userName, $groups, $permissionName, $permissions) {
    return $permissions['other'][$permissionName]
        || (in_array($permissions['group']['name'], $groups) && $permissions['group'][$permissionName])
        || ($userName == $permissions['owner']['name'] && $permissions['owner'][$permissionName]);
}

/**
 * @param $terminal Terminal
 * @param $environment EnvironmentInfo
 * @return array
 */
function resolveNetwork($terminal, $environment)
{
    $result = [];

    $result['localhost']['localhost'] = [
        'allowChange' => false,
        'enabled' => true,
        'info' => new stdClass(),
        'lan' => [
            'localhost' => $environment->getDeviceHandler(),
            '127.0.0.1' => $environment->getDeviceHandler()
        ]
    ];

    $devices = $terminal->getDevices();
    $networks = &$environment->getDeviceInfo()->network;
    foreach ($networks as $networkStatus) {
        $network = $devices->getNetworkHandlerById($networkStatus->id);
        if ($network == null) continue;

        $networkInfo = $network->getNetworkInfo();
        if (!isset($result[$networkInfo->type])) $result[$networkInfo->type] = [];
        if (!isset($result[$networkInfo->type][$networkInfo->id])) $result[$networkInfo->type][$networkInfo->id] = [];

        $enabled = $networkStatus->enabled;
        $result[$networkInfo->type][$networkInfo->id]['allowChange'] = $networkStatus->allowChange;
        $result[$networkInfo->type][$networkInfo->id]['enabled'] = $enabled;
        $result[$networkInfo->type][$networkInfo->id]['info'] = $networkInfo;
        $result[$networkInfo->type][$networkInfo->id]['status'] = $networkStatus;
        if (!$enabled) continue;

        $result[$networkInfo->type][$networkInfo->id]['lan'] = [];
        foreach ($networkInfo->lan as $lanTarget) {
            $lanTargetInfo = explode('|', $lanTarget);
            if (count($lanTargetInfo) != 2) continue;
            $targetDevice = $devices->getDeviceHandlerByName($lanTargetInfo[1]);
            if ($targetDevice !== null && !getNetworkStatusByNetworkId($targetDevice, $networkStatus->id)->enabled) continue;
            $result[$networkInfo->type][$networkInfo->id]['lan'][$lanTargetInfo[0]]
                = $targetDevice !== null ? $targetDevice : $lanTargetInfo[1];
        }
    }

    return $result;
}

/**
 * @param $deviceHandler DeviceHandler
 * @param $networkId
 * @return object|null
 */
function getNetworkStatusByNetworkId($deviceHandler, $networkId) {
    $networks = $deviceHandler->getDeviceInfo()->network;
    foreach ($networks as $networkStatus) {
        if ($networkStatus->id != $networkId) continue;
        return $networkStatus;
    }
    return null;
}

/**
 * @param $terminal Terminal
 * @param $deviceHandler DeviceHandler
 * @param $username string
 * @param $password string
 * @param $command string
 * @param $removeCurrentInputProcessor bool
 * @return array
 */
function processLogin($terminal, $deviceHandler, $username, $password = '', $command = 'bash', $removeCurrentInputProcessor = false)
{
    if ($terminal->getDevices()->validateLoginRequest($deviceHandler, $username, $password)) {
        $additionalOutput = $removeCurrentInputProcessor ? $terminal->removeTopInputProcessor() . '<br>' : '';
        $result = array('fail' => false, 'reason' => '', 'result' =>
            (new EnvironmentInfo($terminal, $deviceHandler, $username))->executeCommand($terminal, $command));

        if (!isset($result['result']['result'])) $result['result']['result'] = $additionalOutput;
        else $result['result']['result'] = $additionalOutput . $result['result']['result'];
        return $result;
    }
    return array('fail' => true, 'reason' => 'Špatné uživatelské jméno, nebo heslo');
}
