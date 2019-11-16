<?php

class RmCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'rm';
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @return array string
     */
    public function doCommand($terminal, $environment, $input)
    {
        $args = resolveArgs($input, ['--help' => 'help', '-r' => 'recursive', '--recursive' => 'recursive'], true);
        if ($args['fail']) return array("result" => '<p>rm: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>rm - odstranění souboru</p>"
                . "<p>použití: rm [přepínače]... &lt;soubor&gt;</p>"
                . "<p>Přepínače:</p>"
                . "<p>&nbsp;&nbsp;&nbsp;-r - rekurzivně, umožňuje odstranit složku i s jejím obsahem</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);
        switch ($textArgsCount) {
            case 1:
                $path = $textArgs[0];
                break;
            default:
                return array('result' => "<p>rm: Nesprávný počet argumentů: požadováno 1, ale obdrženo $textArgsCount</p>");
        }

        $pathResult = resolvePath($path, $environment, true, true, true,
            $args['switchArgs']['recursive'] ? ['d', 'l', '-'] : ['l', '-']);
        if ($pathResult['fail']) {
            return array('result' => "<p>rm: " . $pathResult['reason'] . "</p>");
        }
        $file = $pathResult['file'];
        if ($file === null) {
            return array('result' => "<p>rm: Nelze odstranit kořenový adresář</p>");
        }

        if (!removeFile(array_values(array_slice($pathResult['parents'], -1))[0]['content'], $file)) {
            return array('result' => "<p>rm: Nepodařílo se odstranit soubor nebo složku</p>");
        }

        return array();//success
    }
}
