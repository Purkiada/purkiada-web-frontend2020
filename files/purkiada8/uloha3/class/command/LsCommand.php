<?php

class LsCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return "ls";
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @return array string
     */
    public function doCommand($terminal, $environment, $input)
    {
        $args = resolveArgs($input, ['--help' => 'help', '-a' => 'all', '--all' => 'all', '-l' => 'longFormat'], true);
        if ($args['fail']) return array("result" => '<p>ls: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>ls - výpis souborů v adresáři</p>"
                . "<p>použití: ls [přepínače]... &lt;složka&gt;</p>"
                . "<p>Parametry:</p>"
                . "<p>&nbsp;&nbsp;&nbsp;&lt;složka&gt;&nbsp;&nbsp;- pokud není uvedena, použije se aktuální složka</p>"
                . "<p>Přepínače:</p>"
                . "<p>&nbsp;&nbsp;&nbsp;-a, --all&nbsp;- vypíše i skryté soubory</p>"
                . "<p>&nbsp;&nbsp;&nbsp;-l&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- vypíše detailnější výpis</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);
        switch ($textArgsCount) {
            case 0:
                $path = $environment->getWorkingDirectory();
                break;
            case 1:
                $path = $textArgs[0];
                break;
            default:
                return array('result' => "<p>ls: Nesprávný počet argumentů: požadováno 1 nebo 0, ale obdrženo $textArgsCount</p>");
        }

        $pathResult = resolvePath($path, $environment, true, true, false, ['d']);
        if ($pathResult['fail']) {
            return array('result' => "<p>ls: " . $pathResult['reason'] . "</p>");
        }

        $content = $pathResult['content'];
        if ($args['switchArgs']['all']) {
            $additionalFile1Target = $pathResult['file'];
            $additionalFile1 = new stdClass();
            $additionalFile1->name = '.';
            if ($additionalFile1Target == null) {
                $additionalFile1->owner = 'root';
                $additionalFile1->group = 'root';
                $additionalFile1->permissions = 'd755';
            } else {
                $additionalFile1->owner = $additionalFile1Target->owner;
                $additionalFile1->group = $additionalFile1Target->group;
                $additionalFile1->permissions = $additionalFile1Target->permissions;
            }
            $additionalFile1->content = $content;

            $additionalFile2TargetResult = resolvePath($path . '/..', $environment, true, true, false, ['d']);
            $additionalFile2 = new stdClass();
            $additionalFile2->name = '..';
            if ($additionalFile2TargetResult['fail'] || $additionalFile2TargetResult['file'] == null) {
                $additionalFile2->owner = 'root';
                $additionalFile2->group = 'root';
                $additionalFile2->permissions = 'd755';
                $additionalFile2->content = $additionalFile2TargetResult['fail'] ? []
                    : $additionalFile2TargetResult['content'];
            } else {
                $additionalFile2Target = $additionalFile2TargetResult['file'];
                $additionalFile2->owner = $additionalFile2Target->owner;
                $additionalFile2->group = $additionalFile2Target->group;
                $additionalFile2->permissions = $additionalFile2Target->permissions;
                $additionalFile2->content = $additionalFile2Target->content;
            }

            $content = array_merge([$additionalFile1, $additionalFile2], $content);
        }

        $result = "";
        if ($args['switchArgs']['longFormat']) {
            $maxOwnerLen = 0;
            $maxGroupLen = 0;
            foreach ($content as &$file) {
                if (!$args['switchArgs']['all'] && $file->name[0] == '.') continue;

                $maxOwnerLen = max($maxOwnerLen, strlen($file->owner));
                $maxGroupLen = max($maxGroupLen, strlen($file->group));
            }

            foreach ($content as &$file) {
                if (!$args['switchArgs']['all'] && $file->name[0] == '.') continue;

                $permissionsText = $file->permissions[0];
                $permissions = resolveFilePermissions($file);

                $permissionsText .= $permissions['owner']['read'] ? 'r' : '-';
                $permissionsText .= $permissions['owner']['write'] ? 'w' : '-';
                $permissionsText .= $permissions['owner']['execute'] ? 'x' : '-';

                $permissionsText .= $permissions['group']['read'] ? 'r' : '-';
                $permissionsText .= $permissions['group']['write'] ? 'w' : '-';
                $permissionsText .= $permissions['group']['execute'] ? 'x' : '-';

                $permissionsText .= $permissions['other']['read'] ? 'r' : '-';
                $permissionsText .= $permissions['other']['write'] ? 'w' : '-';
                $permissionsText .= $permissions['other']['execute'] ? 'x' : '-';

                $owner = htmlspecialchars($file->owner);
                while (strlen($owner) < $maxOwnerLen) {
                    $owner .= ' ';
                }
                $group = htmlspecialchars($file->group);
                while (strlen($group) < $maxGroupLen) {
                    $group .= ' ';
                }

                $styles = $this->resolveFileStyles($file);
                $name = htmlspecialchars($file->name);
                if ($file->permissions[0] == 'l') {
                    $linkTargetPath = implode($file->content);
                    $linkTargetPathResult = resolvePath($linkTargetPath, $environment, false, true, false);
                    if ($linkTargetPathResult['fail']) {
                        $linkTargetStyles = ['color' => 'lightcoral'];
                    } else {
                        $linkTargetFile = $linkTargetPathResult['file'];
                        if ($file == null) $linkTargetStyles = ['color' => 'royalblue'];
                        else $linkTargetStyles = $this->resolveFileStyles($linkTargetFile);
                    }
                    $name .= "<span style='color: white'> -> </span>"
                        . "<span style='";
                    foreach ($linkTargetStyles as $styleName => $styleVal) {
                        $name .= $styleName . ': ' . $styleVal . ';';
                    }
                    $name .= "'>" . htmlspecialchars($linkTargetPath) . "</span>";
                }

                $result .= "<p>$permissionsText $owner $group <span style='";
                foreach ($styles as $styleName => $styleVal) {
                    $result .= $styleName . ': ' . $styleVal . ';';
                }
                $result .= "'>$name</span></p>";
            }
        } else {
            $maxNameLen = 10;
            foreach ($content as &$file) {
                if (!$args['switchArgs']['all'] && $file->name[0] == '.') continue;

                $maxNameLen = max($maxNameLen, strlen($file->name));
            }

            $result .= '<p>';
            foreach ($content as &$file) {
                $name = htmlspecialchars($file->name);

                $styles = $this->resolveFileStyles($file);

                $result .= " <span style='";
                foreach ($styles as $styleName => $styleVal) {
                    $result .= $styleName . ': ' . $styleVal . ';';
                }
                $result .= "'>" . $name . '</span>';
                while (strlen($name) < $maxNameLen) {
                    $name .= ' ';
                    $result .= '&nbsp;';
                }
            }
            $result .= '</p>';
        }
        return array('result' => $result);
    }

    /**
     * @param $file object
     * @return array
     */
    private function resolveFileStyles($file) {
        switch ($file->permissions[0]) {
            case 'd':
                if (substr($file->permissions, 1) == '777') {
                    return ['color' => 'black', 'background-color' => 'limegreen'];
                }
                return ['color' => 'royalblue'];
            case 'l':
                return ['color' => 'deepskyblue'];
            case '-':
            default:
                return ['color' => 'white'];
        }
    }
}
