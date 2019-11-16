<?php

class MkDirCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'mkdir';
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
        if ($args['fail']) return array("result" => '<p>mkdir: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>mkdir - vytvoří složku</p>"
                . "<p>použití: mkdir &lt;složka&gt;</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);
        switch ($textArgsCount) {
            case 1:
                $dirPath = $textArgs[0];
                break;
            default:
                return array('result' => "<p>mkdir: Nesprávný počet argumentů: požadováno 1, ale obdrženo $textArgsCount</p>");
        }

        $fileInfo = array('permissions' => 'd755');
        $result = createFile($dirPath, $fileInfo, $environment, true);
        if ($result['fail']) {
            return array('result' => "<p>mkdir: " . $result['reason'] . "</p>");
        }

        return array();//success
    }
}
