<?php

class PwdCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return "pwd";
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @return array string
     */
    public function doCommand($terminal, $environment, $input)
    {
        $args = resolveArgs($input, ['--help' => 'help'], false);
        if ($args['fail']) return array("result" => '<p>pwd: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array("result" => "<p>pwd - vypsání cesty do aktuální složky</p>"
                . "<p>použití: pwd</p>");
        }

        return array("result" => "<p>" . $environment->getWorkingDirectory() . "</p>");
    }
}
