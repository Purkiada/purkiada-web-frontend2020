<?php

class CatCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'cat';
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
        if ($args['fail']) return array("result" => '<p>cat: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>cat - Vypíše do terminálu obsah souboru</p>"
                . "<p>použití: cat &lt;soubor&gt;</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);
        switch ($textArgsCount) {
            case 1:
                $path = $textArgs[0];
                break;
            default:
                return array('result' => "<p>cat: Nesprávný počet argumentů: požadováno 1, ale obdrženo $textArgsCount</p>");
        }

        $pathResult = resolvePath($path, $environment, true, true, false, ['-']);
        if ($pathResult['fail']) {
            return array('result' => "<p>cat: " . $pathResult['reason'] . "</p>");
        }

        return array('result' => "<p>" . implode($pathResult['content']) . "</p>");
    }
}
