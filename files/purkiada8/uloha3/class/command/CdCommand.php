<?php

class CdCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return "cd";
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
        if ($args['fail']) return array("result" => '<p>cd: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array("result" => "<p>cd - změní aktuální adresář</p>"
                . "<p>použití: cd &lt;adresář&gt;</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);
        if ($textArgsCount != 1) {
            return array("result" => "<p>cd: Nesprávný počet argumentů: požadováno 1, ale obdrženo $textArgsCount</p>");
        }

        $result = resolvePath($textArgs[0], $environment, true, true, false, ['d']);
        if ($result['fail']) {
            return array("result" => "<p>cd: " . $result['reason'] . "</p>");
        }

        $environment->setWorkingDirectory($result['path']);

        return array();//success
    }
}
