<?php

class LnCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'ln';
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
        if ($args['fail']) return array("result" => '<p>ln: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>ln - vytvoří link (odkaz). Podobné zástupci ve Windows.</p>"
                . "<p>použití: ln &lt;soubor&gt; &lt;cíl&gt;</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);
        switch ($textArgsCount) {
            case 2:
                $filePath = $textArgs[0];
                $linkTargetPath = $textArgs[1];
                break;
            default:
                return array('result' => "<p>ln: Nesprávný počet argumentů: požadováno 2, ale obdrženo $textArgsCount</p>");
        }

        $linkTargetPathResult = resolvePath($linkTargetPath, $environment, true, true, true, false);
        if ($linkTargetPathResult['fail']) {
            return array('result' => "<p>ln: Zpracování cíle: " . $linkTargetPathResult['reason'] . "</p>");
        }

        $fileInfo = array('permissions' => 'l755', 'content' => [$linkTargetPathResult['path']]);
        $result = createFile($filePath, $fileInfo, $environment);
        if ($result['fail']) {
            return array('result' => "<p>ln: Vytvořit link: " . $result['reason'] . "</p>");
        }

        return array();//success
    }
}
