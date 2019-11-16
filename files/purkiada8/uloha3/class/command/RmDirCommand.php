<?php

class RmDirCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'rmdir';
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
        if ($args['fail']) return array("result" => '<p>rmdir: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>rmdir - odstranění prázdné složky</p>"
                . "<p>použití: rmdir &lt;složka&gt;</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);
        switch ($textArgsCount) {
            case 1:
                $path = $textArgs[0];
                break;
            default:
                return array('result' => "<p>rmdir: Nesprávný počet argumentů: požadováno 1, ale obdrženo $textArgsCount</p>");
        }

        $pathResult = resolvePath($path, $environment, true, true, true, ['d']);
        if ($pathResult['fail']) {
            return array('result' => "<p>rmdir: " . $pathResult['reason'] . "</p>");
        }
        $file = $pathResult['file'];
        if ($file === null) {
            return array('result' => "<p>rmdir: Nelze odstranit kořenový adresář</p>");
        }
        if (!empty($file->content)) {
            return array('result' => "<p>rmdir: Nelze odstranit složku $file->name: Složka není prázdná</p>");
        }

        if (!removeFile(array_values(array_slice($pathResult['parents'], -1))[0]['content'], $file)) {
            return array('result' => "<p>rmdir: Nepodařílo se odstranit složku</p>");
        }

        return array();//success
    }
}
