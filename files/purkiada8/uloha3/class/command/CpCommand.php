<?php

class CpCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'cp';
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
        if ($args['fail']) return array("result" => '<p>cp: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>cp - zkopírování soubouru či složky</p>"
                . "<p>použití: cp &lt;zdroj&gt; &lt;destinace&gt;</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);
        switch ($textArgsCount) {
            case 2:
                $sourcePath = $textArgs[0];
                $targetPath = $textArgs[1];
                break;
            default:
                return array('result' => "<p>cp: Nesprávný počet argumentů: požadováno 2, ale obdrženo $textArgsCount</p>");
        }

        $sourcePathResult = resolvePath($sourcePath, $environment, true, true, true);
        if ($sourcePathResult['fail']) {
            return array('result' => "<p>cp: Zpracovat zdroj: " . $sourcePathResult['reason'] . "</p>");
        }
        $file = $sourcePathResult['file'];
        if ($file === null) {
            return array('result' => "<p>cp: Nelze zkopírovat kořenový adresář</p>");
        }

        if ($targetPath[strlen($targetPath) - 1] === '/') {
            $targetPath .= $sourcePathResult['filename'];
        }
        $fileInfo = array('owner' => $file->owner, 'group' => $file->group,
            'permissions' => $file->permissions, 'content' => $file->content);
        $targetPathResult = createFile($targetPath, $fileInfo, $environment, true, true, true, true);
        if ($targetPathResult['fail']) {
            return array('result' => "<p>cp: Zpracovat cíl: " . $targetPathResult['reason'] . "</p>");
        }

        return array();//success
    }
}
