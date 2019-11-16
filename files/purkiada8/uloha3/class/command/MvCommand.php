<?php

class MvCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'mv';
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @return array string
     */
    public function doCommand($terminal, $environment, $input)
    {
        $args = resolveArgs($input, ['--help' => 'help'], true);
        if ($args['fail']) return array("result" => '<p>mv: ' . $args['reason'] . '</p>');
        if ($args['fail']) return array('result' => $args['reason']);
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>mv - přesunutí souboru nebo složky</p>"
                . "<p>použití: mv &lt;zdroj&gt; &lt;cíl&gt;</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);
        switch ($textArgsCount) {
            case 2:
                $sourcePath = $textArgs[0];
                $targetPath = $textArgs[1];
                break;
            default:
                return array('result' => "<p>mv: Nesprávný počet argumentů: požadováno 2, ale obdrženo $textArgsCount</p>");
        }

        $sourcePathResult = resolvePath($sourcePath, $environment, true, true, true);
        if ($sourcePathResult['fail']) {
            return array('result' => "<p>mv: Zpracovat zdroj: " . $sourcePathResult['reason'] . "</p>");
        }
        $file = $sourcePathResult['file'];
        if ($file === null) {
            return array('result' => "<p>mv: Nelze přesunout kořenový adresář</p>");
        }

        if ($targetPath[strlen($targetPath) - 1] === '/') {
            $targetPath .= $sourcePathResult['filename'];
        }
        $fileInfo = array('owner' => $file->owner, 'group' => $file->group,
            'permissions' => $file->permissions, 'content' => &$file->content);
        $targetPathResult = createFile($targetPath, $fileInfo, $environment, true, true, true, true);
        if ($targetPathResult['fail']) {
            return array('result' => "<p>mv: Vytvořit soubor: " . $targetPathResult['reason'] . "</p>");
        }

        if (!removeFile(array_values(array_slice($sourcePathResult['parents'], -1))[0]['content'], $file)) {
            return array('result' => "<p>mv: Nepodařílo se odstranit původní soubor (???)</p>");
        }

        return array();//success
    }
}
